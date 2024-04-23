<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['inventory','name','description','price','purchased','condition','stock_id'];

    public function stock():BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }


    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function lastTransaction():HasOne
    {
        
       return $this->hasOne(Transaction::class)->latest();

      //  return Transaction::where('item_id',$this)->last();
    }
}
