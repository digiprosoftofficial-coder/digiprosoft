<?php

namespace App\Filament\Resources\CaseStudies;

use App\Filament\Resources\CaseStudies\Pages\CreateCaseStudy;
use App\Filament\Resources\CaseStudies\Pages\EditCaseStudy;
use App\Filament\Resources\CaseStudies\Pages\ListCaseStudies;
use App\Filament\Support\ContentFields;
use App\Models\CaseStudy;
use App\Models\Category;
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

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static ?string $navigationLabel = 'Portfolio';

    protected static ?string $modelLabel = 'case study';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string|\UnitEnum|null $navigationGroup = 'Website';

    protected static ?int $navigationSort = 3;

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
                                modifyQueryUsing: fn ($query) => $query->ofType(Category::TYPE_CASE_STUDY),
                            )
                            ->searchable()
                            ->preload(),
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(190)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($set, $get, ?string $state): void {
                                if (blank($get('slug')) && filled($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        ContentFields::slug(),
                        TextInput::make('client_type')->maxLength(120),
                        TextInput::make('industry')->maxLength(120),
                        Textarea::make('summary')->required()->rows(3)->columnSpanFull(),
                        MarkdownEditor::make('problem')->columnSpanFull(),
                        MarkdownEditor::make('solution')->columnSpanFull(),
                        ContentFields::features()->columnSpanFull(),
                        TagsInput::make('technologies')->columnSpanFull(),
                        ContentFields::screenshots()->columnSpanFull(),
                        MarkdownEditor::make('outcome')
                            ->helperText('Only verified outcomes. Leave empty if none.')
                            ->columnSpanFull(),
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
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('industry'),
                IconColumn::make('is_active')->boolean(),
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
            'index' => ListCaseStudies::route('/'),
            'create' => CreateCaseStudy::route('/create'),
            'edit' => EditCaseStudy::route('/{record}/edit'),
        ];
    }
}
