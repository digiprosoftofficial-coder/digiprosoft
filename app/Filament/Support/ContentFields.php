<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;

/**
 * Shared Filament fields that match the public Blade components.
 */
final class ContentFields
{
    /**
     * @return array<string, string>
     */
    public static function iconOptions(): array
    {
        $names = [
            'pill', 'bed', 'cart', 'graduation', 'receipt', 'package', 'boxes',
            'code', 'globe', 'zap', 'plug', 'cloud', 'wrench', 'compass', 'layers',
            'calendar', 'users', 'chart', 'shield', 'lock', 'refresh', 'smartphone',
            'sparkles', 'briefcase', 'building', 'headset', 'database', 'settings',
            'file-text', 'search', 'rocket', 'trending', 'pen', 'check',
        ];

        return array_combine($names, $names);
    }

    public static function iconSelect(): Select
    {
        return Select::make('icon')
            ->options(self::iconOptions())
            ->searchable();
    }

    public static function slug(): TextInput
    {
        return TextInput::make('slug')
            ->required()
            ->maxLength(190)
            ->unique(ignoreRecord: true)
            ->helperText('Lowercase hyphens only. This is the public URL.')
            ->dehydrateStateUsing(fn (?string $state): string => Str::slug((string) $state));
    }

    public static function imagePath(string $name, string $label): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->helperText('Public path, e.g. /images/illustrations/dashboard-pharmacy.svg')
            ->maxLength(255);
    }

    /**
     * @return array<int, mixed>
     */
    public static function seo(): array
    {
        return [
            Section::make('SEO')
                ->collapsed()
                ->schema([
                    TextInput::make('seo_title')->maxLength(70),
                    TextInput::make('seo_description')->maxLength(320),
                    TextInput::make('canonical_url')->url()->maxLength(255),
                    self::imagePath('og_image', 'Open Graph image'),
                ]),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    public static function publishing(bool $withSortOrder = true): array
    {
        $fields = [
            Toggle::make('is_active')->default(true),
            Toggle::make('is_featured')->default(false),
        ];

        if ($withSortOrder) {
            $fields[] = TextInput::make('sort_order')->numeric()->default(0)->required();
        }

        $fields[] = DateTimePicker::make('published_at')
            ->helperText('Leave empty to keep the page unpublished.');

        return $fields;
    }

    public static function features(): Repeater
    {
        return Repeater::make('features')
            ->schema([
                self::iconSelect(),
                TextInput::make('title')->required()->maxLength(120),
                TextInput::make('description')->required()->maxLength(400),
            ])
            ->columns(3)
            ->collapsible()
            ->default([]);
    }

    public static function benefits(): Repeater
    {
        return Repeater::make('benefits')
            ->schema([
                TextInput::make('title')->required()->maxLength(120),
                TextInput::make('description')->required()->maxLength(400),
            ])
            ->columns(2)
            ->collapsible()
            ->default([]);
    }

    public static function screenshots(): Repeater
    {
        return Repeater::make('screenshots')
            ->schema([
                self::imagePath('src', 'Image path')->required(),
                TextInput::make('alt')->maxLength(180),
                TextInput::make('caption')->maxLength(180),
            ])
            ->collapsible()
            ->default([]);
    }

    public static function faqs(): Repeater
    {
        return Repeater::make('faqs')
            ->schema([
                TextInput::make('question')->required()->maxLength(255),
                TextInput::make('answer')->required()->columnSpanFull(),
            ])
            ->collapsible()
            ->default([]);
    }
}
