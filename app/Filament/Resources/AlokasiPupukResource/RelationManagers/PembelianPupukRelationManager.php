<?php

namespace App\Filament\Resources\AlokasiPupukResource\RelationManagers;

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
use Illuminate\Support\Collection;

class PembelianPupukRelationManager extends RelationManager
{
    protected static string $relationship = 'pembelianPupuks';

    protected static ?string $recordTitleAttribute = 'id';
    
    protected static ?string $title = 'Pembelian Pupuk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('petani_id')
                    ->relationship('petani', 'nama')
                    ->label('Petani')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nik')
                            ->required()
                            ->unique()
                            ->maxLength(16),
                        Select::make('kelompok_tani_id')
                            ->relationship('kelompokTani', 'nama')
                            ->required()
                            ->searchable(),
                        TextInput::make('no_telepon')
                            ->maxLength(15),
                        TextInput::make('alamat')
                            ->maxLength(255),
                    ]),
                    
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
                    ->default(function ($livewire) {
                        // Get the parent record (AlokasiPupuk)
                        $alokasi = $livewire->ownerRecord;
                        // Get the associated pupuk's price
                        return $alokasi->pupuk->harga;
                    })
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
                    
                TextColumn::make('petani.nama')
                    ->label('Petani')
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
                    
                Tables\Filters\SelectFilter::make('petani_id')
                    ->relationship('petani', 'nama')
                    ->label('Petani')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, $livewire): array {
                        // Set the pupuk_id from the parent record (AlokasiPupuk)
                        $alokasi = $livewire->ownerRecord;
                        $data['pupuk_id'] = $alokasi->pupuk_id;
                        $data['alokasi_pupuk_id'] = $alokasi->id;
                        
                        // Calculate total price
                        $data['total_harga'] = $data['jumlah'] * $data['harga_satuan'];
                        return $data;
                    })
                    ->using(function (array $data, $livewire): \App\Models\PembelianPupuk {
                        // Get the parent record (AlokasiPupuk)
                        $alokasi = $livewire->ownerRecord;
                        
                        // Check if the jumlah exceeds remaining allocation
                        $remaining = $alokasi->jumlah_alokasi - $alokasi->jumlah_diambil;
                        if ($data['jumlah'] > $remaining) {
                            throw new \Exception("Jumlah melebihi sisa alokasi ({$remaining}).");
                        }
                        
                        // Check if there's enough stock
                        $pupuk = $alokasi->pupuk;
                        if ($data['jumlah'] > $pupuk->stok) {
                            throw new \Exception("Stok pupuk tidak cukup. Sisa stok: {$pupuk->stok}.");
                        }
                        
                        // Create the purchase record
                        $purchase = \App\Models\PembelianPupuk::create($data);
                        
                        // Update the stock
                        $pupuk->decrement('stok', $data['jumlah']);
                        
                        // Update the allocation status
                        $alokasi->increment('jumlah_diambil', $data['jumlah']);
                        if ($alokasi->jumlah_diambil >= $alokasi->jumlah_alokasi) {
                            $alokasi->update(['status' => 'selesai']);
                        } else {
                            $alokasi->update(['status' => 'sebagian']);
                        }
                        
                        return $purchase;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Recalculate total price
                        $data['total_harga'] = $data['jumlah'] * $data['harga_satuan'];
                        return $data;
                    })
                    ->using(function (array $data, \App\Models\PembelianPupuk $record, $livewire): \App\Models\PembelianPupuk {
                        // Get the parent record (AlokasiPupuk)
                        $alokasi = $livewire->ownerRecord;
                        
                        // Calculate the difference in quantity
                        $difference = $data['jumlah'] - $record->jumlah;
                        
                        // Check if the change would exceed remaining allocation
                        if ($difference > 0) {
                            $remaining = $alokasi->jumlah_alokasi - $alokasi->jumlah_diambil;
                            if ($difference > $remaining) {
                                throw new \Exception("Jumlah melebihi sisa alokasi ({$remaining}).");
                            }
                            
                            // Check if there's enough stock
                            $pupuk = $alokasi->pupuk;
                            if ($difference > $pupuk->stok) {
                                throw new \Exception("Stok pupuk tidak cukup. Sisa stok: {$pupuk->stok}.");
                            }
                        }
                        
                        // Update the record
                        $record->update($data);
                        
                        // Update the pupuk stock
                        if ($difference != 0) {
                            $pupuk = $alokasi->pupuk;
                            if ($difference > 0) {
                                $pupuk->decrement('stok', $difference);
                            } else {
                                $pupuk->increment('stok', abs($difference));
                            }
                            
                            // Update the allocation
                            if ($difference > 0) {
                                $alokasi->increment('jumlah_diambil', $difference);
                            } else {
                                $alokasi->decrement('jumlah_diambil', abs($difference));
                            }
                            
                            // Update the allocation status
                            if ($alokasi->jumlah_diambil >= $alokasi->jumlah_alokasi) {
                                $alokasi->update(['status' => 'selesai']);
                            } elseif ($alokasi->jumlah_diambil > 0) {
                                $alokasi->update(['status' => 'sebagian']);
                            } else {
                                $alokasi->update(['status' => 'belum_diambil']);
                            }
                        }
                        
                        return $record;
                    }),
                    
                Tables\Actions\DeleteAction::make()
                    ->using(function (\App\Models\PembelianPupuk $record, $livewire): void {
                        // Get the parent record (AlokasiPupuk)
                        $alokasi = $livewire->ownerRecord;
                        
                        // Update the pupuk stock
                        $pupuk = $alokasi->pupuk;
                        $pupuk->increment('stok', $record->jumlah);
                        
                        // Update the allocation
                        $alokasi->decrement('jumlah_diambil', $record->jumlah);
                        
                        // Update the allocation status
                        if ($alokasi->jumlah_diambil <= 0) {
                            $alokasi->update(['status' => 'belum_diambil']);
                        } elseif ($alokasi->jumlah_diambil < $alokasi->jumlah_alokasi) {
                            $alokasi->update(['status' => 'sebagian']);
                        }
                        
                        // Delete the record
                        $record->delete();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->using(function (Collection $records, $livewire): void {
                            // Get the parent record (AlokasiPupuk)
                            $alokasi = $livewire->ownerRecord;
                            
                            // For each record being deleted
                            foreach ($records as $record) {
                                // Update the pupuk stock
                                $pupuk = $alokasi->pupuk;
                                $pupuk->increment('stok', $record->jumlah);
                                
                                // Update the allocation
                                $alokasi->decrement('jumlah_diambil', $record->jumlah);
                                
                                // Delete the record
                                $record->delete();
                            }
                            
                            // Update the allocation status
                            if ($alokasi->jumlah_diambil <= 0) {
                                $alokasi->update(['status' => 'belum_diambil']);
                            } elseif ($alokasi->jumlah_diambil < $alokasi->jumlah_alokasi) {
                                $alokasi->update(['status' => 'sebagian']);
                            }
                        }),
                ]),
            ]);
    }
}