<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * @property-read Schema $form
 */
class SocialSettings extends Page
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShare;

    protected static string|UnitEnum|null $navigationGroup = 'Website';

    protected static ?string $navigationLabel = 'Social';

    protected static ?string $title = 'Social profiles';

    protected static ?string $slug = 'social';

    protected static ?int $navigationSort = 7;

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->only([
            ...SiteSetting::NETWORKS,
            'twitter_handle',
        ]));
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profiles')
                    ->description('Leave a field empty to hide that network on the public site.')
                    ->schema([
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.facebook.com/digiprosoft'),
                        TextInput::make('linkedin')
                            ->label('LinkedIn')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.linkedin.com/company/digiprosoft'),
                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.youtube.com/@digiprosoft'),
                        TextInput::make('x')
                            ->label('X (Twitter) profile')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://x.com/digiprosoft'),
                        TextInput::make('github')
                            ->label('GitHub')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://github.com/digiprosoft'),
                    ]),
                Section::make('Share cards')
                    ->schema([
                        TextInput::make('twitter_handle')
                            ->label('X (Twitter) handle')
                            ->prefix('@')
                            ->maxLength(15)
                            ->regex('/^[A-Za-z0-9_]*$/')
                            ->helperText('Used in twitter:site meta tags. Do not include @.'),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ([...SiteSetting::NETWORKS, 'twitter_handle'] as $field) {
            $value = $data[$field] ?? null;
            $data[$field] = is_string($value) && trim($value) !== '' ? trim($value) : null;
        }

        $settings = SiteSetting::query()->first() ?? new SiteSetting;
        $settings->fill($data)->save();

        Notification::make()
            ->title('Social profiles saved')
            ->success()
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([EmbeddedSchema::make('form')])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Save')
                                ->submit('save')
                                ->keyBindings(['mod+s']),
                        ])
                            ->alignment($this->getFormActionsAlignment())
                            ->key('form-actions'),
                    ]),
            ]);
    }
}
