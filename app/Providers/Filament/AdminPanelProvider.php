<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\EmployeeByCountryChart;
use App\Filament\Widgets\EmployeeExits;
use App\Filament\Widgets\EmployeeExitsMonthly;
use App\Filament\Widgets\EmployeeExitsYearly;
use App\Filament\Widgets\EmployeesOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->topNavigation()
            ->spa()
            ->sidebarCollapsibleOnDesktop()
            ->plugins([
                FilamentApexChartsPlugin::make(),
            ])
            ->default()
            ->id('admin')
            ->path('/admin')
            ->databaseNotifications()
            ->favicon(asset('images/logo.png'))
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->profile(isSimple: false)
            ->brandLogo(fn() => view('filament.admin.logo'))
            ->colors([
                'primary' => Color::hex('#159456'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                EmployeesOverview::class,
                EmployeeByCountryChart::class,
                EmployeeExitsYearly::class,
                EmployeeExitsMonthly::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
