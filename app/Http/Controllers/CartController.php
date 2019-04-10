<?php

namespace App\Http\Controllers;


use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::check() ) {

            $user = Auth::user();
            $result = $user->cart()->getProductsArray();
            // ->toJson()
            return $result;
        }
    }


    /**
     * Add [{product, quantity}, ..] to Cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $result = Validator::make($request->all(), [
        //     // 'data' => 'string'
        // ])->validate();
        //json_decode( $request->getContent(), true);
        // $request->json()->all();

        if( Auth::check() ) { 

            // request payload validation --->
            $inputData = $request->json('data');
            if( !is_array($inputData) ) {
                $error = ValidationException::withMessages([
                    'generalError' => ['Cant convert input data to array. Awaiting JSON: { data: [ obj1, obj2,.. ,objN] }']
                 ]);
                 throw $error;
            }
    
            if( count($inputData) == 0 ) {
                $error = ValidationException::withMessages([
                    'emptyArray' => ['Nothing to process. Seems like "data" array is empty. Awaiting JSON: { data: [ obj1, obj2,.. ,objN] }']
                 ]);
                 throw $error;            
            }
    
            for ($i=0; $i < count($inputData); $i++) { 
                Validator::make($inputData[$i], [
                        'productId' => 'required|numeric',
                        'quantity' => 'required|numeric'
                    ])->validate();
            }
            // <--- request payload validation 

            $user = Auth::user();  
            for ($i=0; $i < count($inputData); $i++) { 
                $user->cart()->addProduct($inputData[$i]['productId'], $inputData[$i]['quantity']);
            }

            // return redirect()->route('CartShowAll');
        }
    }


    /**
     * Remove Products [ ProductId1, ProductId2, ....] from Cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request)
    {
        if( Auth::check() ) { 

            // request payload validation --->
            $inputData = $request->json('data');
            if( !is_array($inputData) ) {
                $error = ValidationException::withMessages([
                    'generalError' => ['Cant convert input data to array. Awaiting JSON: { "data": [ int1, int2,.. ,intN] }']
                 ]);
                 throw $error;
            }
    
            if( count($inputData) == 0 ) {
                $error = ValidationException::withMessages([
                    'emptyArray' => ['Nothing to process. Seems like "data" array is empty. Awaiting JSON: { "data": [ int1, int2,.. ,intN] }']
                 ]);
                 throw $error;            
            }
            
            //all elements - ProducIds (integer values)
            if( $inputData != array_filter( $inputData , 'is_numeric') ) {
                $error = ValidationException::withMessages([
                    'ArrayElementType' => ['One of the array elements has wrong type, should be integer. Awaiting JSON: { "data": [ int1, int2,.. ,intN] }']
                 ]);
                 throw $error;                           
            }
            // <--- request payload validation 

            $user = Auth::user();  
            for ($i=0; $i < count($inputData); $i++) { 
                $user->cart()->deleteProduct($inputData[$i]);
            }

            return redirect()->route('CartShowAll');
        }
    }


    public function destroyMany(Request $request)
    {
        # code...
    }
}
