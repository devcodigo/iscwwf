<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['name','category_id','active'];

    public function category():BelongsTo
    {
        return  $this->belongsTo(Category::class);
    }

    public function items():HasMany
    {
        return  $this->HasMany(Item::class);
    }

}

