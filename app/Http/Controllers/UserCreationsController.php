<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Creation;
use App\Models\Interest;
use App\Models\User;
use App\Models\UserCreationImages;
use App\Models\UserInterest;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\File;

class UserCreationsController extends Controller
{

    use ImageUploadTraits;
    protected $AuthUser, $User, $Interest, $UserInterest, $Country, $Creation, $userInterest, $UserCreationImage;

    public function __construct(Interest $Interest, UserInterest $UserInterest, Creation $Creation, User $User, UserCreationImages $images) {
        $this->Interest          = $Interest;
        $this->UserInterest      = $UserInterest;
        $this->Creation          = $Creation;
        $this->User              = $User;
        $this->UserCreationImage = $images;
        if(Auth::user()){
            $this->AuthUser = Auth::user();
            $this->userInterest = $this->UserInterest->InterestIds(Auth::user()->id);
        }
    }

    /**
     * @return Redirect to the Creation Page with Interests
     */
    public function addCreationGet()
    {
        $interests = $this->Interest->orderBy('title', 'asc')->get();
        return view('user.creations.add', compact('interests'));
    }

    /**
     * @param Requests\addCreationRequest $request Gets the Request after the  validation
     * @return \Illuminate\Http\RedirectResponse - Updated
     */
    public function addCreationPost(Requests\addCreationRequest $request)
    {
        $res = [];
        if($request->has('user_id')){
            $userId = $request->user_id;
        }else{
            $userId = $this->AuthUser->id;
        }
        foreach($request->uploadFile as $key=>$images){
            if($key == 3){
                break;
            }else{
                $res[] = $this->_uploadPic($images, "creation");
                $keyValue = $key;
            }
        }
        if(!empty($request->uploadFile1[0])){
            foreach($request->uploadFile1 as $images){
                $res[] = $this->_uploadPic($images, "creation");
            }
        }

        $countryName = Country::whereCountry_code($this->AuthUser->country_code)->first()->country_name;
        $check = in_array("error", $res);
        if(!$check){
            $creation = Creation::create([
                'user_id'       =>  $userId,
                'title'         =>  $request->input('title'),
                'location'      =>  $this->AuthUser->city.', '. $countryName,
                'interest_id'   =>  $request->input('sel-int'),
                'description'   =>  nl2br($request->input('desc'))
            ]);
            $creation_id = $creation->id;
            foreach($res as $key=>$images){
                if($key < $keyValue + 1){
                    UserCreationImages::create([
                        'user_creation_id'  =>  $creation_id,
                        'image'             =>  $images,
                        'featured'          =>  1
                    ]);
                }else{
                    UserCreationImages::create([
                        'user_creation_id'  =>  $creation_id,
                        'image'             =>  $images,
                        'featured'          =>  0
                    ]);
                }

            }
            return redirect()->back()->with(['info' => 'You have successfully added a new creation.', 'type' => 'Success']);
        }
    }

    public function showCreation($id)
    {
        $colId = $this->collabUser($this->AuthUser->id);
        $realId = strrev(substr($id, 32));
        $praise = $this->praiseUser();
        $creation = $this->Creation->with('userCreationImages', 'praise')->findOrFail($realId);
        $interestNames = $this->Interest->GetInterestsNames();
        return view('user.creations.creation', compact('creation', 'colId', 'praise', 'interestNames'));
    }

