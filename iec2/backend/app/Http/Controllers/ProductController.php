<?php

namespace App\Http\Controllers;

use App\Products;
use App\Users;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function addProduct(Request $request) {
    $validation = $request->validate([
      'name' => 'required',
      'price' => 'required',
      'desc' => 'required|max:255',
      'quantity' => 'required',
      'token' => 'required'
    ]);

    if(Users::where('token', $request->token)->first() == null || Users::where('token', $request->token)->first()->rights != 1) {
      return response()->json(['error'=>'unauthorized_or_not_logged_in'], 403);
    }

    if(Products::where('name', $request->name)->first() != null) {
      return response()->json(['error'=>'product_exist'], 403);
    } else {
      Products::create([
        'name' => $request->name,
        'price' => $request->price,
        'desc' => $request->desc,
        'quantity' => $request->quantity
      ]);
    }
    return response()->json();
  }

  public function getAllProducts() {
    return response()->json(Products::all());
  }

  public function getProducts(Request $request) {
    $validation = $request->validate([
      'name' => 'required'
    ]);

    if(Products::where('name', 'like', '%'.$request->name.'%')->get() == null) {
      return response()->json(['error'=>'no_such_product'], 404);
    }

    return response(Products::where('name', 'like', '%'.$request->name.'%')->get());
  }
}
