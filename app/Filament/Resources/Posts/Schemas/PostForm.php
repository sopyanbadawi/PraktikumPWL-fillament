<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\CheckBox;
use Filament\Forms\components\DateTimePicker;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->minLength(5),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Select::make('category_id')
                    ->label('Category')
                    ->options(
                        \App\Models\Category::all()->pluck('name', 'id')
                    ),
                ColorPicker::make('color'),
                //MarkdownEditor::make('body'),
                RichEditor::make('body'),
                FileUpload::make('image')
                    ->disk("public")
                    ->directory("posts"),
                TagsInput::make('tags'),
                CheckBox::make('published'),
                DateTimePicker::make('published_at'),
            ]);
    }
}
