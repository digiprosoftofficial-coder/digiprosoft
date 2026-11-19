<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Filament\Support\ContentFields;
use App\Models\Category;
use App\Models\Service;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('category_id')
                            ->relationship(
                                name: 'category',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->ofType(Category::TYPE_SERVICE),
                            )
                            ->searchable()
                            ->preload(),
                        TextInput::make('name')
                            ->required()
                            ->maxLength(190)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($set, $get, ?string $state): void {
                                if (blank($get('slug')) && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        ContentFields::slug(),
                        TextInput::make('tagline')->maxLength(190),
                        ContentFields::iconSelect(),
                        Textarea::make('short_description')->required()->rows(3)->columnSpanFull(),
                        MarkdownEditor::make('description')->columnSpanFull(),
                        MarkdownEditor::make('problem')->columnSpanFull(),
                        MarkdownEditor::make('solution')->columnSpanFull(),
                        ContentFields::features()->columnSpanFull(),
                        Repeater::make('process')
                            ->schema([
                                TextInput::make('step')->numeric()->required(),
                                TextInput::make('title')->required()->maxLength(120),
                                TextInput::make('description')->required()->maxLength(400),
                            ])
                            ->columns(3)
                            ->collapsible()
                            ->default([])
                            ->columnSpanFull(),
                        ContentFields::benefits()->columnSpanFull(),
                        TagsInput::make('technologies')->columnSpanFull(),
                        ContentFields::faqs()->columnSpanFull(),
                        ContentFields::imagePath('featured_image', 'Featured image'),
                        TextInput::make('featured_image_alt')->maxLength(180),
                        Select::make('products')
                            ->relationship('products', 'name')
                            ->multiple()
                            ->preload()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Publishing')
                    ->schema(ContentFields::publishing())
                    ->columns(2),
                ...ContentFields::seo(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('category.name')->label('Category'),
                IconColumn::make('is_active')->boolean(),
                TextColumn::make('sort_order')->sortable(),
                TextColumn::make('published_at')->date()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
