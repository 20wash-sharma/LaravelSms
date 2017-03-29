<?php

namespace App\Http\Controllers;


use DB;
use Auth;
use Hash;
use Request;
 
  use Validator;
class UserController extends Controller
{
     public function __construct() {
        $this->middleware('auth');
    }
    
       public function profile()
    {
        DB::connection()->enableQueryLog();
       // $messages = Message::join('users', 'users.id', '=', 'messages.sender_id')->where('messages.receiver_id', '=', Auth::user()->id)->paginate(3);
        // $messages = Message::paginate(3);
   // $messages = User::with('messages')->paginate(3);
         $user=DB::table('users')
    
            
            ->select('*')
         
   
             ->where('users.id', '=', Auth::user()->id)
    ->get();
        
          
    
    
   
    return view('profile', compact('user'));
       // return view('message.index', compact('messages'));
    }
        public function updateProfile(Request $request)
    {
         $user = Auth::user();
        

  $validation = Validator::make(Request::all(), [

    // Here's how our new validation rule is used.
      'oldpassword' => 'hash:' . $user->password,
    'newpassword' => 'required|different:oldpassword|confirmed',
   
     
  ]);

  if ($validation->fails()) {
    return redirect()->back()->withErrors($validation->errors());
  }

  $user->password = Hash::make(Request::input('newpassword'));
  $user->name = Request::input('name');
  $user->save();

  return redirect()->back()
    ->with('success-message', 'Your new password is now set!');
    }
}
