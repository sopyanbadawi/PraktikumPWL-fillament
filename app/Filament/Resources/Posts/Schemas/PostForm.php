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
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Post Details")
                ->Description("Fill in the details of the post.")
                ->icon('heroicon-o-document-text')
                ->schema([
                    //grouping fields into 2 columns
                    Group::make([
                        TextInput::make('title')->required()->minLength(5),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->preload()
                            ->searchable()
                            ->label('Category')
                            ->options(
                                \App\Models\Category::all()->pluck('name', 'id')
                            ),
                        ColorPicker::make('color'),
                    ])->columns(2),
                        //MarkdownEditor::make('body'),
                        RichEditor::make('body'),
                // ])->columnSpanFull(),
                ])->columnSpan(2),

                //Grouping fields into 2 columns
                Group::make([
                    //section 2
                    Section::make("Image Upload")
                    ->schema([
                        FileUpload::make('image')
                            ->disk("public")
                            ->directory("posts"),
                    ]),
                    //section 3
                    Section::make("Meta Information")
                    ->schema([
                        TagsInput::make('tags'),
                        CheckBox::make('published'),
                        DateTimePicker::make('published_at'),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
