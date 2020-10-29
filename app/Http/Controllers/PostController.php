<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('id', 'desc');

        if (is_numeric($request->query('category')) && in_array($request->query('category'), [1, 2, 3, 4])) {
            $posts = $posts->where('category_id', $request->query('category'));
        }

        $posts = $posts->paginate(3);

        $categories = Category::all();

        return view('posts.list', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('posts.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'content' => ['required', 'max:10000'],
            'category' => ['required', 'in:1,2,3,4'],
            'banner_image' => ['required', 'max:4096', 'mimetypes:image/jpeg']
        ]);

        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->category_id = $request->category;
        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content;
        $post->url = strtolower(preg_replace("/[^A-z0-9]+/", "-", $request->title));

        if ($post->save()) {
            $banner_image_name = md5($request->file('banner_image')->getClientOriginalName() . time()) . "." . $request->file('banner_image')->extension();
            $request->file('banner_image')->storeAs('public/banner_images/' . $post->id, $banner_image_name);
        
            $post->banner_image = $banner_image_name;

            if ($post->update()) {
                $notification = [
                    'status' => 'success',
                    'message' => 'New post added'
                ];
            } else {
                $notification = [
                    'status' => 'error',
                    'message' => 'An error occured'
                ];
            }
        } else {
            $notification = [
                'status' => 'error',
                'message' => 'An error occured'
            ];
        }

        return redirect()->route('my_posts')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $url)
    {
        $post = Post::where(['id' => $id, 'url' => $url])->first();

        if ($post) {
            return view('posts.view', compact('post'));
        } else {
            return redirect()->route('my_posts');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->first();

        if ($post) {
            $categories = Category::all();

            return view('posts.edit', compact('post', 'categories'));
        } else {
            return redirect()->name('my_posts');
        }        
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
        if (isset($id)) {
            $validation_array = [
                'title' => ['required', 'max:255'],
                'description' => ['required', 'max:255'],
                'category' => ['required', 'in:1,2,3,4'],
                'content' => ['required', 'max:10000']
            ];

            if ($request->hasFile('banner_image')) {
                $validation_array['banner_image'] = ['max:4096', 'mimetypes:image/jpeg'];
            }

            $request->validate($validation_array);

            $post = Post::find($id);

            if ($post->id && $post->user_id === Auth::user()->id) {
                $post->title = $request->title;
                $post->description = $request->description;
                $post->content = $request->content;
                $post->category_id = $request->category;
                $post->url = strtolower(preg_replace('/[^A-z0-9]+/', '-', $request->title));

                if ($request->hasFile('banner_image')) {
                    $banner_image_name = md5($request->file('banner_image')->getClientOriginalName() . time()) . '.' . $request->file('banner_image')->extension();
                    $request->file('banner_image')->storeAs('/public/banner_images/' . $post->id, $banner_image_name);

                    $post->banner_image = $banner_image_name;
                }

                if ($post->update()) {
                    $notification = [
                        'status' => 'success',
                        'message' => 'Post updated'
                    ];

                    return redirect()->route('my_posts')->with($notification);
                } else {
                    $notification = [
                        'status' => 'error',
                        'message' => 'Something went wrong'
                    ];

                    return redirect()->back()->with($notification);
                }
            } else {
                $notification - [
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ];

                return redirect()->route('my_posts')->with($notification);
            }
        } else {
            return redirect()->route('my_posts');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (isset($id)) {
            $post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->first();

            if ($post) {
                if ($post->delete()) {
                    if (file_exists(public_path('storage/banner_images/' . $id . '/' . $post->banner_image))) {
                        unlink(public_path('storage/banner_images/' . $id . '/' . $post->banner_image));
                    }

                    $notification = [
                        'status' => 'success',
                        'message' => 'Post deleted'
                    ];
                } else {
                    $notification = [
                        'status' => 'error',
                        'message' => 'Something went wrong'
                    ];
                }                
            } else {
                $notification = [
                    'status' => 'error',
                    'message' => 'Post does not exists'
                ];
            }
        }

        return redirect()->route('my_posts')->with($notification);
    }

    public function my_posts(Request $request)
    {
        $posts = Post::where('user_id', Auth::user()->id);

        if (is_numeric($request->query('category')) && in_array($request->query('category'), [1, 2, 3, 4])) {
            $posts = $posts->where('category_id', $request->query('category'));
        }

        $posts = $posts->orderBy('id', 'desc')->paginate(3);

        $categories = Category::all();

        return view('posts.list', compact('posts', 'categories'));
    }
}
