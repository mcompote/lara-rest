<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check() ) {
            $result = [];
            $user = Auth::user();
            foreach ($user->orders as $order) {
                array_push( $result, $order->getFullInfoArray() );
            }
            // ->toJson()
            return ['result' => $result];
        }
    }


    /**
     * Creates an order from the cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // TODO: add optional parameters to "new" order (description, discount)
    public function store(Request $request)
    {
        if( Auth::check() ) {

            $user = Auth::user();
            $result = $user->cart()->toOrder();
            
            return ['result' => [
                'created' => !is_null($result),
                'order' => !is_null($result) ? $result->getFullInfoArray() : []
                ]
            ];
            // or something like this
            // return redirect()->action('OrderController@index');
        }
    }
}
