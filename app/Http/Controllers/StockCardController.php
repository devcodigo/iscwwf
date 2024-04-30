<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Storage;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        $itemListData = Item::with('lastTransaction')->get()->where('lastTransaction.storage_id',$id);

       return view('stockCard.stockCard',['lastTransaction' => $itemListData->first()?->lastTransaction, 'items' => $itemListData]);
        
        //return true;
    }
}
