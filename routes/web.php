// Pesapal Settings UI
use Illuminate\Http\Request;
Route::get('/settings/pesapal', function () {
    // Load keys from .env or config
    $consumer_key = env('PESAPAL_CONSUMER_KEY');
    $consumer_secret = env('PESAPAL_CONSUMER_SECRET');
    return view('settings.pesapal', compact('consumer_key', 'consumer_secret'));
})->name('settings.pesapal');

Route::post('/settings/pesapal/save', function (Request $request) {
    // Save keys to .env (for demo, just show values)
    // In production, use a settings table or package
    $consumer_key = $request->input('consumer_key');
    $consumer_secret = $request->input('consumer_secret');
    // TODO: Save to persistent storage
    return back()->with(['success' => 'Pesapal keys saved!', 'consumer_key' => $consumer_key, 'consumer_secret' => $consumer_secret]);
})->name('settings.pesapal.save');
// Pesapal Repayment Payment
Route::get('/repayment/{amount}', function ($amount) {
    return view('gateways.pesapal.repaymentPayments', ['amount' => decrypt($amount)]);
})->name('repayment.pesapal');

use App\Models\Repayments;
use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Support\Facades\Log;

Route::post('completeRepayment/{amount}', function ($amount) {
    $user = auth()->user();
    // Find borrower's active loan and update repayment
    $loan = Loan::where('borrower_id', $user->id)->where('loan_status', 'approved')->first();
    if ($loan) {
        Repayments::create([
            'loan_id' => $loan->id,
            'payments' => $amount,
            'payments_method' => 'pesapal',
            'reference_number' => uniqid('pesapal_'),
        ]);
        // Optionally update loan balance
        $loan->balance -= $amount;
        $loan->save();
        return response()->json(['status' => 'success', 'message' => 'Repayment completed for ' . $user->email]);
    }
    return response()->json(['status' => 'error', 'message' => 'No active loan found for repayment.']);
})->name('completeRepayment');

// Pesapal Disbursement Payment
Route::get('/disbursement/{amount}', function ($amount) {
    return view('gateways.pesapal.disbursementPayments', ['amount' => decrypt($amount)]);
})->name('disbursement.pesapal');

Route::post('completeDisbursement/{amount}', function ($amount) {
    $user = auth()->user();
    // Find borrower's approved loan and mark as disbursed
    $loan = Loan::where('borrower_id', $user->id)->where('loan_status', 'approved')->first();
    if ($loan) {
        $loan->disbursed_amount = $amount;
        $loan->save();
        // Optionally notify borrower
        $borrower = Borrower::find($loan->borrower_id);
        if ($borrower) {
            $borrower->notify(new \App\Notifications\LoanStatusNotification('Your loan of K' . $amount . ' has been disbursed.'));
        }
        return response()->json(['status' => 'success', 'message' => 'Disbursement completed for ' . $user->email]);
    }
    return response()->json(['status' => 'error', 'message' => 'No approved loan found for disbursement.']);
})->name('completeDisbursement');
<?php
use App\Http\Controllers\{BorrowersController,
SubscriptionsController, CustomerStatementController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/subscription/{amount}', function ($amount) {
    return view('gateways.pesapal.pesapalPayments', ['amount' => decrypt($amount)]);
})->name('subscription.pesapal');

Route::post('completeSubscription/{amount}',[SubscriptionsController::class,'completeSubscription'])
->name('completeSubscription');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('borrower',BorrowersController::class);
});

Route::get('/statement/{record}', [CustomerStatementController::class, 'download'])->name('statement.download');

