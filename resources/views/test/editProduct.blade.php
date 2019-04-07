@extends('layouts.app')

@section('content')
   <form action="/products/{{$product->id}}" method="post">
      @csrf
      {{-- @method('PATCH') --}}

      <div class="form-group">
         <label for="name">Name</label>
         <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : 'is-valid'}}" 
            name="name" id="name" placeholder="Name of the product" value="{{  $errors->has('name') ? old('name') : $product->name }}">
      </div>

      <div class="form-group">
         <label for="description">Description</label>
         <input type="text" name="description" id="description" 
            class="form-control  {{ $errors->has('description') ? 'is-invalid' : 'is-valid'}}" 
            placeholder="Product description" value="{{$product->description}}">
      </div>


      @if ( $errors->any() )  
         <div class="container">
            @foreach ($errors->all() as $error)
               <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
         </div>
      @endif

      <button type="submit" class="btn btn-primary" name="_method" value="PATCH">Change</button>
      <button type="submit" class="btn btn-danger" name="_method" value="DELETE">Remove</button>
   </form>
@endsection