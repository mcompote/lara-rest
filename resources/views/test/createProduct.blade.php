@extends('layouts.app')

@section('content')
   <form action="/products" method="post">
      @csrf

      <div class="form-group">
         <label for="name">Name</label>
         <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId"
            placeholder="Name of the product">
         <small id="helpId" class="form-text text-muted">fuck you</small>
      </div>

      <div class="form-group">
         <label for="description">Description</label>
         <input type="text" name="description" id="description" class="form-control" placeholder="Product description"
            aria-describedby="helpId">
         <small id="helpId" class="text-muted">fuck you</small>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
   </form>
@endsection