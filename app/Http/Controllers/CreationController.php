<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Creation;
use App\Models\User;
use App\Models\UserInterest;
use App\Models\Interest;
use App\Models\UserCreationImages;
use Illuminate\Support\Facades\Session;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class CreationController extends Controller {

    use ImageUploadTraits;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {         
		//echo phpinfo();
        $creationData = Creation::with('interest', 'user')->orderBy('created_at', 'desc')->simplePaginate(20);
        return view('creation.list', compact('creationData'));
    }

    /**
     *
     * @return type
     */
    public function create() {
        $userData = User::all();
		$interestData = Interest::all();
        return view('creation.add', array("userData" => $userData, "interestData" => $interestData));
    }

    /**
     *
     * @param Request $request
     */
    public function store(Request $request) {

        $this->validate($request, [
            'user_id' => 'required',
            'title' => 'required',
            'interest' => 'required',
        ]);
        
        $featuredPhotos = $request->file('featuredPhotos');
        $countryCode = User::find($request->user_id)->first()->country_code;
        $countryName = Country::whereCountry_code($countryCode)->first()->country_name;

        $featuredPhotoUploaded = array();
        if (isset($featuredPhotos)) {
            foreach($featuredPhotos as $featuredPhoto) {  
                if(!empty($featuredPhoto)) {
                    $featuredPhotoUploaded[] = $this->_uploadPic($featuredPhoto, "creation");
                }
            }
        }                
        
        $otherPhotos = $request->file('otherPhotos');
        
        $otherPhotosUploaded = array();
        if (isset($otherPhotos)) {
            foreach($otherPhotos as $otherPhoto) {   
                if(!empty($otherPhoto)) {             
                    $otherPhotosUploaded[] = $this->_uploadPic($otherPhoto, "creation");
                }
            }
        }
        
        
        $creation = new Creation();
        $creation->user_id = $request->input('user_id');
        $creation->title = $request->input('title');
        $creation->location = $request->input('location').", ".$countryName;
        $creation->interest_id = $request->input('interest');
        $creation->description = $request->input('description');        
        $creation->save();
        $userCreationID = $creation->id;
        if($featuredPhotoUploaded) {
            $this->_saveImages($userCreationID, $featuredPhotoUploaded, true, true);
        }
        if($otherPhotosUploaded) {
            $this->_saveImages($userCreationID, $otherPhotosUploaded, false, false);
        }
        return redirect('admin/creation/list');
    }
    
    /**
     * 
     * @param type $ucID
     * @param type $images
     * @param type $featured
     * @param type $clear
     * @return type
     */
    private function _saveImages($userCreationID, $images, $featured, $clear=false) {
        if(!$images) {
            return;
        }
        if($clear) {
            $this->_deleteImagesByUserCreationID($userCreationID);
        }
        
        $userCreationImages = new UserCreationImages();
        foreach($images as $image) {
            $userCreationImages = new UserCreationImages();
            $userCreationImages->user_creation_id = $userCreationID;
            $userCreationImages->image = $image;
            if($featured) {
                $userCreationImages->featured = 1;
            } else {
                $userCreationImages->featured = 0;
            }     
            $userCreationImages->save();
        }
    }
    
    /**
     * 
     * @param type $userCreationID
     */
    private function _deleteImagesByUserCreationIDFeatured($userCreationID, $featured=true) {
        if($featured) {
            $userInterestData = UserCreationImages::where('user_creation_id', '=', $userCreationID)
                ->where('featured', '=', 1);
        } else {
            $userInterestData = UserCreationImages::where('user_creation_id', '=', $userCreationID)
                ->where('featured', '=', 0);
        }
        
        $userInterestData->delete();
    }
    
    /**
     * 
     * @param type $userCreationID
     */
    private function _deleteImagesByUserCreationID($userCreationID) {
        $userInterestData = UserCreationImages::where('user_creation_id', '=', $userCreationID);
        $userInterestData->delete();
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function destroy($id) {
        $creation = Creation::findOrFail($id);
        $creation->delete();
        $this->_deleteImagesByUserCreationID($id);
        Session::flash('flash_message', 'Creation successfully deleted!');
        return redirect('creation/list');
    }

    public function edit($id) {
        $creationData = Creation::findOrFail($id);
        $userCreationImages = UserCreationImages::where('user_creation_id', '=', $id)->get();
        $userData = User::where('id', '=', $creationData->user_id)->get();			
        $userInterestSelected = $this->_fetchInterestByUserID($creationData->user_id);        
		$userInterestData = Interest::all();
        return view('creation.edit', array("creationData" => $creationData, 'userData' => $userData, 'userInterestData' => $userInterestData, 'userCreationImages' => $userCreationImages));
    }

    /**
     * 
     * @param type $id
     * @param Request $request
     */
    public function update($id, Request $request) {
        $this->validate($request, [   
			'user_id' => 'required',
            'title' => 'required',
            'interest' => 'required',
        ]);
        
        $featuredPhotos = $request->file('featuredPhotos');
        
        $featuredPhotoUploaded = array();
        
        if (isset($featuredPhotos)) {
            foreach($featuredPhotos as $featuredPhoto) { 
                if(!empty($featuredPhotos[0])) {                    
                    $featuredPhotoUploaded[] = $this->_uploadPic($featuredPhoto);
                }
            }
        }                
        
        $otherPhotos = $request->file('otherPhotos');
        
        $otherPhotosUploaded = array();
        if (isset($otherPhotos)) {
            foreach($otherPhotos as $otherPhoto) {  
                if(!empty($otherPhoto)) {
                    $otherPhotosUploaded[] = $this->_uploadPic($otherPhoto);
                }
            }
        }
        
        $requestData = array();
        $creationData = Creation::findOrFail($id);        
        $requestData['title'] = $request->input('title');
        $requestData['location'] = $request->input('location');
        $requestData['interest_id'] = $request->input('interest');
        $requestData['description'] = $request->input('description');                                          
        $creationData->fill($requestData)->save();
        
        if($featuredPhotoUploaded) {
            $this->_deleteImagesByUserCreationIDFeatured($id, true);
            $this->_saveImages($id, $featuredPhotoUploaded, true, false);
        }
        if($otherPhotosUploaded) {
            $this->_deleteImagesByUserCreationIDFeatured($id, false);
            $this->_saveImages($id, $otherPhotosUploaded, false, false);
        }
        Session::flash('flash_message', 'Creation successfully Updated!');
        return redirect()->back();
    }

    /**
     *
     * @param type $file
     * @return string
     */
//    private function _uploadPic($file) {
//        $creationPic = $file;
//        $creationImageDirectory = env('UPLOADS_DIRECTORY') . "/" . env('UPLOADS_CREATION_DIRECTORY');
//        $destinationPath = public_path() . sprintf("/" . $creationImageDirectory . "/");
//        $creationPicName = uniqid() . '_' . $creationPic->getClientOriginalName();
//        $creationPic->move($destinationPath, $creationPicName);
//        $this->_createThumb($destinationPath, $creationPicName);
//        return $creationPicName;
//    }
//
//    /**
//     *
//     * @param type $directory
//     * @param type $file
//     */
//    private function _createThumb($directory, $file) {
//        $fileLocation = $directory."/".$file;
//        $fileThumbLocation = $directory."/".env('UPLOAD_THUMB_DIRECTORY')."/".$file;
//        $thumbDirectory = $directory.'/'.env('UPLOAD_THUMB_DIRECTORY');
//        if(!file_exists($thumbDirectory)) {
//           File::makeDirectory($thumbDirectory, $mode = 0777, true, true);
//        }
//        $thumbnail = Image::open($fileLocation)
//            ->thumbnail(new \Imagine\Image\Box(300,300));
//
//        $thumbnail->save($fileThumbLocation);
//
//        /*Image::make($fileLocation, array(
//            'width' => 300,
//            'height' => 300
//        ))->save($fileThumbLocation);*/
//    }
    
    private function _fetchInterestByUserID($userID) {
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
                "title" => $data->title,
                "id" => $data->id
            );
            $returnData[] = $interestDataArray;  
        }
        return $returnData;
    }

}
