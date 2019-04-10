<?php

namespace App;

use \App\QueryScopes\CartScope;
use \App\RawOrder;

class Cart extends RawOrder
{
    protected $guarded = ['is_cart'];

    //adding global scope to model
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CartScope);

        //ALWAYS set field 'is_cart' to TRUE for 'Cart' entities at creation time (not for the updates)
        static::creating(function ($query) {
            $query->is_cart = true;
        });
    }

    public function details()
    {
        return $this->hasMany(CartDetails::class, 'order_id', 'id');
    }

    public function getProduct($productId)
    {
        // UNIQ INDEX ON order_details (product_id, order_id)
        // => 'where' clause can only return: empty array[] or single value
        return $this->details->where('product_id', $productId)->first();
    }

    public function getProductsArray()
    {
       $result = $this->details->map(function ($item, $key) {
         return [ 'product_id' => $item->id,
                   'quantity'  => $item->quantity ];
      })->values();

      return $result;
    }

    protected function _addOrModifyProduct($productId, $quantity, $substituteQuantity)
    {
        $this->setRelations([]); //force update relations
        $entry = $this->getProduct($productId);

        //creating new CartDetail entry
        if (is_null($entry)) {
           if ($quantity <= 0) {
              throw new Exception("Error: can't add product with zero quantity", 1);
              return null;
            }

            return CartDetails::create([
                'product_id' => $productId,
                'order_id' => $this->id,
                'quantity' => $quantity,
            ]);
        }
        //updating existing CartDetail entry
        else {
            $resultQuantity = $substituteQuantity ? $quantity : $entry->quantity + $quantity;

            if ($resultQuantity <= 0) {
                $entry->delete();
                return null;
            } else {
                $entry->update([
                    'quantity' => $resultQuantity,
                ]);
                return $entry;
            }
        }
    }

    public function addProduct($productId, $quantity=1) {
       return $this->_addOrModifyProduct($productId, $quantity, false);
    }

    public function setProductQuantity($productId, $quantity) {
       return $this->_addOrModifyProduct($productId, $quantity, true);
    }

    public function deleteProduct($productId)
    {
       $entry = $this->getProduct($productId);
       if( is_null($entry) )
         return null;

      return $entry->delete();
    }

    public function toOrder()
    {
       $this->is_cart = false;
       $this->created_at = now();
       $this->updated_at = now();
       $this->save();
       //$this->fresh();  //doesn't work as I expected, possible workaround: $user->setRelations([])
    }


}
