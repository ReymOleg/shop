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
		$user->save();
		Auth::login($user);

		return response()->json([
			'auth' => true,
			'statusCode' => (int)200,
			'user' => $user
		], 200);
	}

}
