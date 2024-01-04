<?php

namespace App\Http\Controllers;

use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function index()
    {
//        dd('hi');
        return view('stripe.index');
    }

    public function process(Request $request)
    {

       /* $stripe = Stripe::charges()->create([
            'source'   => $request->get('tokenId'),
            'currency' => 'USD',
            'amount'   => $request->get('amount') * 100
        ]);

        return $stripe;*/
        try {
            $charge = Stripe::charges()->create([
                'source'   => $request->get('tokenId'),
                'currency' => 'USD',
                'amount'   => $request->get('amount') * 100
            ]);
            return back()->with('success_message', 'Thank You! Your payment has been successfully accepted!');
        } catch (\Exception $e) {
        }
    }
}