    /**
     * @param $id of the Creation that will be edited
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function editCreationGet($id)
    {
        $realId = strrev(substr($id, 32));
        $creation = $this->Creation->with('userCreationImages')->findOrFail($realId);
        if($creation->user_id == $this->AuthUser->id){
            $count = 1;
            //$creationImage = UserCreationImages::whereUser_creation_id($realId)->first();
            $interests = $this->Interest->whereIn('id', $this->userInterest)->orderBy('title','asc')->get();
            return view('user.creations.edit', compact('creation', 'interests', 'count'));
        }else{
            return redirect()->back()->with(['info'=>'Sorry this is not your creation', 'type'=>'Failure']);
        }
    }

    public function editCreationDelete($id)
    {
        $realId = strrev(substr($id, 32));
        $creation = $this->Creation->find($realId);
        $creationImage = $this->UserCreationImage->whereUser_creation_id($creation->id)->get();
        foreach($creationImage as $image){
            File::delete(env('UPLOADS_CREATION_DIRECTORY').$image->image, env('UPLOADS_CREATION_DIRECTORY').'/thumb/'.$image->image);
        }
        $this->UserCreationImage->whereUser_creation_id($creation->id)->delete();
        if(!$creation = $this->Creation->find($realId)->delete()){
            return redirect()->back()->with(['info'=>'Delete failed please check the Creation!', 'type'=>'Failure']);
        }
        return redirect()->route('user_feeds')->with(['info'=>'Creation Deleted Successfully!', 'type'=>'Success']);

    }

    /**
     * @param $id of the Creation
     * @param Request $request
        * @return \Illuminate\Http\RedirectResponse
    */
    public function editCreationPatch($id, Request $request)
    {
        $realId = strrev(substr($id, 32));
        $creation = $this->Creation->findOrFail($realId);
        $this->validate($request, [
            'title'         =>  'required|max:60',
            'sel-int'       =>  'required|numeric',
            'desc'          =>  'required|min:3',
            'uploadFile'    =>  'image'
        ]);

//        if($request->uploadFile){
//            $res = $this->_uploadPic($request->uploadFile, "creation");
//            if($res){
//                unlink(UserCreationImages::find($realId)->image);
//            }
//        }

        $creation->fill([
            'title' => $request->get('title'),
            'interest_id' => $request->get('sel-int'),
            'description' => $request->get('desc')
        ])->save();
        return redirect()->back()->with(['info'=>'All your changes have been saved successfully and will be reflected in your feed.', 'type'=>'Success']);
    }

    public function updateImages(Request $request, $getId)
    {
        if($getId != 0){
            $images = $request->uploadFile;
            $id = $getId;
        }else{
            $id = $request->creationId;
        }
        $image = $this->UserCreationImage->findOrFail($id);
        $creationIds = $image->user_creation_id;
        $imageType = $image->featured;
        $featuredImageCount = $this->UserCreationImage->where(['user_creation_id'=>$creationIds, 'featured'=>'1'])->count();
        if($getId == 0){
            if($imageType == 1) {
                if($featuredImageCount > 1){
                    File::delete(env('UPLOADS_CREATION_DIRECTORY').'/'.$image->image, env('UPLOADS_CREATION_DIRECTORY').'/thumb/'.$image->image);
                    $image->delete();
                    return 1;
                }else{
                    return "You Cannot delete this Image as this is the Last Featured Photos.";
                }
            }else{
                File::delete(env('UPLOADS_CREATION_DIRECTORY').'/'.$image->image, env('UPLOADS_CREATION_DIRECTORY').'/thumb/'.$image->image);
                $image->delete();
                return 1;
            }
        }else{
            $res = $this->_uploadPic($images, "creation");
            File::delete(env('UPLOADS_CREATION_DIRECTORY').'/'.$image->image, env('UPLOADS_CREATION_DIRECTORY').'/thumb/'.$image->image);
            $image->image = $res;
            $image->save();
            return env('UPLOADS_CREATION_DIRECTORY').'/thumb/'.$res;
        }
    }

    public function addImagesEdit(Request $request, $getId)
    {
        $creationId = $getId; $keyValue = null;
        //dd(empty($request->uploadFileOther));
        $featuredImageCount = $this->UserCreationImage->where(['user_creation_id'=>$creationId, 'featured'=>'1'])->count();
        if(!empty($request->uploadFileFeatured)){
            if($featuredImageCount == 3){
                return "You cannot add more Featured Photos. Only 3 Featured Photos are allowed.";
            }else {
                foreach($request->uploadFileFeatured as $key=>$images) {
                    if ($key > (2 - $featuredImageCount)) {
                        break;
                    } else {
                        $res[] = $this->_uploadPic($images, "creation");
                        $keyValue = $key;
                    }
                }
            }
        }
        //dd(is_numeric($keyValue));
        if(!empty($request->uploadFileOther)){
            foreach($request->uploadFileOther as $images){
                $res[] = $this->_uploadPic($images, "creation");
            }
        }
        foreach($res as $key=>$images){
            if(is_numeric($keyValue)){
                if($key < $keyValue + 1){
                    UserCreationImages::create([
                        'user_creation_id'  =>  $creationId,
                        'image'             =>  $images,
                        'featured'          =>  1
                    ]);
                }else{
                    UserCreationImages::create([
                        'user_creation_id'  =>  $creationId,
                        'image'             =>  $images,
                        'featured'          =>  0
                    ]);
                }
            }else{
                UserCreationImages::create([
                    'user_creation_id'  =>  $creationId,
                    'image'             =>  $images,
                    'featured'          =>  0
                ]);
            }

        }
        return "1";
    }

    public function collabUser($id)
    {
        $collabUser = $this->User->with('collaboration')->find($id);
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
}
