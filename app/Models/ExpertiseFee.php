<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ExpertiseFee extends Base
{
    protected $table = 'expertise_fee';

    protected $fillable = [
        'fee_id',
        'expertise_id'
    ];
}
