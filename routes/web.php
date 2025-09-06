
<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Repayments;
use App\Models\Borrower;
use App\Http\Controllers\{BorrowersController,
    SubscriptionsController, CustomerStatementController};

Route::middleware(['web','auth'])->group(function () {
    Route::get('/settings/pesapal', function () {
        $consumer_key    = env('PESAPAL_CONSUMER_KEY');
        $consumer_secret = env('PESAPAL_CONSUMER_SECRET');
        return view('settings.pesapal', compact('consumer_key', 'consumer_secret'));
    })->name('settings.pesapal');

    Route::post('/settings/pesapal/save', function (Request $request) {
        return back()->with([
            'success'         => 'Pesapal keys saved!',
            'consumer_key'    => $request->input('consumer_key'),
            'consumer_secret' => $request->input('consumer_secret'),
        ]);
    })->name('settings.pesapal.save');

    Route::get('/repayment/{amount}', function (string $amount) {
        try { $amt = decrypt($amount); } catch (\Throwable) { $amt = (float) $amount; }
        return view('gateways.pesapal.repaymentPayments', ['amount' => $amt]);
    })->name('repayment.pesapal');

    Route::post('/completeRepayment/{amount}', function (float $amount) {
        $user = auth()->user();
        $loan = Loan::where('borrower_id',$user->id)->where('loan_status','approved')->first();
        if ($loan) {
            Repayments::create([
                'loan_id'          => $loan->id,
                'payments'         => $amount,
                'payments_method'  => 'pesapal',
                'reference_number' => uniqid('pesapal_'),
            ]);
            $loan->balance = max(0,(float)($loan->balance ?? 0) - $amount);
            $loan->save();
            return response()->json(['status'=>'success','message'=>'Repayment completed for '.$user->email]);
        }
        return response()->json(['status'=>'error','message'=>'No active loan found for repayment.']);
    })->name('completeRepayment');

    Route::get('/disbursement/{amount}', function (string $amount) {
        try { $amt = decrypt($amount); } catch (\Throwable) { $amt = (float) $amount; }
        return view('gateways.pesapal.disbursementPayments', ['amount' => $amt]);
    })->name('disbursement.pesapal');

    Route::post('/completeDisbursement/{amount}', function (float $amount) {
        $user = auth()->user();
        $loan = Loan::where('borrower_id',$user->id)->where('loan_status','approved')->first();
        if ($loan) {
            $loan->disbursed_amount = $amount;
            $loan->save();
            if ($borrower = Borrower::find($loan->borrower_id)) {
                $borrower->notify(new \App\Notifications\LoanStatusNotification('Your loan of K'.$amount.' has been disbursed.'));
            }
            return response()->json(['status'=>'success','message'=>'Disbursement completed for '.$user->email]);
        }
        return response()->json(['status'=>'error','message'=>'No approved loan found for disbursement.']);
    })->name('completeDisbursement');
});

// ...existing code...

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

