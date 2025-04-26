<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembelianPupukResource\Pages;
use App\Filament\Resources\PembelianPupukResource\RelationManagers;
use App\Models\PembelianPupuk;
use App\Models\AlokasiPupuk;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class PembelianPupukResource extends Resource
{
    protected static ?string $model = PembelianPupuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?string $navigationLabel = 'Pembelian Pupuk';
    
    protected static ?string $modelLabel = 'Pembelian Pupuk';
    
    protected static ?string $pluralLabel = 'Pembelian Pupuk';
    
    protected static ?string $slug = 'pembelian-pupuk';
    
    protected static ?string $navigationGroup = 'Distribusi';
    
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('petani_id')
                            ->relationship('petani', 'nama')
                            ->label('Petani')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Reset allocation when farmer changes
                                $set('alokasi_pupuk_id', null);
                            })
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
                            
                        Select::make('pupuk_id')
                            ->relationship('pupuk', 'nama')
                            ->label('Pupuk')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Reset allocation when fertilizer changes
                                $set('alokasi_pupuk_id', null);
                                
                                // Set the default price
                                if ($state) {
                                    $pupuk = \App\Models\Pupuk::find($state);
                                    $set('harga_satuan', $pupuk->harga);
                                }
                            }),
                            
                        Select::make('alokasi_pupuk_id')
                            ->label('Alokasi (Opsional)')
                            ->options(function (callable $get) {
                                $petaniId = $get('petani_id');
                                $pupukId = $get('pupuk_id');
                                
                                if (!$petaniId || !$pupukId) {
                                    return [];
                                }
                                
                                // Get kelompok tani id for the selected petani
                                $petani = \App\Models\Petani::find($petaniId);
                                if (!$petani) {
                                    return [];
                                }
                                
                                // Get allocations for the kelompok tani and pupuk
                                return AlokasiPupuk::where('kelompok_tani_id', $petani->kelompok_tani_id)
                                    ->where('pupuk_id', $pupukId)
                                    ->where(function ($query) {
                                        // Show only allocations that are not completed
                                        $query->where('status', 'belum_diambil')
                                            ->orWhere('status', 'sebagian');
                                    })
                                    ->get()
                                    ->mapWithKeys(function ($alokasi) {
                                        $remaining = $alokasi->jumlah_alokasi - $alokasi->jumlah_diambil;
                                        return [
                                            $alokasi->id => "ID #{$alokasi->id} - Sisa: {$remaining} {$alokasi->pupuk->satuan}"
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->nullable()
                            ->helperText('Pilih alokasi jika pembelian ini merupakan bagian dari alokasi yang telah ditentukan'),
                            
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
                            ->prefix('Rp')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state && $get('jumlah')) {
                                    $set('total_harga', $state * $get('jumlah'));
                                }
                            }),
                            
                        TextInput::make('total_harga')
                            ->numeric()
                            ->required()
                            ->label('Total Harga')
                            ->prefix('Rp')
                            ->disabled(),
                            
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
                            
                        FileUpload::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran (opsional)')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('bukti-pembayaran')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'])
                            ->helperText('Unggah foto bukti pembayaran atau nota. Format: JPG, PNG, PDF (maks. 5MB)')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                    
                TextColumn::make('petani.nama')
                    ->label('Petani')
                    ->searchable(),
                    
                TextColumn::make('petani.kelompokTani.nama')
                    ->label('Kelompok Tani')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('pupuk.nama')
                    ->label('Pupuk')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->suffix(fn (PembelianPupuk $record): string => ' ' . ($record->pupuk ? $record->pupuk->satuan : '')),
                    
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
                    
                TextColumn::make('alokasi_pupuk_id')
                    ->label('Dari Alokasi')
                    ->formatStateUsing(fn ($state) => $state ? "Ya (#$state)" : 'Tidak'),
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
                    
                Tables\Filters\SelectFilter::make('pupuk_id')
                    ->relationship('pupuk', 'nama')
                    ->label('Pupuk')
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\Filter::make('has_alokasi')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('alokasi_pupuk_id'))
                    ->label('Dari Alokasi'),
                    
                Tables\Filters\Filter::make('no_alokasi')
                    ->query(fn (Builder $query): Builder => $query->whereNull('alokasi_pupuk_id'))
                    ->label('Tanpa Alokasi'),
                    
                Tables\Filters\Filter::make('tanggal_pembelian')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pembelian', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_pembelian', '<=', $date),
                            );
                    })
                    ->label('Filter Tanggal'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // Update pupuk stock
                        $pupuk = $record->pupuk;
                        $pupuk->increment('stok', $record->jumlah);
                        
                        // If related to an allocation, update the allocation
                        if ($record->alokasi_pupuk_id) {
                            $alokasi = $record->alokasiPupuk;
                            $alokasi->decrement('jumlah_diambil', $record->jumlah);
                            
                            // Update the allocation status
                            if ($alokasi->jumlah_diambil <= 0) {
                                $alokasi->update(['status' => 'belum_diambil']);
                            } elseif ($alokasi->jumlah_diambil < $alokasi->jumlah_alokasi) {
                                $alokasi->update(['status' => 'sebagian']);
                            }
                        }
                    }),
                Tables\Actions\Action::make('receipt')
                    ->label('Cetak Nota')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function (PembelianPupuk $record) {
                        $pdf = PDF::loadView('exports.nota-pembelian', [
                            'pembelian' => $record,
                            'petani' => $record->petani,
                            'pupuk' => $record->pupuk
                        ]);
                        
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            "nota-pembelian-{$record->id}.pdf"
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                // Update pupuk stock
                                $pupuk = $record->pupuk;
                                $pupuk->increment('stok', $record->jumlah);
                                
                                // If related to an allocation, update the allocation
                                if ($record->alokasi_pupuk_id) {
                                    $alokasi = $record->alokasiPupuk;
                                    $alokasi->decrement('jumlah_diambil', $record->jumlah);
                                    
                                    // Update the allocation status
                                    if ($alokasi->jumlah_diambil <= 0) {
                                        $alokasi->update(['status' => 'belum_diambil']);
                                    } elseif ($alokasi->jumlah_diambil < $alokasi->jumlah_alokasi) {
                                        $alokasi->update(['status' => 'sebagian']);
                                    }
                                }
                            }
                        }),
                    Tables\Actions\BulkAction::make('export_pdf')
                        ->label('Export PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records) {
                            $data = $records->map(function ($record) {
                                return [
                                    'id' => $record->id,
                                    'petani' => $record->petani->nama,
                                    'kelompok_tani' => $record->petani->kelompokTani->nama,
                                    'pupuk' => $record->pupuk->nama,
                                    'jumlah' => $record->jumlah . ' ' . $record->pupuk->satuan,
                                    'harga_satuan' => 'Rp ' . number_format($record->harga_satuan, 0, ',', '.'),
                                    'total_harga' => 'Rp ' . number_format($record->total_harga, 0, ',', '.'),
                                    'tanggal_pembelian' => $record->tanggal_pembelian->format('d/m/Y'),
                                    'metode_pembayaran' => $record->metode_pembayaran,
                                    'status_pembayaran' => $record->status_pembayaran,
                                ];
                            });
                            
                            $pdf = PDF::loadView('exports.pembelian-list', [
                                'purchases' => $data
                            ]);
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'pembelian-pupuk-' . date('Y-m-d') . '.pdf'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelianPupuk::route('/'),
            'create' => Pages\CreatePembelianPupuk::route('/create'),
            'edit' => Pages\EditPembelianPupuk::route('/{record}/edit'),
        ];
    }
}
