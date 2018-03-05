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

	private $user = null;

	private $token = null;

	private $response = [];

	private $salt = 'ztzCp4xed0986tG9fakmb9sNbZG0G95y6LNHGpfctGo';

	public function __construct(Request $request) {
		$this->token = $request->cookie('token');

		$this->response = [
			'auth' => false,
			'statusCode' => (int)200,
			'token' => $this->token,
			'user' => $this->user
		];
	}

	public function generateTempToken(Request $request) {
		return 'temp.' . substr(md5($this->salt . $request->ip() . $request->header('User-Agent')), 0, -1);
	}

	public function generateToken(Request $request) {
		return substr(md5($this->salt . Auth::user()->email . Auth::user()->id), 0, -1);
	}


	public function checkAuth(Request $request) {
		$user = null;
		$token = $this->token;

		if(is_null($token)) {
			$this->token = $this->generateTempToken($request);

			$issetUser = DB::table('users')->where('token', $token)->count();
			if(!$issetUser) {
				$user = new User();
				$user->email = 'temp-' . $this->token . time();
				$user->name = '';
				$user->password = '';
				$user->fake = 1;
				$user->token = $this->token;
				$user->save();
				$this->response['user'] = $user;
				$this->response['token'] = $this->token;
			}
		} else {

			$user = DB::table('users')->where('token', $this->token)->first();
			
			if(is_null($user)) {
				$this->token = null;
				return $this->checkAuth($request);
			}

			if(substr($this->token, 0, 4) != 'temp') {
				$this->response['auth'] = !(bool)$user->fake;
				$this->response['token'] = $user->token;
				$this->response['user'] = $user;
			}

		}

		return response()->json($this->response, 200);
	}


	public function login(Request $request) {
		// remove user on login?
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required'
		]);

		if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
			Auth::user()->updated_at = new DateTime();
			Auth::user()->token = $this->generateToken($request);
			Auth::user()->save();
			$this->user = Auth::user();
			$this->response['auth'] = true;
			$this->response['user'] = $this->user;
			$this->response['token'] = $this->user->token;
		} else {
			$this->response['statusCode'] = 401;
		}

		return response()->json($this->response, $this->response['statusCode']);
	}

	public function logout(Request $request) {
		$user = DB::table('users')->where('token', $this->token)->get();
		$token = $this->generateTempToken($request);

		if ($user) {
			DB::table('users')->update(['token' => $token]);
		}

		Auth::logout();

		$this->response['auth'] = false;
		$this->response['user'] = null;
		$this->response['token'] = $token;

		return response()->json($this->response, $this->response['statusCode']);
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

		$issetUser = DB::table('users')->where('token', $this->token)->count();

		if(!$issetUser) {
			$user = new User();
			$user->email = $email;
			$user->name = $name;
			$user->password = $password;
			$user->fake = 0;
			$user->save();
		} else {
			DB::table('users')
				->where('token', $this->token)
				->update([
					'email' => $email,
					'name' => $name,
					'password' => $password,
					'fake' => 0
				]);
		}

		if (Auth::attempt(['email' => $email, 'password' => $request['password']])) {
			$realToken = $this->generateToken($request);
			Auth::user()->updated_at = new DateTime();
			Auth::user()->token = $realToken;
			Auth::user()->save();
			$this->response['user'] = Auth::user();
			$this->response['token'] = $realToken;
		}

		return response()->json($this->response, 200);
	}

}











// class AuthController extends Controller {

// 	public function getUserTokenFromRequest(Request $request) {
// 		if($request->cookie('token')) {
// 			return $request->cookie('token');
// 		}
// 		return null;
// 	}

// 	public function generateTempToken(Request $request) {
// 		return 'temp.' . substr(md5('ztzCp4xed0986tG9fakmb9sNbZG0G95y6LNHGpfctGo' . $request->ip() . $request->header('User-Agent')), 0, -1);
// 	}

// 	public function generateToken(Request $request) {
// 		return substr(md5('ztzCp4xed0986tG9fakmb9sNbZG0G95y6LNHGpfctGo' . Auth::user()->email . Auth::user()->id), 0, -1);
// 	}

// 	public function getUserByToken(Request $request) {

// 	}




// 	public function login(Request $request) {
// 		$this->validate($request, [
// 			'email' => 'required',
// 			'password' => 'required'
// 		]);

// 		$user = null;

// 		if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
// 			Auth::user()->updated_at = new DateTime();
// 			Auth::user()->save();
// 			$user = Auth::user();
// 			$auth = true;
// 			$statusCode = 200;
// 		} else {
// 			$auth = false;
// 			$statusCode = 401;
// 		}

// 		return response()->json([
// 			'auth' => $auth,
// 			'statusCode' => (int)$statusCode,
// 			'user' => $user,
// 			'token' => $user->token
// 		], $statusCode);
// 	}

// 	public function logout() {
// 		Auth::logout();
// 		return redirect()->route('login');
// 	}

// 	public function createUser(Request $request) {
// 		$validation = $this->validate($request, [
// 			'email' => 'required|email|unique:users',
// 			'name' => 'required|max:120',
// 			'password' => 'required|min:4'
// 		]);

// 		$email = $request['email'];
// 		$name = $request['name'];
// 		$password = bcrypt($request['password']);

// 		$auth = false;
// 		$statusCode = null;
// 		$token = $this->getUserTokenFromRequest($request);
// 		$user = null;


// 		// TODO: check if email exists!!!
// 		DB::table('users')
// 			->where('token', $token)
// 			->update([
// 				'email' => $email,
// 				'name' => $name,
// 				'password' => $password,
// 				'fake' => 0
// 			]);

// 		if (Auth::attempt(['email' => $email, 'password' => $request['password']])) {
// 			$token = $this->generateToken($request);
// 			Auth::user()->updated_at = new DateTime();
// 			Auth::user()->token = $token;
// 			Auth::user()->save();
// 			$user = Auth::user();
// 			$auth = true;
// 			$statusCode = 200;
// 		}

// 		return response()->json([
// 			'auth' => $auth,
// 			'statusCode' => $statusCode,
// 			'token' => $token,
// 			'user' => $user,
// 		], 200);
// 	}

// 	public function checkAuth(Request $request) {
// 		$user = null;
// 		$token = null;

// 		if($request['token'] === null) {
// 			$token = $this->generateTempToken($request);

// 			$issetUser = DB::table('users')->where('token', $token)->count();
// 			if(!$issetUser) {
// 				$user = new User();
// 				$user->email = 'temp-' . time();
// 				$user->name = '';
// 				$user->password = '';
// 				$user->fake = 1;
// 				$user->token = $token;
// 				$user->save();
// 			}

// 			return response()->json([
// 				'auth' => false,
// 				'statusCode' => (int)200,
// 				'token' => $token,
// 				'user' => null
// 			], 200);
// 		} else {
// 			$token = $this->getUserTokenFromRequest($request);
// 			$user = DB::table('users')->where('token', $token)->get();
// 			$response = [
// 				'auth' => false,
// 				'statusCode' => (int)200,
// 				'token' => null,
// 				'user' => null
// 			];

// 			if(count($user)) {
// 				$response['auth'] = !(bool)$user[0]->fake;
// 				$response['statusCode'] = (int)200;
// 				$response['token'] = $user[0]->token;
// 				$response['user'] = $user[0];
// 			}

// 			return response()->json($response, 200);
// 		}
// 	}

// }