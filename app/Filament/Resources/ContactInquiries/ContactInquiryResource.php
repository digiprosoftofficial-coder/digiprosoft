<?php

namespace App\Filament\Resources\ContactInquiries;

use App\Filament\Resources\ContactInquiries\Pages\ManageContactInquiries;
use App\Models\ContactInquiry;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactInquiryResource extends Resource
{
    protected static ?string $model = ContactInquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $navigationLabel = 'Inquiries';

    protected static ?string $modelLabel = 'inquiry';

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\UnitEnum|null $navigationGroup = 'Leads';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('status')
                    ->options([
                        ContactInquiry::STATUS_NEW => 'New',
                        ContactInquiry::STATUS_CONTACTED => 'Contacted',
                        ContactInquiry::STATUS_QUALIFIED => 'Qualified',
                        ContactInquiry::STATUS_CLOSED => 'Closed',
                        ContactInquiry::STATUS_SPAM => 'Spam',
                    ])
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('business_name')->placeholder('—'),
                TextEntry::make('phone'),
                TextEntry::make('email'),
                TextEntry::make('service')->placeholder('—'),
                TextEntry::make('budget')->placeholder('—'),
                TextEntry::make('message')->columnSpanFull(),
                TextEntry::make('status')->badge(),
                TextEntry::make('created_at')->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone'),
                TextColumn::make('service')->toggleable(),
                TextColumn::make('status')->badge(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        ContactInquiry::STATUS_NEW => 'New',
                        ContactInquiry::STATUS_CONTACTED => 'Contacted',
                        ContactInquiry::STATUS_QUALIFIED => 'Qualified',
                        ContactInquiry::STATUS_CLOSED => 'Closed',
                        ContactInquiry::STATUS_SPAM => 'Spam',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()->label('Status'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('status', ContactInquiry::STATUS_NEW)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageContactInquiries::route('/'),
        ];
    }
}
