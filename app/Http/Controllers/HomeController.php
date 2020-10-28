<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Post;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->limit(5)->get();

        return view('home', compact('posts'));
    }

    public function edit_profile()
    {
        return view('auth.profile');
    }

    public function update_profile(Request $request)
    {
        $validation_array = [
            'name' => ['required', 'string', 'max:255']
        ];

        if (trim($request->password) !== '') {
            $validation_array['password'] = ['sometimes', 'required', 'string', 'min:8', 'confirmed'];
        }

        $request->validate($validation_array);

        $user = User::find(Auth::user()->id);

        $user->name = $request->name;
        $user->password = trim($request->password) !== '' ? Hash::make($request->password) : $user->password;

        if ($user->save()) {
            $notification = [
                'status' => 'success',
                'message' => 'Profile updated'
            ];
        } else {
            $notification = [
                'status' => 'error',
                'message' => 'An unexpected error occured'
            ];
        }

        return redirect()->route('edit_profile')->with($notification);
    }
}
