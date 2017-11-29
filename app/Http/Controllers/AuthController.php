<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use DB;
use DateTime;

class AuthController extends Controller {

	public function login(Request $request) {
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required'
		]);

		$user = null;

		if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
			Auth::user()->updated_at = new DateTime();
			Auth::user()->save();
			$user = Auth::user();
			$auth = true;
			$statusCode = 200;
		} else {
			$auth = false;
			$statusCode = 401;
		}

		return response()->json([
			'auth' => $auth,
			'statusCode' => (int)$statusCode,
			'user' => $user
		], $statusCode);
	}

	public function logout() {
		Auth::logout();
		return redirect()->route('login');
	}

	public function createUser(Request $request) {
		$validation = $this->validate($request, [
			'email' => 'required|email|unique:users',
			'name' => 'required|max:120',
			'password' => 'required|min:4'
		]);

		$email = $request['email'];
		$name = $request['name'];
		$password = bcrypt($request['password']);

		$user = new User();
		$user->email = $email;
		$user->name = $name;
		$user->password = $password;
		$user->fake = 0;
		$user->save();
		Auth::login($user);

		return response()->json([
			'auth' => true,
			'statusCode' => (int)200,
			'user' => $user
		], 200);
	}

	public function checkAuth(Request $request) {
		// if($request['token'] !== null) {
		// 	// check in db
		// 	// if isset and real - auth
		// 	// return data like cart
		// 	echo "token:" . $request->cookie('token');
		// } else {
			$token = 'temp.' . substr(md5($request->ip() . $request->header('User-Agent')), 0, -1);

			$issetUser = DB::table('users')->where('token', $token)->count();
			if(!$issetUser) {
				$user = new User();
				$user->email = 'temp-' . time();
				$user->name = '';
				$user->password = '';
				$user->fake = 1;
				$user->token = $token;
				$user->save();
			}

			return response()->json([
				'auth' => false,
				'statusCode' => (int)200,
				'token' => $token,
				'user' => null
			], 200);
		// }
	}

}
