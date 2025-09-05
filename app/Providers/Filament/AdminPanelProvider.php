<?php

namespace App\Providers\Filament;
use Filament\Navigation\MenuItem;
use App\Filament\Resources\LoanResource;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Rmsramos\Activitylog\ActivitylogPlugin;
use App\Http\Middleware\CheckSubscriptionValidity;
use App\Filament\Pages\Auth\Register;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
        ->id('admin')
        ->path('admin')
    ->plugins([])
        // ->brandLogo(asset('Logos/logo2.png'))
        // ->brandLogoHeight('4rem')
        // ->favicon(asset('Logos/logo2.png'))
        ->sidebarCollapsibleOnDesktop()

        ->login()
        ->registration(Register::class)
        ->passwordReset()
        ->emailVerification()
        ->profile()
        ->default()
        ->login()
        ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->resources([
                \App\Filament\Resources\PesapalSettingsResource::class,
                \App\Filament\Resources\CollateralResource::class,
                \App\Filament\Resources\BorrowerResource::class,
                \App\Filament\Resources\TransfersResource::class,
                \App\Filament\Resources\WalletResource::class,
                \App\Filament\Resources\ThirdPartyResource::class,
                \App\Filament\Resources\SwitchBranchResource::class,
                \App\Filament\Resources\UserResource::class,
                \App\Filament\Resources\TransactionsResource::class,
                \App\Filament\Resources\RepaymentsResource::class,
                \App\Filament\Resources\LoanTypeResource::class,
                \App\Filament\Resources\LoanSettlementFormsResource::class,
                \App\Filament\Resources\MessagesResource::class,
                \App\Filament\Resources\LoanRollOverResource::class,
                \App\Filament\Resources\LoanRestructureResource::class,
                \App\Filament\Resources\LoanResource::class,
                \App\Filament\Resources\LoanAgreementFormsResource::class,
                \App\Filament\Resources\ExpenseResource::class,
                \App\Filament\Resources\ExpenseCategoryResource::class,
                \App\Filament\Resources\ContactMessagesResource::class,
                \App\Filament\Resources\BulkRepaymentsResource::class,
                \App\Filament\Resources\BranchesResource::class,
                \App\Filament\Resources\RoleResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                    // ...existing code...
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
                CheckSubscriptionValidity::class
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
