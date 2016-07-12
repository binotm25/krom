<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Collaborate;
use App\Models\User;
use App\Models\Country;
use App\Models\Interest;
use App\Models\Creation;
use App\Models\UserInterest;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
   }
	public function index(){
		//return view('home'); // admin.dashboard
		
		//echo "admin index"; exit;
		$userCount = User::count();
        $InterestCount = Interest::count();
        $creationCount = Creation::count();
        $collaborationCount = Collaborate::count();
            return view('admin.dashboard', compact("userCount", "InterestCount", "creationCount", "collaborationCount"));
	}
}


