<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['date','item_id','user_id','storage_id','comment'];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function storage():BelongsTo
    {
        return $this->belongsTo(Storage::class);
    }

    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

}
