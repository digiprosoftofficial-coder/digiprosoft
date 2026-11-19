<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Support\ContentFields;
use App\Models\Category;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
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

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 1;

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
                                modifyQueryUsing: fn ($query) => $query->ofType(Category::TYPE_PRODUCT),
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
                        TextInput::make('website_url')
                            ->label('Product website')
                            ->url()
                            ->maxLength(255)
                            ->helperText('Public product site or live demo URL, e.g. https://softopharma.digiprosoft.com/')
                            ->columnSpanFull(),
                        ContentFields::iconSelect(),
                        Textarea::make('short_description')->required()->rows(3)->columnSpanFull(),
                        MarkdownEditor::make('description')->columnSpanFull(),
                        MarkdownEditor::make('problem')->columnSpanFull(),
                        MarkdownEditor::make('solution')->columnSpanFull(),
                        TagsInput::make('target_audience')->columnSpanFull(),
                        ContentFields::features()->columnSpanFull(),
                        ContentFields::benefits()->columnSpanFull(),
                        ContentFields::screenshots()->columnSpanFull(),
                        ContentFields::faqs()->columnSpanFull(),
                        ContentFields::imagePath('featured_image', 'Featured image'),
                        TextInput::make('featured_image_alt')->maxLength(180),
                        Select::make('services')
                            ->relationship('services', 'name')
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
                TextColumn::make('slug')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('category.name')->label('Category'),
                IconColumn::make('is_active')->boolean(),
                IconColumn::make('is_featured')->boolean(),
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
