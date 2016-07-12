<?php

namespace App\Http\Controllers;

use App\Models\Collaborate;
use App\Models\Creation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CollaborateController extends Controller
{
    protected $Creation, $AuthUser, $User, $Collaborate;

    public function __construct(Creation $creation , User $user, Collaborate $collaborate)
    {
        $this->Creation = $creation;
        $this->User = $user;
        if(Auth::user()){
            $this->AuthUser = Auth::user();
        }
        $this->Collaborate = $collaborate;
    }

    public function collaborateGet($id)
    {
        $realId = strrev(substr($id, 32));
        $creation = $this->Creation->findOrFail($realId);
        $user = $this->User->find($this->AuthUser->id);
        return view('user.collaboration.add', compact('creation', 'user'));
    }

    public function collaboratePost($id, Request $request)
    {
        $creationId = strrev(substr($id, 32));
        $userId = $this->Creation->findOrFail($creationId);
        $user = $this->User->find($userId->user_id);

        $this->validate($request, [
            'msg'           =>  'required'
        ]);

        DB::table('collaborate')->insert([
            'user_creation_id'  =>  $creationId,
            'user_mapped'       =>  $this->AuthUser->id,
            'message'           =>  $request->msg,
            'created_on'        => Carbon::now()
        ]);
        $count = Session::get('collaborationsCount') + 1;
        Session::put('collaborationsCount', $count);

        $emailContent = [
            'sender' => $this->AuthUser->name,
            'senderId' => $this->AuthUser->id,
            'receiver'=> $user->name,
            'title'=> $userId->title
        ];

        Mail::send('user.collaboration.email.confirm', $emailContent, function($message) use($user)
        {
            $message->from('info@kritish.com', 'Kritish');
            $message->to($user->email, $user->name)
                ->subject('Kritish Collaboration Request Received');
        });

        return redirect()->route('user_feeds')->with(['info'=>'You have successfully collaborated with '. $user->name, 'type'=>'success']);
    }

    public function lists()
    {
        $creations = $this->Creation->whereUser_id($this->AuthUser->id)->with('collaborate')->get();
        $count = 0;
        foreach($creations as $creation){
            $count += $creation->collaborate->count();
            if($count > 0){ break; }
        }
        $collaborate = $this->Collaborate->whereUser_mapped($this->AuthUser->id)->orderBy('created_on', 'desc')->get();
        return view('user.collaboration.list', compact('creations','collaborate','count'));
    }
}
