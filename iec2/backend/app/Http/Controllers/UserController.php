<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

class UserController extends Controller
{
    public function registration(Request $request) {
      $validation = $request->validate([
        'username' => 'required',
        'password' => 'required|min:6|max:32',
        'email' => 'required|email'
      ]);

      if(Users::where('username', $request->username)->first() == null) {
        Users::create([
          'username' => $request->username,
          'password' => $request->password,
          'email' => $request->email,
          'rights' => '0'
        ]);
      } else {
        return response()->json(['error' => 'username_or_email_exist_in_db'], 403);
      }

      return response()->json();
    }

    public function login(Request $request) {

      $token;

      $validation = $request->validate([
        'username' => 'required',
        'password' => 'required|min:6|max:32'
      ]);

      if(Users::where('username', $request->username)->get() == null) {
        return response()->json(['error'=>'user_does_not_exist'], 403);
      }

      $user = Users::where('username', $request->username)->first();

      //return $user->token;

      if($user->token == '') {
        $token = $this->random_str(128);
        $user->fill([
          'token' => $token
        ]);
        $user->save();
        return response()->json(['token' => $token], 200);
      } else {
        return response()->json(['error' => 'already_logged_in'], 403);
      }
    }

    public function logout(Request $request) {
      $user = Users::where('token', $request->token)->first();
      $user->fill([
        'token' => ''
      ]);
      $user->save();

      return response()->json([$user->token, 200]);
    }

    private function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

}
