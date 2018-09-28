<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Users;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllOrders(Request $request) {
      $validation = $request->validate([
        'token' => 'required'
      ]);

      $user = Users::where('token', $request->token)->first();


      return response()->json(Orders::where('user_id', $user->id)->get());
    }

    public function addToOrders(Request $request) {
      $validation = $request->validate([
        'product_id' => 'required',
        'token' => 'required'
      ]);

      $user = Users::where('token', $request->token)->first();

      Orders::create([
        'user_id' => $user->id,
        'product_id' => $request->product_id
      ]);

      return response()->make();
    }
}
