<?php

namespace App\Filament\Resources\PupukResource\RelationManagers;

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

class AlokasiPupukRelationManager extends RelationManager
{
    protected static string $relationship = 'alokasiPupuks';

    protected static ?string $recordTitleAttribute = 'id';
    
    protected static ?string $title = 'Alokasi Pupuk';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kelompok_tani_id')
                    ->relationship('kelompokTani', 'nama')
                    ->label('Kelompok Tani')
                    ->searchable()
                    ->preload()
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
            ]);
    }

    public function table(Table $table): Table
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
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'belum_diambil' => 'Belum Diambil',
                        'sebagian' => 'Sebagian Diambil',
                        'selesai' => 'Selesai',
                    ])
                    ->label('Status'),
                    
                Tables\Filters\SelectFilter::make('kelompok_tani_id')
                    ->relationship('kelompokTani', 'nama')
                    ->label('Kelompok Tani')
                    ->searchable()
                    ->preload(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
                ]),
            ]);
    }
}