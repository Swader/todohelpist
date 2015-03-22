<?php namespace Todohelpist\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use League\OAuth2\Client\Provider\Google;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

    /** @var  Request */
    protected $request;

    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @param Request $req
     */
	public function __construct(Request $req, Guard $auth)
	{
        $this->request = $req;
        $this->auth = $auth;
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (!$this->auth->check()) {
            return view('welcome');
        }

        $user = $this->auth->user();

        return view('dashboard', [
            'projects' => unserialize($user->projects),
            'email' => $user->email
        ]);
	}

}
