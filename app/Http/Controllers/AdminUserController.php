<?php

namespace App\Http\Controllers;

use App\Messenger;
use App\User;
use Chatify\Http\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 10;

        if (!empty($keyword)) {
            $user = User::latest()->paginate($perPage);
        } else {
            $user = User::latest()->paginate($perPage);
        }

        return view('directory.posts.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('directory.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        User::create($requestData);

        return redirect('admin/users/index')->with  ('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('directory.posts.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('directory.posts.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();

        $user = User::findOrFail($id);
        $user->update($requestData);

        return redirect('admin/users/index')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('admin/users/index')->with('flash_message', 'Users deleted!');
    }


    public function view_messages_for_user (Request $request)
    {
        $id =$request->all();
        if($id) {
            $messages = Messenger::orderBy('created_at', 'desc')->where('from_id', $id['users_id'])->get();
              $users = User::all();
        }
        return response()->json(['messages'=>$messages,'users'=>$users]);
    }

    public function view_messages_to_user (Request $request)
    {
        $id =$request->all();
        if($id) {
            $messages = Messenger::orderBy('created_at', 'desc')->where('to_id', $id['user_to_id'])->get();
            $users = User::all();
        }
        return response()->json(['messages'=>$messages,'users'=>$users]);
    }
}
