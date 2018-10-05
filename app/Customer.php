<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Softdelte flag
     * 
     * @var array
     */
    protected $dates = ['deleted_at'];
}
