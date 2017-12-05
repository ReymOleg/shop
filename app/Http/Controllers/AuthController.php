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

	public function getUserTokenFromRequest(Request $request) {
		if($request->cookie('token')) {
			return $request->cookie('token');
		}
		return null;
	}

	public function generateTempToken(Request $request) {
		return 'temp.' . substr(md5('ztzCp4xed0986tG9fakmb9sNbZG0G95y6LNHGpfctGo' . $request->ip() . $request->header('User-Agent')), 0, -1);
	}

	public function generateToken(Request $request) {
		return substr(md5('ztzCp4xed0986tG9fakmb9sNbZG0G95y6LNHGpfctGo' . Auth::user()->email . Auth::user()->id), 0, -1);
	}

	public function getUserByToken(Request $request) {

	}




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
			'user' => $user,
			'token' => $user->token
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

		$auth = false;
		$statusCode = null;
		$token = $this->getUserTokenFromRequest($request);
		$user = null;


		// TODO: check if email exists!!!
		DB::table('users')
			->where('token', $token)
			->update([
				'email' => $email,
				'name' => $name,
				'password' => $password,
				'fake' => 0
			]);

		if (Auth::attempt(['email' => $email, 'password' => $request['password']])) {
			$token = $this->generateToken($request);
			Auth::user()->updated_at = new DateTime();
			Auth::user()->token = $token;
			Auth::user()->save();
			$user = Auth::user();
			$auth = true;
			$statusCode = 200;
		}

		return response()->json([
			'auth' => $auth,
			'statusCode' => $statusCode,
			'token' => $token,
			'user' => $user,
		], 200);
	}

	public function checkAuth(Request $request) {
		$user = null;
		$token = null;

		if($request['token'] === null) {
			$token = $this->generateTempToken($request);

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
		} else {
			$token = $this->getUserTokenFromRequest($request);
			$user = DB::table('users')->where('token', $token)->get();
			$response = [
				'auth' => false,
				'statusCode' => (int)200,
				'token' => null,
				'user' => null
			];

			if(count($user)) {
				$response['auth'] = !(bool)$user[0]->fake;
				$response['statusCode'] = (int)200;
				$response['token'] = $user[0]->token;
				$response['user'] = $user[0];
			}

			return response()->json($response, 200);
		}
	}

}
