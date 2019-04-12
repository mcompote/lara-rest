<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \App\Cart;
use \App\Order;
use \App\CartDetails;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // assume that user have only one cart, 
    // therefore we need to extract the 'freshiest' Cart instance
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //invoke as function! not this way: $model->cart
    public function cart()
    {
        $this->setRelations([]); //force update relations, see Cart.toOrder() method

        if( $this->carts->isEmpty() ) {
            return Cart::create([
                'user_id' => $this->id
            ]);
        }

        return $this->carts
            ->sortByDesc('created_at')
            ->first();
    }

    public function makeOrderFromCart()
    {
        $this->cart()->toOrder();
    }
}
