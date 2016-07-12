<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Interest;
use App\Models\UserInterest;
use Illuminate\Support\Facades\Session;
use Folklore\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class InterestController extends Controller {
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
        $interestData = Interest::all();
        return view('interest.list', array("interestData" => $interestData));
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
    public function store(Request $request) {
		$this->validate($request, [
            'name' => 'required'
        ]);
        $interestPic = $request->file('interestPic');
        $imageUploaded = "";
        if (isset($interestPic)) {
            $imageUploaded = $this->_uploadPic($interestPic, 'interest');
        }
        $interest = new Interest();
        $interest->title = $request->input('name');
        $interest->status = $request->input('status');
        $interest->image = $imageUploaded;
        $interest->save();
        return redirect()->route('admin_interest_list');
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
        return redirect()->route('admin_interest_list');
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
            $imageUploaded = $this->_uploadPic($requestData['interestPic'], 'interest');
            $requestData['image'] = $imageUploaded;
        }
        unset($requestData['interestPic']);
        $interestData->fill($requestData)->save();
        Session::flash('flash_message', 'Interest successfully Updated!');
        return redirect()->back();
    }
    
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

}
