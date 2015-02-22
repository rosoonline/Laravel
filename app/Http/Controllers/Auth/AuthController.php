<?php namespace App\Http\Controllers\Auth;
     
    use App\User;
    use App\Http\Controllers\Controller;
    use Illuminate\Contracts\Auth\Guard;
     
    use App\Http\Requests\Auth\LoginRequest;
    use App\Http\Requests\Auth\RegisterRequest;
     
    class AuthController extends Controller {
     
		/**
		* the model instance
		* @var User
		*/
		protected $user;
		/**
		* The Guard implementation.
		*
		* @var Authenticator
		*/
		protected $auth;
		 
		/**
		* Create a new authentication controller instance.
		*
		* @param Authenticator $auth
		* @return void
		*/
		public function __construct(Guard $auth, User $user)
		{
			$this->user = $user;
			$this->auth = $auth;
			 
			$this->middleware('guest', ['except' => ['getLogout']]);
		}
		 
		/**
		* Show the application registration form.
		*
		* @return Response
		*/
		public function getRegister()
		{
			return view('auth.register');
		}
		 
		/**
		* Handle a registration request for the application.
		*
		* @param RegisterRequest $request
		* @return Response
		*/
		public function postRegister(RegisterRequest $request)
		{
			$this->user->namefirst = $request->namefirst;
			$this->user->namelast = $request->namelast;
			$this->user->email = $request->email;
			$this->user->password = bcrypt($request->password);
			$this->user->save();
			
			$this->auth->login($this->user);
			return redirect('/dashboard');
		}
		 
		/**
		* Show the application login form.
		*
		* @return Response
		*/
		public function getLogin()
		{
			return view('auth.login');
		}
		 
		/**
		* Handle a login request to the application.
		*
		* @param LoginRequest $request
		* @return Response
		*/
		public function postLogin(LoginRequest $request)
		{
			if ($this->auth->attempt($request->only('email', 'password')))
			{
				return redirect('/dashboard');
			}
			 
			return redirect('/auth/login')->withErrors([
			'email' => 'The credentials you entered did not match our records.',
			]);
		}
		 
		/**
		* Log the user out of the application.
		*
		* @return Response
		*/
		public function getLogout()
		{
			$this->auth->logout();
			return redirect('/');
		}
     
   }