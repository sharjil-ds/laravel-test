<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Workshop extends Model
{
    /**
     * Get the user that owns the phone.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
