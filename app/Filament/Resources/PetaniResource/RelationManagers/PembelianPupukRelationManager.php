<?php

namespace App\Filament\Resources\PetaniResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PembelianPupukRelationManager extends RelationManager
{
    protected static string $relationship = 'pembelianPupuks';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pupuk_id')
                    ->relationship('pupuk', 'nama')
                    ->label('Pupuk')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Get the price of the selected fertilizer
                        if ($state) {
                            $pupuk = \App\Models\Pupuk::find($state);
                            $set('harga_satuan', $pupuk->harga);
                        }
                    }),
                    
                Select::make('alokasi_pupuk_id')
                    ->relationship('alokasiPupuk', 'id')
                    ->label('Alokasi Pupuk')
                    ->optionsQuery(function (Builder $query, callable $get) {
                        // Filter allocations based on the selected fertilizer
                        if ($pupukId = $get('pupuk_id')) {
                            return $query->where('pupuk_id', $pupukId);
                        }
                        
                        return $query;
                    })
                    ->searchable()
                    ->nullable(),
                    
                TextInput::make('jumlah')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->label('Jumlah')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state && $get('harga_satuan')) {
                            $set('total_harga', $state * $get('harga_satuan'));
                        }
                    }),
                    
                TextInput::make('harga_satuan')
                    ->numeric()
                    ->required()
                    ->label('Harga Satuan')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        if ($state && $get('jumlah')) {
                            $set('total_harga', $state * $get('jumlah'));
                        }
                    }),
                    
                TextInput::make('total_harga')
                    ->numeric()
                    ->required()
                    ->disabled()
                    ->label('Total Harga'),
                    
                DatePicker::make('tanggal_pembelian')
                    ->required()
                    ->label('Tanggal Pembelian')
                    ->default(now()),
                    
                Select::make('metode_pembayaran')
                    ->options([
                        'tunai' => 'Tunai',
                        'transfer' => 'Transfer',
                    ])
                    ->default('tunai')
                    ->required()
                    ->label('Metode Pembayaran'),
                    
                Select::make('status_pembayaran')
                    ->options([
                        'lunas' => 'Lunas',
                        'hutang' => 'Hutang',
                    ])
                    ->default('lunas')
                    ->required()
                    ->label('Status Pembayaran'),
                    
                TextInput::make('no_bukti')
                    ->maxLength(50)
                    ->label('Nomor Bukti'),
                    
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(3)
                    ->maxLength(500),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('pupuk.nama')
                    ->label('Pupuk')
                    ->searchable(),
                    
                TextColumn::make('jumlah')
                    ->label('Jumlah'),
                    
                TextColumn::make('harga_satuan')
                    ->money('IDR')
                    ->label('Harga Satuan'),
                    
                TextColumn::make('total_harga')
                    ->money('IDR')
                    ->label('Total Harga')
                    ->sortable(),
                    
                TextColumn::make('tanggal_pembelian')
                    ->date()
                    ->sortable()
                    ->label('Tanggal Pembelian'),
                    
                TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran'),
                    
                TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'lunas' => 'success',
                        'hutang' => 'danger',
                        default => 'warning',
                    })
                    ->label('Status Pembayaran'),
                    
                TextColumn::make('no_bukti')
                    ->label('Nomor Bukti')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->options([
                        'lunas' => 'Lunas',
                        'hutang' => 'Hutang',
                    ])
                    ->label('Status Pembayaran'),
                    
                Tables\Filters\SelectFilter::make('metode_pembayaran')
                    ->options([
                        'tunai' => 'Tunai',
                        'transfer' => 'Transfer',
                    ])
                    ->label('Metode Pembayaran'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Calculate total price
                        $data['total_harga'] = $data['jumlah'] * $data['harga_satuan'];
                        return $data;
                    })
                    ->after(function ($record) {
                        // Update pupuk stock
                        $pupuk = \App\Models\Pupuk::find($record->pupuk_id);
                        $pupuk->decrement('stok', $record->jumlah);
                        
                        // If related to an allocation, update the allocation
                        if ($record->alokasi_pupuk_id) {
                            $alokasi = \App\Models\AlokasiPupuk::find($record->alokasi_pupuk_id);
                            $alokasi->increment('jumlah_diambil', $record->jumlah);
                            
                            // Update the status based on the taken amount
                            if ($alokasi->jumlah_diambil >= $alokasi->jumlah_alokasi) {
                                $alokasi->update(['status' => 'selesai']);
                            } elseif ($alokasi->jumlah_diambil > 0) {
                                $alokasi->update(['status' => 'sebagian']);
                            }
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Recalculate total price
                        $data['total_harga'] = $data['jumlah'] * $data['harga_satuan'];
                        return $data;
                    })
                    ->before(function ($record, $data) {
                        // Store the original jumlah to calculate the difference
                        $record->original_jumlah = $record->jumlah;
                    })
                    ->after(function ($record, $data) {
                        // Calculate the difference in quantity
                        $difference = $record->jumlah - $record->original_jumlah;
                        
                        if ($difference != 0) {
                            // Update the stock
                            $pupuk = \App\Models\Pupuk::find($record->pupuk_id);
                            $pupuk->decrement('stok', $difference);
                            
                            // If related to an allocation, update the allocation
                            if ($record->alokasi_pupuk_id) {
                                $alokasi = \App\Models\AlokasiPupuk::find($record->alokasi_pupuk_id);
                                $alokasi->increment('jumlah_diambil', $difference);
                                
                                // Update the status based on the taken amount
                                if ($alokasi->jumlah_diambil >= $alokasi->jumlah_alokasi) {
                                    $alokasi->update(['status' => 'selesai']);
                                } elseif ($alokasi->jumlah_diambil > 0) {
                                    $alokasi->update(['status' => 'sebagian']);
                                } else {
                                    $alokasi->update(['status' => 'belum_diambil']);
                                }
                            }
                        }
                    }),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // When deleting, add back to stock
                        $pupuk = \App\Models\Pupuk::find($record->pupuk_id);
                        $pupuk->increment('stok', $record->jumlah);
                        
                        // If related to an allocation, update the allocation
                        if ($record->alokasi_pupuk_id) {
                            $alokasi = \App\Models\AlokasiPupuk::find($record->alokasi_pupuk_id);
                            $alokasi->decrement('jumlah_diambil', $record->jumlah);
                            
                            // Update the status based on the taken amount
                            if ($alokasi->jumlah_diambil <= 0) {
                                $alokasi->update(['status' => 'belum_diambil']);
                            } elseif ($alokasi->jumlah_diambil < $alokasi->jumlah_alokasi) {
                                $alokasi->update(['status' => 'sebagian']);
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // For each record being deleted
                            foreach ($records as $record) {
                                // Add back to stock
                                $pupuk = \App\Models\Pupuk::find($record->pupuk_id);
                                $pupuk->increment('stok', $record->jumlah);
                                
                                // If related to an allocation, update the allocation
                                if ($record->alokasi_pupuk_id) {
                                    $alokasi = \App\Models\AlokasiPupuk::find($record->alokasi_pupuk_id);
                                    $alokasi->decrement('jumlah_diambil', $record->jumlah);
                                    
                                    // Update the status based on the taken amount
                                    if ($alokasi->jumlah_diambil <= 0) {
                                        $alokasi->update(['status' => 'belum_diambil']);
                                    } elseif ($alokasi->jumlah_diambil < $alokasi->jumlah_alokasi) {
                                        $alokasi->update(['status' => 'sebagian']);
                                    }
                                }
                            }
                        }),
                ]),
            ]);
    }
}