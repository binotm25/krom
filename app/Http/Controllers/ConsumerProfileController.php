<?php

namespace App\Http\Controllers;

use App\Models\Creation;
use App\Models\EmailConfirm;
use App\Models\Interest;
use App\Models\PasswordReset;
use App\Models\Praise;
use App\Models\User;
use App\Models\UserInterest;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ConsumerProfileController extends Controller
{

    use ImageUploadTraits;
    protected $User, $creation, $AuthUser, $UserInterest, $Country, $Creation, $userInterest, $Praise;

    public function __construct(Interest $interest, UserInterest $userInterest, Creation $creation, User $user, Praise $praise) {
        $this->UserInterest = $userInterest;
        $this->Interest     = $interest;
        $this->Creation     = $creation;
        $this->User         = $user;
        $this->Praise       = $praise;
        if(Auth::user()){
            $this->AuthUser = Auth::user();
            $this->userInterest = $this->UserInterest->InterestIds(Auth::user()->id);
        }
    }

    public function viewProfile($user)
    {
        $id = strrev(substr($user, 32));
        if($id == $this->AuthUser->id){
            return redirect()->route('my_profile');
        }
        $isAuthUser = null;
        $userData = $this->User->findOrFail($id);
        $interests = $this->Interest->whereIn('id', $this->UserInterest->InterestIds($id))->orderBy('title', 'asc')->get();
        $creations = $this->Creation->whereUser_id($id)->with('userCreationImages','praise')->orderBy('created_at', 'desc')->get();
        $praise = $this->praiseUser();
        $colId = $this->collabUser($this->AuthUser->id);
        $interestNames = $this->Interest->GetInterestsNames();
        return view('user.profile', compact('userData', 'interests', 'creations', 'colId', 'isAuthUser', 'praise', 'interestNames'));
    }

    public function myProfile() {
        $id = $this->AuthUser->id;
        $isAuthUser = $id;
        $userData = $this->User->findOrFail($id);
        $interests = $this->Interest->whereIn('id', $this->userInterest)->orderBy('title', 'asc')->get();
        $creations = $this->Creation->whereUser_id($this->AuthUser->id)->with('userCreationImages','praise')->orderBy('created_at', 'desc')->get();
        $praise = $this->praiseUser();
        $interestNames = $this->Interest->GetInterestsNames();
        return view('user.profile', compact('userData', 'interests', 'creations', 'isAuthUser', 'praise', 'interestNames'));
    }

    public function myProfileEdit()
    {
        $id = $this->AuthUser->id;
        $userData = $this->User->findOrFail($id);
        $interests = $this->Interest->whereIn('id', $this->userInterest)->get();
        return view('user.myProfile', compact('userData', 'interests'));
    }

    public function updateProfile(Requests\UpdateUserProfileRequest $request)
    {
        $user = $this->User->find($this->AuthUser->id);
        $user->fill($request->input())->save();
        return redirect()->back()->with(['info'=>'Your profile has been updated successfully.', 'type'=>'Success']);
    }

    public function updatePics(Request $request)
    {
        $userPic = $request->userImage;
        if ($request->file('userImage')->isValid()) {
            $this->validate($request, [
                'userImage'  =>  'image|required'
            ]);
            $res = $this->_uploadPic($userPic, 'temp');
        }
        print_r($res);
        die();
    }

    public function profilePic(Request $request)
    {
        $req = $request->get('logic');
        $file = $request->get('file');
        $imageType = $request->get('type');
        $this->validate($request, [
            'file'  =>  'string|required'
        ]);
        if($imageType == 'profile'){ $uploadLocation = env('PROFILE_PIC_DIR'); $col = 'profile_pic'; }
        else if($imageType == 'cover'){ $uploadLocation = env('UPLOADS_COVER_DIRECTORY'); $col = 'cover_pic'; }
        //dd($imageType.' - '.$col);
        if($req === "1"){
            if ( ! File::move(env('TEMP_DIR').'/'.$file, $uploadLocation.'/'.$file))
            {
                print_r("error");
                die();
            }
            $this->_createThumb($uploadLocation, $file, $imageType);
            $user = $this->User->find($this->AuthUser->id);
            $previous = $user->$col;
            $user->$col = $file;
            $user->save();
            if(File::exists($uploadLocation.'/'.$previous)){
                $filesOld = array($uploadLocation.'/'.$previous, $uploadLocation.'/thumb/'.$previous);
                File::delete($filesOld);
            }
            print_r($uploadLocation.'/'.$file);
            $file = null;
            die();
        }
        elseif($req == "0"){
            File::delete(env('TEMP_DIR').'/'.$file);
            print_r('The file has been Deleted!');
            die();
        }
    }

    public function changePasswordGet()
    {
        return view('user.password');
    }

    public function changePasswordPost(Request $request)
    {
        $oldPassword = $request->c_pass;
        $this->validate($request, [
            'c_pass'    =>  'required|string',
            'pwd'       =>  'required|string',
            'pwd_c'     =>  'required|same:pwd'
        ]);

        if(Hash::check($oldPassword, $this->AuthUser->password)){

            $user = $this->User->find($this->AuthUser->id);
            $user->password = bcrypt($request->pwd);
            $user->save();
            return redirect()->route('edit_profile')->with(['info'=>'Your Password has been changed successfully!', 'type'=>'Success']);

        }

        return redirect()->back()->with(['info'=>'Your Password doesn"t match the Old Password!', 'type'=>'Failure']);

    }

    public function myInterest(Request $request)
    {
        $interestData = $this->Interest->orderBy('title','asc')->get();

        $userInt = $this->UserInterest->whereUser_id($this->AuthUser->id)->pluck('interest_ids')->first();
        $int = explode(',', $userInt);
        return view('interests.edit', compact('int', 'interestData'));
    }

    public function myInterestPatch(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'interest'  =>  'required|array|min:3'
        ]);
        $interestIDs = $request->input('interest');
        $interestIDsImploded = implode(",", $interestIDs);
        UserInterest::whereUser_id($this->AuthUser->id)->update(['interest_ids' => $interestIDsImploded]);
        return redirect()->back()->with(['info'=>'Your changes have been made.', 'type'=>'Success']);
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

    public function praisePost($id)
    {
        $id = strrev(substr($id, 32));
        $checkCreation = $this->Creation->find($id);
        if(isset($checkCreation->user_id)) {
            $interestId = $checkCreation->interest_id;
            $praise = $this->Praise->where(['creation_id'=>$id, 'user_id'=>$this->AuthUser->id]);
            $praiseIf = $praise->pluck('action')->first();
            if(isset($praiseIf)){
                if($praiseIf == 1){
                    $praiseId = $praise->first()->id;
                    $check = $praise->delete();
                    if($check){
                        return ['0',$praiseId,'0','0'];
                    }
                }else{
                    $check = $praise->update(['action' => 1]);
                    if($check){
                        return ['1',$this->AuthUser->profile_pic,md5(rand(9999,0000)).strrev($this->AuthUser->id),'red'];
                    }
                }
            }else{
                $praise = $this->Praise->create([
                    'creation_id'   =>  $id,
                    'interest_id'   =>  $interestId,
                    'user_id'       =>  $this->AuthUser->id,
                    'action'        =>  1,
                ]);
                if($praise){
                    return ['1',$this->AuthUser->profile_pic,md5(rand(9999,0000)).strrev($this->AuthUser->id),$praise->id];
                }else{
                    return ['2','0','0','0'];
                }
            }
        }
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

    public function checkEmail(Request $request)
    {
        $email = $request->email;
        $this->validate($request,[
           'email'  =>  'email'
        ]);
        $check = $this->User->whereEmail($email)->first();
        if($check){
            return "This Email is already in used!";
        }else{
            return "This Email is OK!";
        }

    }

    public function getPraisePost(Request $request)
    {
        $id = strrev(substr($request->creationId, 32));
        $creationPraises = $this->Creation->with('praise')->find($id);
        $count = $creationPraises->praise->count();
        return view('user.ajax.creationPraise', compact('creationPraises','count'))->render();
    }

    public function verifyEmail($id)
    {
        $confirm = EmailConfirm::whereCode($id)->first();
        if($confirm->email){
            $user = $this->User->whereEmail($confirm->email)->first();
            $user->status = 'active';
            $user->save();
        }else{
            dd('This is verification code is not available');
        }
        $confirm->delete();
        return redirect('/login')->with(['verify_email'=>'You have successfully verified your email. Now login with your credentials.']);
    }

    public function falsePasswordReset($id)
    {
        $email = PasswordReset::where('token',$id)->first();
        $user = $this->User->whereEmail($email->email)->first();
        Mail::send('auth.emails.falsePasswordReset', ['user' => $user], function ($m) use ($user) {
            $m->from($user->email, $user->email);

            $m->to('admin@kritish.com', 'Kritish')->subject('False Password Reset Links!');
        });
        $email->delete();
        return view('user.email.false');
    }
}


