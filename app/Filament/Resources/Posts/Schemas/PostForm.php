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
            //Grouping kiri 2
            Group::make([
                Section::make('Post Details')
                    ->description('Isi detail utama postingan di sini')
                    ->icon('heroicon-o-document-text') // Icon 1
                    ->schema([
                        // Grouping di dalam Section biar field utama jadi 2 kolom
                        Group::make([
                            TextInput::make('title')
                                ->required()
                                ->rules(['min:5, max:100'])
                                ->validationMessages([
                                    'required' => 'Judul postingan wajib diisi!',
                                    'min' => 'Judul postingan minimal harus 5 karakter.',
                                ]),
                            TextInput::make('slug')
                                ->minLength(3)
                                ->required()
                                ->unique()
                                ->validationMessages([
                                    'required' => 'Slug tidak boleh kosong!',
                                    'unique' => 'Slug ini sudah dipakai, silakan cari yang lain.',
                                    'min' => 'Slug minimal harus 3 karakter.',
                                ]),
                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->validationMessages([
                                    'required' => 'Kategori wajib dipilih!',
                                ]),
                            ColorPicker::make('color'),
                        ])->columns(2), 

                        MarkdownEditor::make('content')
                            ->columnSpanFull(), 
                    ]),
            ])->columnSpan(2),

            //Grouping kiri 2
            Group::make([
                Section::make('Image Upload')
                    ->icon('heroicon-o-photo') // Icon 2 (Icon berbeda)
                    ->schema([
                        FileUpload::make('image')
                            ->disk('public')
                            ->directory('posts')
                            ->required(),
                    ]),

                Section::make('Meta Information')
                    ->icon('heroicon-o-tag') // Icon 3 (Icon berbeda)
                    ->schema([
                        TagsInput::make('tags'),
                        Checkbox::make('published'),
                        DateTimePicker::make('published_at'),
                    ]),
            ])->columnSpan(1),

        ])->columns(3);
    }
}
