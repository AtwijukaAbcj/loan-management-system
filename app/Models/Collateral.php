<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Collateral extends Model
{
    protected $fillable = [
        'loan_id',
        'borrower_id',
        'collateral_name',
        'item_description',
        'item_value',
        'item_type',
        'document_path',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }
}
