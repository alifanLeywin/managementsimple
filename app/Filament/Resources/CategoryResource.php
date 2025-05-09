<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(100),

            Forms\Components\Select::make('type')
                ->options([
                    'income' => 'Income',
                    'expense' => 'Expense',
                ])
                ->required(),

            Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('category-images') // Simpan di storage/app/public/category-images
                ->visibility('public')
                ->preserveFilenames()
                ->enableDownload()
                ->enableOpen()
                ->deleteUploadedFileUsing(function ($file) {
                    \Storage::disk('public')->delete($file);
                })
                ->getUploadedFileNameForStorageUsing(function ($file) {
                    return $file->getClientOriginalName();
                })
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('image')
                ->disk('public'), // opsional: buat thumbnail bulat

            Tables\Columns\TextColumn::make('name'),

            Tables\Columns\TextColumn::make('type')
                ->badge(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
