<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Country;
use App\Models\Interest;
use App\Models\Creation;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Session;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Hashing\BcryptHasher;

class UserController extends Controller {

    use ImageUploadTraits;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userData = User::all()->reverse();
        return view('user.list', array("userData" => $userData));
    }

    /**
     * 
     * @return type
     */
    public function create() {
        $countryData = Country::all();
        $interestData = Interest::all();
        return view('user.add', array("countryData" => $countryData, "interestData" => $interestData));
    }

    /**
     * 
     * @param Request $request
     */
    public function store(Request $request) {

        $this->validate($request, [
            'email' => 'required|unique:user',
            'name' => 'required',
            'password' => 'required',
            'city' => 'required',
            'zipCode' => 'required',
        ]);
        /* if (User::where('email', '=', $request->get('email'))->count() > 0) {
          print "adfsafsd";
          exit;
          }
          exit; */

        $profilePic = $request->file('profilePic');
        $profilePicUploaded = "";
        if (isset($profilePic)) {
            $profilePicUploaded = $this->_uploadPic($profilePic, 'profile');
        }

        $coverPic = $request->file('coverPic');
        $coverPicUploaded = "";
        if (isset($coverPic)) {
            $coverPicUploaded = $this->_uploadPic($coverPic, "cover");
        }


        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $password = $request->input('password');

        $BCrypt = new BcryptHasher();
        $user->password = $BCrypt->make($password);

        $user->city = $request->input('city');
        $user->zip_code = $request->input('zipCode');
        $user->country_code = $request->country;
        $user->my_story = $request->myStory;
        $user->my_work_my_life = $request->myWorkMyLife;
        $user->profile_pic = $profilePicUploaded;
        $user->cover_pic = $coverPicUploaded;
        $user->status = 'active';
        $user->save();

        $interestIDs = $request->input('interests');
        if ($interestIDs) {
            $userID = $user->id;
            $this->_addInterests($userID, $interestIDs);
        }
        return redirect('admin/user/list');
    }

    private function _addInterests($userID, $interestIDs) {
        $interestIDsImploded = implode(",", $interestIDs);
        $userInterest = new UserInterest();
        $userInterest->user_id = $userID;
        $userInterest->interest_ids = $interestIDsImploded;
        $userInterest->save();
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function destroy($id) {
        $user = User::findOrFail($id);		
        $user->delete();
		Creation::where('user_id', '=', $id)->delete();
        Session::flash('flash_message', 'User successfully deleted!');
        return redirect('admin/user/list');
    }

    public function edit($id) {
        $userData = User::findOrFail($id);
        $countryData = Country::all();
        $interestData = Interest::all();
        $userInterestDataObject = UserInterest::where('user_id', '=', $id)->get();        
        return view('user.edit', array("userData" => $userData, "countryData" => $countryData, "interestData" => $interestData, "userInterestDataObject" => $userInterestDataObject));
    }

    /**
     * 
     * @param type $id
     * @param Request $request
     */
    public function update($id, Request $request) {
        $this->validate($request, [
			'email' => 'required|unique:user,email,'.$id,
            'name' => 'required',            
            'city' => 'required',
            'zip_code' => 'required',
        ]);
        $userData = User::findOrFail($id);
        $requestData = $request->all();
        
        $profilePicUploaded = "";
        if (isset($requestData['profilePic'])) {
            $profilePicUploaded = $this->_uploadPic($requestData['profilePic'], true);
            $requestData['profile_pic'] = $profilePicUploaded;
        }
        unset($requestData['profilePic']);
        
        $coverPicUploaded = "";
        if (isset($requestData['coverPic'])) {
            $coverPicUploaded = $this->_uploadPic($requestData['coverPic'], false);
            $requestData['cover_pic'] = $coverPicUploaded;
        }
        unset($requestData['coverPic']);
        //unset($requestData['email']);
        
        $userInterest = UserInterest::where('user_id', $id)->first();        
        
        $interestIDs = $request->input('interests');
		$userInterestData['interest_ids'] = "";
		if($interestIDs) {
			$interestIDsImploded = implode(",", $interestIDs);			
			$userInterestData['interest_ids'] = $interestIDsImploded;        
		} else {
			$interestIDs = "";
		}
        $userData->fill($requestData)->save();        
		if($userInterest) {		
			$userInterest->fill($userInterestData)->save();
		} else if($interestIDs){
			$this->_addInterests($id, $interestIDs);
		}
        Session::flash('flash_message', 'User successfully Updated!');
        return redirect()->back();
    }
	
	/**
     * 
     * @param type $userID
     */
    public function fetchCityByUserID($userID) {
        $returnData = array();
        $userData = User::where('id', '=', $userID)->get();
		$returnData = array("city" => "");
        foreach($userData as $uData) {
			$city = $uData->city;
			$returnData = array("city" => $city);
		}		
        return json_encode($returnData);
    }
	
	public function editPassword($id) {
		$userData = User::findOrFail($id);
		return view('user.password', array("userData" => $userData));
	}
	
	public function updatePassword($id, Request $request) {
        $oldPassword = $request->c_pass;
        $this->validate($request, [
            'c_pass'    =>  'required|string',
            'pwd'       =>  'required|string',
            'pwd_c'     =>  'required|same:pwd'
        ]);


        if(Hash::check($oldPassword, User::findOrFail($id)->password)){

            $user = User::findOrFail($id);
            $user->password = bcrypt($request->pwd);
            $user->save();
            Session::flash('flash_message','Your Password has been changed successfully!');
            return redirect()->route('admin_user_lists');

        }
        return redirect()->back()->with(['info'=>'Your Password doesn"t match the Old Password!', 'type'=>'Failure']);
	}

}
