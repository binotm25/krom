<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Interest;
use App\Models\Creation;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //$this->middleware('auth');
        //$this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('user_feeds');
        }
        return view('home');
        /*$userCount = User::count();
        $InterestCount = Interest::count();
        $creationCount = Creation::count();
        return view('home', array("userCount" => $userCount, "interestCount" => $InterestCount, "creationCount" => $creationCount));*/
    }

    public function privacy()
    {
        return view('others.privacy');
    }

    public function terms()
    {
        return view('others.terms');
    }
}
