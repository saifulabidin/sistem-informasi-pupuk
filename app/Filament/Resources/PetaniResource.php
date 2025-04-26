<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PetaniResource\Pages;
use App\Filament\Resources\PetaniResource\RelationManagers;
use App\Models\Petani;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
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
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PetaniResource extends Resource
{
    protected static ?string $model = Petani::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationLabel = 'Petani';
    
    protected static ?string $modelLabel = 'Petani';
    
    protected static ?string $pluralModelLabel = 'Petani';
    
    protected static ?string $slug = 'petani';
    
    protected static ?string $navigationGroup = 'Master Data';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
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
                        Select::make('kelompok_tani_id')
                            ->label('Kelompok Tani')
                            ->relationship('kelompokTani', 'nama')
                            ->preload()
                            ->searchable()
                            ->required(),
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
                            ->rows(3)
                            ->maxLength(500),
                        FileUpload::make('logbooks')
                            ->label('Upload Logbook')
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-excel', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->disk('public')
                            ->directory('logbooks')
                            ->visibility('public')
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
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                TextColumn::make('kelompokTani.nama')
                    ->label('Kelompok Tani')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('no_telepon')
                    ->label('No. Telepon'),
                TextColumn::make('luas_lahan')
                    ->label('Luas Lahan (ha)')
                    ->formatStateUsing(fn (?float $state): string => $state !== null ? number_format($state, 2) : ''),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal Daftar')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelompok_tani_id')
                    ->label('Kelompok Tani')
                    ->relationship('kelompokTani', 'nama')
                    ->searchable()
                    ->preload(),
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
            RelationManagers\PembelianPupukRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPetani::route('/'),
            'create' => Pages\CreatePetani::route('/create'),
            'edit' => Pages\EditPetani::route('/{record}/edit'),
        ];
    }
}
