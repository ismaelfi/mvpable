<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'General Settings';

    protected static ?string $slug = 'settings';

    protected static string $view = 'filament.pages.manage-settings';

    public $site_name;

    public $site_description;

    public $support_email;

    public $support_phone;

    public $google_analytics_id;

    public $html_snippet;

    public $seo_title;

    public $seo_keywords;

    public $seo_metadata;

    public $favicon;

    public $logo;

    public $STRIPE_KEY;

    public $STRIPE_SECRET;

    public function mount(): void
    {
        $settings = Setting::first();
        if ($settings) {
            $this->form->fill($settings->toArray());
        }

    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Tabs::make('Settings')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('General')
                        ->schema([
                            Forms\Components\TextInput::make('site_name')
                                ->label('Site Name')
                                ->required(),
                            Forms\Components\Textarea::make('site_description')
                                ->label('Site Description')
                                ->rows(3),
                            Forms\Components\TextInput::make('support_email')
                                ->label('Support Email')
                                ->email()
                                ->required(),
                            Forms\Components\TextInput::make('support_phone')
                                ->label('Support Phone'),
                        ]),
                    Forms\Components\Tabs\Tab::make('SEO')
                        ->schema([
                            Forms\Components\TextInput::make('seo_title')
                                ->label('SEO Title'),
                            Forms\Components\TextInput::make('seo_keywords')
                                ->label('SEO Keywords'),
                        ]),
                    Forms\Components\Tabs\Tab::make('Analytics')
                        ->schema([
                            Forms\Components\TextInput::make('google_analytics_id')
                                ->label('Google Analytics ID'),
                            Forms\Components\Textarea::make('html_snippet')
                                ->label('HTML Snippet')
                                ->rows(3),
                        ]),
                    Forms\Components\Tabs\Tab::make('Appearance')
                        ->schema([
                            Forms\Components\FileUpload::make('favicon')
                                ->label('Favicon')
                                ->image()
                                ->directory('images')
                                ->visibility('public'),
                            Forms\Components\FileUpload::make('logo')
                                ->label('Logo')
                                ->image()
                                ->directory('images')
                                ->visibility('public'),
                        ]),
                    Forms\Components\Tabs\Tab::make('Stripe')
                        ->schema([
                            Forms\Components\TextInput::make('STRIPE_KEY')
                                ->label('Stripe Public Key')
                                ->password(),
                            Forms\Components\TextInput::make('STRIPE_SECRET')
                                ->label('Stripe Secret Key')
                                ->password(),
                        ]),
                ])
                ->columnSpan('full'),
        ];
    }

    public function submit(): void
    {
        $settings = Setting::firstOrNew([]);
        $settings->fill([
            'site_name' => $this->site_name,
            'site_description' => $this->site_description,
            'support_email' => $this->support_email,
            'support_phone' => $this->support_phone,
            'google_analytics_id' => $this->google_analytics_id,
            'html_snippet' => $this->html_snippet,
            'seo_title' => $this->seo_title,
            'seo_keywords' => $this->seo_keywords,
            'seo_metadata' => json_encode($this->seo_metadata),
            'favicon' => $this->favicon,
            'logo' => $this->logo,
        ]);
        $settings->save();

        $this->updateEnv([
            'STRIPE_KEY' => $this->STRIPE_KEY,
            'STRIPE_SECRET' => $this->STRIPE_SECRET,
        ]);

        Notification::make()
            ->title('Settings updated successfully')
            ->success()
            ->send();
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            foreach ($data as $key => $value) {
                file_put_contents(
                    $envPath,
                    preg_replace(
                        "/^{$key}=.*/m",
                        "{$key}={$value}",
                        file_get_contents($envPath)
                    )
                );
            }
        }
    }
}
