<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Collaborate;
use App\Models\UserCreationImages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Models\Interest;
use App\Models\UserInterest;
use App\Models\User;
use App\Models\Country;
use App\Models\Creation;

use Illuminate\Support\Facades\Session;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth;
use Auth as Authenticate;
use DB;

class InterestsController extends Controller {


    protected $AuthUser, $User, $Interest, $UserInterest, $Country, $Creation, $userInterest;


    /**
     * @param Interest $Interest
     * @param UserInterest $UserInterest
     * @param Creation $Creation
     * @param User $User
     */
    public function __construct(Interest $Interest, UserInterest $UserInterest, Creation $Creation, User $User) {
        //$this->middleware('auth');
        $this->Interest     = $Interest;
        $this->UserInterest = $UserInterest;
        $this->Creation     = $Creation;
        $this->User         = $User;
        if(Authenticate::check()){
            $this->AuthUser = Authenticate::user();
            $this->userInterest = $this->UserInterest->InterestIds($this->AuthUser->id);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $interestData = Interest::orderBy('title', 'asc')->get();
//        if($interestData->count() < 9){
//            $nextPage = false;
//        }else{
//            $nextPage = true;
//        }
        $check = $this->UserInterest->whereUser_id($this->AuthUser->id)->first();
//
//        if($request->ajax()){
//            if($check != null){
//                return redirect()->route('user_feeds');
//            }else{
//                return [
//                    'posts' => view('interests.ajax._list', compact('interestData', 'nextPage'))->render(),
//                    'nextPage' => $interestData->nextPageUrl()
//                ];
//            }
//        }

        if($check != null){
            return redirect()->route('user_feeds');
        }else{
            return view('interests.list', compact('interestData'));
        }


    }

    /**
     * 
     * @return type
     */
    public function create() {		
        return View::make('interest.add');
    }

    /**
     * 
     * @param Request $request
     */
    public function store($userId, Request $request) {
		
		//var_dump($request->all()); exit;
		
		//dd($request->all());
		
		
		$validator = Validator::make($request->all(), [
            'interest' => 'required|array|min:3'
        ]);

        if ($validator->fails()) {
            return redirect('interest')
                        ->withErrors($validator->errors())
                        ->withInput();
        }
		
		
		/*$this->validate($request, [
			'interest' => 'required|array|min:3'
        ]);*/
        $interestIDs = $request->input('interest');
        
        //var_dump($interestIDs); exit;
        
		$interestIDsImploded = implode(",", $interestIDs);
				
		$userInterest = UserInterest::where('user_id', $userId)->first();
		
		$userInterestData['interest_ids'] = "";
		if($interestIDs) {
			$interestIDsImploded = implode(",", $interestIDs);			
			$userInterestData['interest_ids'] = $interestIDsImploded;        
		} else {
			$interestIDs = "";
		}
        
        if($userInterest) {		
			$userInterest->fill($userInterestData)->save();
		} else if($interestIDs){
			$userInterest = new UserInterest();
			$userInterest->user_id = $userId;
			$userInterest->interest_ids = $interestIDsImploded;
			$userInterest->save();
		}
		
		return redirect('feeds');
		
		
		
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function destroy($id) {
        $interest = Interest::findOrFail($id);
        $interest->delete();
        Session::flash('flash_message', 'Interest successfully deleted!');
        return redirect('interest/list');
    }

    public function edit($id) {
        $interestData = Interest::findOrFail($id);
        return view('interest.edit', array("interestData" => $interestData));
    }

    /**
     * 
     * @param type $id
     * @param Request $request
     */
    public function update($id, Request $request) {
		$this->validate($request, [
            'title' => 'required'
        ]);
        $interestData = Interest::findOrFail($id);
        $requestData = $request->all();
        $imageUploaded = "";
        if (isset($requestData['interestPic'])) {
            $imageUploaded = $this->_uploadPic($requestData['interestPic']);
            $requestData['image'] = $imageUploaded;
        }
        unset($requestData['interestPic']);
        $interestData->fill($requestData)->save();
        Session::flash('flash_message', 'Interest successfully Updated!');
        return redirect()->back();
    }

    /**
     *
     * @param type $file
     * @return string
     */
    private function _uploadPic($file, $profile) {
        $userPic = $file;
        if ($profile == "profile") {
            $profileDirectory = env('UPLOADS_PROFILE_DIRECTORY');
        } else if($profile == "cover"){
            $profileDirectory = env('UPLOADS_COVER_DIRECTORY');
        }else if($profile == "interest"){
            $profileDirectory = env('UPLOADS_COVER_DIRECTORY');
        }else if($profile == "creation"){
            $profileDirectory = "creation";
        }

        $userImageDirectory = env('UPLOADS_DIRECTORY') . "/" . $profileDirectory;
        $destinationPath = sprintf($userImageDirectory);
        $ext = $userPic->getClientOriginalExtension();
        $userPicName = md5(Carbon::now()).'.'.$ext;
        $userPic->move($destinationPath, $userPicName);
        $this->_createThumb($destinationPath, $userPicName, $profile);
        return $userPicName;
    }

    /**
     *
     * @param type $directory
     * @param type $file
     */
    private function _createThumb($directory, $file, $profile) {
        $fileLocation = $directory . "/" . $file;
        if($profile == "creation"){
            $fileThumbLocation = $directory . "/thumb/" . $file;
            $thumbDirectory = $directory . '/thumb';
        }else{
            $fileThumbLocation = $directory . "/" . env('UPLOAD_THUMB_DIRECTORY') . "/" . $file;
            $thumbDirectory = $directory . '/' . env('UPLOAD_THUMB_DIRECTORY');
        }
        if (!file_exists($thumbDirectory)) {
            File::makeDirectory($thumbDirectory, $mode = 0777, true, true);
        }

		$thumbnail = Image::open($fileLocation)
            ->thumbnail(new \Imagine\Image\Box(300,300));

        $thumbnail->save($fileThumbLocation);

    }

    /**
     * 
     * @param type $file
     * @return string
     */
    /*private function _uploadPic($file) {
        $interestPic = $file;
        $interestImageDirectory = env('UPLOADS_DIRECTORY') . "/" . env('UPLOADS_INTEREST_DIRECTORY');
        $destinationPath = public_path() . sprintf("/" . $interestImageDirectory . "/");
        $interestPicName = uniqid() . '_' . $interestPic->getClientOriginalName();
        $interestPic->move($destinationPath, $interestPicName);
        $this->_createThumb($destinationPath, $interestPicName);
        return $interestPicName;
    }*/

    /**
     * 
     * @param type $directory
     * @param type $file
     */
    /*private function _createThumb($directory, $file) {
        $fileLocation = $directory."/".$file;
        $fileThumbLocation = $directory."/".env('UPLOAD_THUMB_DIRECTORY')."/".$file;
        $thumbDirectory = $directory.'/'.env('UPLOAD_THUMB_DIRECTORY');
        if(!file_exists($thumbDirectory)) {
           File::makeDirectory($thumbDirectory, $mode = 0777, true, true);
        }
        
		$thumbnail = Image::open($fileLocation)
            ->thumbnail(new \Imagine\Image\Box(300,300));        

        $thumbnail->save($fileThumbLocation);
		
    }*/
    
    /**
     * 
     * @param type $userID
     */
    public function fetchByUserID($userID) {
        $returnData = array();
        $userInterestData = UserInterest::where('user_id', '=', $userID)->get();
        $userIDs = array();
        foreach($userInterestData as $data) {
            $userIDs = explode(",", $data->interest_ids);          
        }
        
        if(!$userIDs) {
            return json_encode($returnData);
        }
        
        $interestData = Interest::whereIn('id', $userIDs)->get();        
        foreach($interestData as $data) {
            $interestDataArray = array(
                "text" => $data->title,
                "val" => $data->id
            );
            $returnData[] = $interestDataArray; 
        }
        return json_encode($returnData);
    }
	
	public function updateprofile($id, Request $request) {
        $this->validate($request, [
			'email' => 'required|unique:user,email,'.$id,
            'name' => 'required',
        ]);
        $userData = User::findOrFail($id);
        $requestData = $request->all();
        
        //print_r($requestData); exit;
        
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
        
        $userInterest = UserInterest::where('user_id', $id)->first();        
        
        $userData->fill($requestData)->save();        
		Session::flash('flash_message', 'Profile successfully Updated!');
        return redirect('profile');
    }

}
