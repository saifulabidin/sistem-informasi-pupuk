<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelompokTaniResource\Pages;
use App\Filament\Resources\KelompokTaniResource\RelationManagers;
use App\Models\KelompokTani;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelompokTaniResource extends Resource
{
    protected static ?string $model = KelompokTani::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Kelompok Tani';
    
    protected static ?string $pluralLabel = 'Kelompok Tani';
    
    protected static ?string $modelLabel = 'Kelompok Tani';
    
    protected static ?string $slug = 'kelompok-tani';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Kelompok Tani')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('ketua')
                            ->label('Nama Ketua')
                            ->maxLength(255),
                        Grid::make()
                            ->schema([
                                TextInput::make('desa')
                                    ->label('Desa')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('kecamatan')
                                    ->label('Kecamatan')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->maxLength(1000),
                        Repeater::make('petani')
                            ->relationship()
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama Petani')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('nik')
                                    ->label('NIK')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(16),
                                TextInput::make('no_telepon')
                                    ->label('Nomor Telepon')
                                    ->tel()
                                    ->maxLength(15),
                                TextInput::make('luas_lahan')
                                    ->label('Luas Lahan (ha)')
                                    ->numeric()
                                    ->step(0.01),
                                Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->rows(2)
                                    ->maxLength(500),
                            ])
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                            ->collapsible()
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
                TextColumn::make('nama')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('ketua')
                    ->label('Ketua')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('desa')
                    ->label('Desa')
                    ->searchable(),
                TextColumn::make('kecamatan')
                    ->label('Kecamatan')
                    ->searchable(),
                TextColumn::make('petani_count')
                    ->counts('petani')
                    ->label('Jumlah Anggota')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal Dibuat')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PetaniRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelompokTani::route('/'),
            'create' => Pages\CreateKelompokTani::route('/create'),
            'edit' => Pages\EditKelompokTani::route('/{record}/edit'),
        ];
    }
}
