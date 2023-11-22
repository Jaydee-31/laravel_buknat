<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowed_book_condition',
        'returned_at',
        'return_book_condition',

    ];

    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function transactioned()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
