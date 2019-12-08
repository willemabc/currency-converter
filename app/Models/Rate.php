<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'currency_id_from',
        'currency_id_to',
		'rate',
    ];

	protected $dates = [
        'created_at',
        'updated_at',
		'refreshed_at'
    ];

    public $timestamps = true;

	public function currencyFrom()
    {
        return $this->belongsTo(Currency::class, 'currency_id_from');
    }

	public function currencyTo()
    {
        return $this->belongsTo(Currency::class, 'currency_id_to');
    }
}
