<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Http\Requests\ExchangeRateFilterRequest;

class ExchangeRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ExchangeRateFilterRequest $request)
    {
        $filters = $request->only(['currency_from', 'currency_to', 'rate_date', 'retrieved_at']);
        $rates = ExchangeRate::query()
                    ->filters($filters)
                    ->paginate();

        return response()->json( $rates );
    }

    /**
     * Display the specified resource.
     */
    public function show(ExchangeRate $exchangeRate)
    {
        return response()->json($exchangeRate);
    }
}
