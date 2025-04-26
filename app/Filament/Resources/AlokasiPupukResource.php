<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlokasiPupukResource\Pages;
use App\Filament\Resources\AlokasiPupukResource\RelationManagers;
use App\Models\AlokasiPupuk;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;

class AlokasiPupukResource extends Resource
{
    protected static ?string $model = AlokasiPupuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Alokasi Pupuk';
    
    protected static ?string $modelLabel = 'Alokasi Pupuk';
    
    protected static ?string $pluralLabel = 'Alokasi Pupuk';
    
    protected static ?string $slug = 'alokasi-pupuk';
    
    protected static ?string $navigationGroup = 'Distribusi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Select::make('kelompok_tani_id')
                            ->relationship('kelompokTani', 'nama')
                            ->label('Kelompok Tani')
                            ->searchable()
                            ->preload()
                            ->required(),
                            
                        Select::make('pupuk_id')
                            ->relationship('pupuk', 'nama')
                            ->label('Pupuk')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    // You could set max allocation based on available stock
                                }
                            })
                            ->required(),
                            
                        TextInput::make('jumlah_alokasi')
                            ->numeric()
                            ->required()
                            ->label('Jumlah Alokasi')
                            ->minValue(1)
                            ->helperText('Jumlah pupuk yang dialokasikan'),
                            
                        TextInput::make('jumlah_diambil')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->label('Jumlah Diambil')
                            ->helperText('Jumlah yang sudah diambil (diisi otomatis saat pembelian)'),
                            
                        DatePicker::make('tanggal_alokasi')
                            ->label('Tanggal Alokasi')
                            ->required()
                            ->default(now()),
                            
                        Select::make('status')
                            ->options([
                                'belum_diambil' => 'Belum Diambil',
                                'sebagian' => 'Sebagian Diambil',
                                'selesai' => 'Selesai',
                            ])
                            ->default('belum_diambil')
                            ->disabled()
                            ->required()
                            ->label('Status'),
                            
                        TextInput::make('periode')
                            ->label('Periode')
                            ->helperText('Contoh: April 2023, Q1 2023, dll.')
                            ->maxLength(50),
                            
                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->maxLength(500),
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
                    
                TextColumn::make('kelompokTani.nama')
                    ->label('Kelompok Tani')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('pupuk.nama')
                    ->label('Pupuk')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('jumlah_alokasi')
                    ->label('Jumlah Alokasi')
                    ->sortable(),
                    
                TextColumn::make('jumlah_diambil')
                    ->label('Jumlah Diambil')
                    ->sortable(),
                    
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'belum_diambil' => 'Belum Diambil',
                        'sebagian' => 'Sebagian Diambil',
                        'selesai' => 'Selesai',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match($state) {
                        'belum_diambil' => 'warning',
                        'sebagian' => 'info',
                        'selesai' => 'success',
                        default => 'secondary',
                    }),
                    
                TextColumn::make('tanggal_alokasi')
                    ->date()
                    ->sortable()
                    ->label('Tanggal Alokasi'),
                    
                TextColumn::make('periode')
                    ->label('Periode')
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Dibuat'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'belum_diambil' => 'Belum Diambil',
                        'sebagian' => 'Sebagian Diambil',
                        'selesai' => 'Selesai',
                    ])
                    ->label('Status'),
                    
                SelectFilter::make('kelompok_tani_id')
                    ->relationship('kelompokTani', 'nama')
                    ->label('Kelompok Tani')
                    ->searchable()
                    ->preload(),
                    
                SelectFilter::make('pupuk_id')
                    ->relationship('pupuk', 'nama')
                    ->label('Pupuk')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // Check if this allocation has associated purchases
                        if ($record->pembelianPupuks()->count() > 0) {
                            // You could either prevent deletion or handle related records
                            throw new \Exception('Tidak dapat menghapus alokasi yang sudah memiliki pembelian terkait.');
                        }
                    }),
                Action::make('export_pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function (AlokasiPupuk $record) {
                        $pdf = PDF::loadView('exports.alokasi-detail', [
                            'alokasi' => $record,
                            'kelompokTani' => $record->kelompokTani,
                            'pupuk' => $record->pupuk,
                            'pembelian' => $record->pembelianPupuks
                        ]);
                        
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            "alokasi-{$record->id}.pdf"
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                // Check if this allocation has associated purchases
                                if ($record->pembelianPupuks()->count() > 0) {
                                    // You could either prevent deletion or handle related records
                                    throw new \Exception('Tidak dapat menghapus alokasi yang sudah memiliki pembelian terkait.');
                                }
                            }
                        }),
                    BulkAction::make('export_selected_pdf')
                        ->label('Export PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records) {
                            $data = $records->map(function ($record) {
                                return [
                                    'id' => $record->id,
                                    'kelompok_tani' => $record->kelompokTani->nama,
                                    'pupuk' => $record->pupuk->nama,
                                    'jumlah_alokasi' => $record->jumlah_alokasi,
                                    'jumlah_diambil' => $record->jumlah_diambil,
                                    'tanggal_alokasi' => $record->tanggal_alokasi->format('d/m/Y'),
                                    'status' => $record->status,
                                    'periode' => $record->periode ?? '-',
                                ];
                            });
                            
                            $pdf = PDF::loadView('exports.alokasi-list', [
                                'allocations' => $data
                            ]);
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'alokasi-pupuk-' . date('Y-m-d') . '.pdf'
                            );
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('export_selected_excel')
                        ->label('Export Excel')
                        ->icon('heroicon-o-table-cells')
                        ->action(function (Collection $records) {
                            // Here you would use Laravel Excel to export records
                            // For demonstration purposes, we'll just show a notification
                            Notification::make()
                                ->success()
                                ->title('Export Excel Berhasil')
                                ->body('Data alokasi pupuk telah berhasil diexport ke Excel.')
                                ->send();
                            
                            // In a real implementation:
                            // return Excel::download(new AlokasiExport($records), 'alokasi-pupuk.xlsx');
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PembelianPupukRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlokasiPupuk::route('/'),
            'create' => Pages\CreateAlokasiPupuk::route('/create'),
            'edit' => Pages\EditAlokasiPupuk::route('/{record}/edit'),
        ];
    }
}
