<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Message;
use Illuminate\Session\Store;
use App\Reply;
use Excel;

class MessageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        // $messages = Message::join('users', 'users.id', '=', 'messages.sender_id')->where('messages.receiver_id', '=', Auth::user()->id)->paginate(3);
        // $messages = Message::paginate(3);
        // $messages = User::with('messages')->paginate(3);
        $messages = DB::table('messages')
                ->join('users', 'users.id', '=', 'messages.sender_id')
                ->select('messages.*', 'users.email', 'users.name')
                ->where('messages.receiver_id', '=', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(3);





        return view('message.index', compact('messages'));
        // return view('message.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $users = DB::table('users')
                ->select('users.*')
                ->where('id', '!=', Auth::user()->id)
                ->get();
        return view('message.create', ['users' => $users]);
        //return view ('message.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Store $session) {
        $this->validate($request, ['email' => 'required', 'title' => 'required', 'message' => 'required|min:5']);
        $message = new Message();
        $message->title = $request->title;
        $message->message = $request->message;
        $message->receiver_id = $request->email;
        $message->sender_id = Auth::user()->id;
        $message->save();
        $session->flash('post_success', 'message sent successfully');
        return redirect()->route('message.create', ['id' => $message->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        DB::connection()->enableQueryLog();

        $message = DB::table('messages')
                ->join('users', 'users.id', '=', 'messages.sender_id')
                ->select('messages.*', 'users.email', 'users.name')
                ->where('messages.id', '=', $id)
                ->get();
        $replies = DB::table('replies')
                ->join('users', 'users.id', '=', 'replies.sender_id')
                ->select('replies.*', 'users.email', 'users.name')
                ->where('replies.message_id', '=', $id)
                ->orderBy('created_at', 'asc')
                ->get();
        //echo '<pre>';
        // print_r( DB::getQueryLog());
        return view('message.view', ['message' => $message, 'replies' => $replies]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        DB::table('messages')
                ->where('id', $id)
                ->update(['importance' => $request->updatevalue]);

        return redirect()->route('message.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function sent() {
        DB::connection()->enableQueryLog();
        // $messages = Message::join('users', 'users.id', '=', 'messages.sender_id')->where('messages.receiver_id', '=', Auth::user()->id)->paginate(3);
        // $messages = Message::paginate(3);
        // $messages = User::with('messages')->paginate(3);
        $messages = DB::table('messages')
                ->join('users', 'users.id', '=', 'messages.receiver_id')
                ->select('messages.*', 'users.email', 'users.name')
                ->where('messages.sender_id', '=', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(3);





        return view('message.sent', compact('messages'));
    }

    public function reply(Request $request, Store $session) {
        // echo $request->comments;
        $receiver_id = $request->receiver_id;
        if ($receiver_id == Auth::user()->id)
            $receiver_id = $request->sender_id;

        $this->validate($request, ['title' => 'required', 'reply' => 'required|min:5']);

        $reply = new Reply();
        $reply->title = $request->title;
        $reply->message = $request->reply;
        $reply->message_id = $request->message_id;
        $reply->sender_id = Auth::user()->id;
        $reply->receiver_id = $receiver_id;
        $reply->save();
        $session->flash('post_success', 'replied successfully');
        return redirect()->route('message.show', ['id' => $reply->message_id]);
    }

    public function excelimportexport() {
        return view('message.importexport');
    }

    public function export(Store $session) {

        $data = DB::table('users')
                ->select('users.*')
                ->get();
        $arrays = array();
        foreach ($data as $object) {
            $arrays[] = (array) $object;
        }

        Excel::create('Users', function($excel) use($arrays) {

            $excel->sheet('UserSheet', function($sheet) use($arrays) {

                $sheet->fromArray($arrays);
            });
        })->export('xlsx');
        $session->flash('post_success', 'export successful');
        return redirect()->route('message.importexport');
    }

    public function import(Request $request, Store $session) {
        $this->validate($request, [

            'excelfile' => 'required | mimes:application/vnd.ms-excel,xlsx',
        ]);

        $file = $request->file('excelfile');
       
        Excel::load($file, function($reader) {

            // Getting all results
            $results = $reader->get();
            $userArray=$reader->toArray();
            echo '<pre>';
            print_r($userArray);
            //print_r($results);
            // ->all() is a wrapper for ->get() and will work the same
            // $results = $reader->all();
            $reader->each(function($sheet) {

                // Loop through all rows
                $sheet->each(function($row) {
                    echo$row.'<br>';
                });
            });
        });
exit();

        $session->flash('post_success', 'format is correct');
        return redirect()->route('message.importexport');
    }

}
