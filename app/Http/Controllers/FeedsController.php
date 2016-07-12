<?php

namespace App\Http\Controllers;

use App\Models\Creation;
use App\Models\Interest;
use App\Models\User;
use App\Models\UserInterest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FeedsController extends Controller
{
    protected $User, $creation, $AuthUser, $UserInterest, $Country, $Creation, $userInterest;

    public function __construct(Interest $Interest, UserInterest $UserInterest, Creation $Creation, User $User) {
        $this->UserInterest = $UserInterest;
        $this->Interest     = $Interest;
        $this->Creation     = $Creation;
        $this->User         = $User;
        if(Auth::user()){
            $this->AuthUser = Auth::user();
            $this->userInterest = $this->UserInterest->InterestIds(Auth::user()->id);
        }
    }

    /**
     * @return to the Feeds List page with all the Feeds which is related to Interests.
     */
    public function listFeeds(Request $request) {
        $colId = $this->collabUser();
        $creations = $this->Creation->whereIn('interest_id', $this->userInterest)->with('user', 'userCreationImages', 'praise')->orderBy('created_at', 'desc')->paginate(20);
        if($creations->count() < 20){
            $nextPage = false;
        }else{
            $nextPage = true;
        }
        $praise = $this->praiseUser();
        $interestNames = $this->Interest->GetInterestsNames();
        if($request->ajax()){
            return [
                'posts' => view('user.ajax.feedsList', compact('creations', 'colId', 'praise', 'interestNames'))->render(),
                'nextPage' => $creations->nextPageUrl()
            ];
        }
        return view('user.feedsList', compact('creations', 'colId', 'praise', 'interestNames', 'nextPage'));
    }

    /**
     * @return only the Creations which is created by the Logged In User
     */
    public function myListingsGet(Request $request){
        $creations = $this->Creation->whereUser_id($this->AuthUser->id)->with('userCreationImages','praise')->orderBy('created_at', 'desc')->paginate(20);
        if($creations->count() < 20){
            $nextPage = false;
        }else{
            $nextPage = true;
        }
        $praise = $this->praiseUser();
        $interestNames = $this->Interest->GetInterestsNames();
        if($request->ajax()){
            return [
                'posts' => view('user.ajax.feedsList', compact('creations', 'colId', 'praise', 'interestNames'))->render(),
                'nextPage' => $creations->nextPageUrl()
            ];
        }
        return view('user.feedsList', compact('creations','praise', 'interestNames', 'nextPage'));
    }

    public function collabUser()
    {
        $collabUser = $this->User->with('collaboration')->find($this->AuthUser->id);
        $colId = [];
        foreach($collabUser->collaboration as $col_Id){
            $colId[] = $col_Id->user_creation_id;
        }
        return $colId;
    }

    public function praiseUser()
    {
        $userPraise = $this->User->with('praise')->find($this->AuthUser->id);
        $praiseId = [];
        foreach($userPraise->praise as $praise){
            $praiseId[] = $praise->creation_id;
        }
        return $praiseId;
    }

    public function search(Request $request)
    {
        $colId = $this->collabUser($this->AuthUser->id);
        $data = $request->search;
        if($data == ""){return redirect()->route('user_feeds')->with(['info'=>'Please enter a search term.', 'type'=>'Error']); }
        $items = $this->Creation->where('title', 'LIKE', "%".$data."%")->orderBy('created_at', 'desc')->with('praise')->paginate(50);
        $grouped = $items->groupBy('interest_id');
        $countMasing = [];
        $userInt = $this->UserInterest->whereUser_id($this->AuthUser->id)->pluck('interest_ids')->first();
        $int = explode(',', $userInt);
        foreach($grouped as $key=>$value){
            $countMasing[$key] = $value->count();
        }

        $interestNames = $this->Interest->GetInterestsNames();
        $praise = $this->praiseUser();
        return view('user.search', compact('data', 'items', 'colId', 'praise', 'interestNames', 'grouped', 'countMasing'));
    }

}
