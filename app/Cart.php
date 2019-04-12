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

    public function hasProduct($productId)
    {
        return !( is_null(Product::where('product_id')->first()) );
    }

    public function getProductsArray()
    {
       $result = $this->details->map(function ($item, $key) {
         return [ 'product_id' => $item->product_id,
                   'quantity'  => $item->quantity ];
      })->values();

      return $result;
    }

    protected function _addOrModifyProduct($productId, $quantity, $substituteQuantity)
    {
        //first check if $productId exists in db
        if( !Product::exists($productId) ) {
            return [
                'productId' => $productId,
                'exists'    => false ];
        }

        $this->setRelations([]); //force update relations
        $entry = $this->getProduct($productId);

        //creating new CartDetail entry
        if ( is_null($entry) ) {
           if ($quantity <= 0) {
            //   throw new \Exception("Error: can't add product with zero quantity", 1);
            //   return null;
            return  [ 'product_id' => $productId,
                      'quantity'   => $quantity,
                      'found'     => false,
                      'created'   => false,
                      'error'     => 'can not add product with zero quantity' ];
            }

            $result = CartDetails::create([
                'product_id' => $productId,
                'order_id' => $this->id,
                'quantity' => $quantity,
            ]);

            return   [ 'product_id' => $result->product_id,
                        'quantity'  => $result->quantity,
                        'found'     => false,
                        'created'   => true ];
        }
        //updating existing CartDetail entry
        else {
            $resultQuantity = $substituteQuantity ? $quantity : $entry->quantity + $quantity;

            if ($resultQuantity <= 0) {
                $entry->delete();
                return  [ 'product_id' => $productId,
                           'quantity'  => null,
                           'deleted'   => true ];
            } else {
                $entry->update([
                    'quantity' => $resultQuantity,
                ]);
                return [ 'product_id' => $entry->product_id,
                          'quantity'  => $entry->quantity,
                          'updated'   => true ];
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
        //first check if $productId exists in db
        if( !Product::exists($productId) ) {
            return [
                'productId' => $productId,
                'exists'    => false ];
        }

       $entry = $this->getProduct($productId);
       if( is_null($entry) ) {
       //  return null;
       //  or throw exception or object
         return 
         [ 'product_id' => $productId,
           'deleted'    => false,
           'found'      => false ];
        }

      $result = $entry->delete();
      return [ 'product_id' => $productId,
               'found'      => true,
               'deleted'    => $result ];
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
