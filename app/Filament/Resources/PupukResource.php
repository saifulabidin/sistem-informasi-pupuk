<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PupukResource\Pages;
use App\Filament\Resources\PupukResource\RelationManagers;
use App\Models\Pupuk;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PupukResource extends Resource
{
    protected static ?string $model = Pupuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'Pupuk';
    
    protected static ?string $modelLabel = 'Pupuk';
    
    protected static ?string $pluralLabel = 'Daftar Pupuk';
    
    protected static ?string $slug = 'pupuk';
    
    protected static ?string $navigationGroup = 'Manajemen Produk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Pupuk')
                            ->required()
                            ->maxLength(255),
                            
                        Select::make('jenis')
                            ->label('Jenis Pupuk')
                            ->options([
                                'urea' => 'Urea',
                                'npk' => 'NPK',
                                'za' => 'ZA',
                                'sp36' => 'SP-36',
                                'organik' => 'Organik',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required(),
                            
                        TextInput::make('harga')
                            ->label('Harga per Satuan')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                            
                        TextInput::make('stok')
                            ->label('Jumlah Stok')
                            ->numeric()
                            ->required()
                            ->minValue(0),
                            
                        TextInput::make('satuan')
                            ->label('Satuan')
                            ->default('kg')
                            ->required(),
                            
                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->maxLength(1000),
                            
                        FileUpload::make('gambar')
                            ->label('Gambar Produk')
                            ->image()
                            ->directory('pupuk-images')
                            ->disk('public')
                            ->visibility('public')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400'),
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
                    
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular(),
                    
                TextColumn::make('nama')
                    ->label('Nama Pupuk')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match($state) {
                        'urea' => 'success',
                        'npk' => 'primary',
                        'za' => 'warning',
                        'sp36' => 'info',
                        'organik' => 'success',
                        default => 'secondary',
                    })
                    ->searchable(),
                    
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('stok')
                    ->label('Stok')
                    ->badge()
                    ->color(fn (int $state): string => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger'))
                    ->sortable(),
                    
                TextColumn::make('satuan')
                    ->label('Satuan'),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Dibuat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options([
                        'urea' => 'Urea',
                        'npk' => 'NPK',
                        'za' => 'ZA',
                        'sp36' => 'SP-36',
                        'organik' => 'Organik',
                        'lainnya' => 'Lainnya',
                    ])
                    ->label('Jenis Pupuk'),
                    
                Tables\Filters\Filter::make('stok_menipis')
                    ->query(fn (Builder $query): Builder => $query->where('stok', '<', 10))
                    ->label('Stok Menipis'),
                    
                Tables\Filters\Filter::make('stok_kosong')
                    ->query(fn (Builder $query): Builder => $query->where('stok', '=', 0))
                    ->label('Stok Kosong'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
                Tables\Actions\Action::make('tambah_stok')
                    ->label('+ Stok')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->form([
                        TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        
                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(2),
                    ])
                    ->action(function (Pupuk $record, array $data): void {
                        $record->increment('stok', $data['jumlah']);
                        
                        // You could also log this adjustment in a separate table if needed
                    }),
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
            RelationManagers\AlokasiPupukRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPupuk::route('/'),
            'create' => Pages\CreatePupuk::route('/create'),
            'edit' => Pages\EditPupuk::route('/{record}/edit'),
        ];
    }
}
