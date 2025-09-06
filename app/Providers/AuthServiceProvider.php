<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Branches;
use App\Models\ActivityLogs;
use App\Models\Payments;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Borrower;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\LoanSettlementForms;
use App\Models\LoanType;
use App\Models\Messages;
use App\Models\Repayments;
use App\Models\ThirdParty;
use App\Models\Transaction;

use App\Policies\BranchesPolicy;
use App\Policies\ActivityLogsPolicy;
use App\Policies\LoanTypePolicy;
use App\Policies\BorrowerPolicy;
use App\Policies\ExpenseCategoryPolicy;
use App\Policies\ExpensePolicy;
use App\Policies\LoanSettlementFormsPolicy;
use App\Policies\LoanPolicy;
use App\Policies\MessagesPolicy;
use App\Policies\PaymentsPolicy;
use App\Policies\RepaymentsPolicy;
use App\Policies\RolePolicy;
use App\Policies\ThirdPartyPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Policies\WalletPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Branches::class            => BranchesPolicy::class,
        ActivityLogs::class        => ActivityLogsPolicy::class,
        Borrower::class            => BorrowerPolicy::class,
        ExpenseCategory::class     => ExpenseCategoryPolicy::class,
        Expense::class             => ExpensePolicy::class,
        LoanSettlementForms::class => LoanSettlementFormsPolicy::class,
        Loan::class                => LoanPolicy::class,
        LoanType::class            => LoanTypePolicy::class,
        Messages::class            => MessagesPolicy::class,
        Payments::class            => PaymentsPolicy::class,
        Repayments::class          => RepaymentsPolicy::class,
        Role::class                => RolePolicy::class,
        ThirdParty::class          => ThirdPartyPolicy::class,
        Transaction::class         => TransactionPolicy::class,
        User::class                => UserPolicy::class,
        Wallet::class              => WalletPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Super-admin bypass: user sees/does everything (Filament + app policies).
        Gate::before(function ($user, string $ability) {
            // Spatie\Permission
            if (method_exists($user, 'hasRole') && $user->hasRole('super_admin')) {
                return true;
            }

            // Custom relation
            if (method_exists($user, 'roles') && $user->roles()->where('name', 'super_admin')->exists()) {
                return true;
            }

            // Simple boolean flag
            if (property_exists($user, 'is_admin') && $user->is_admin) {
                return true;
            }

            return null; // fall back to normal checks
        });
    }
}
