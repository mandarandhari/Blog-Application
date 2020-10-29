@extends('layouts.app')

@section('content')
<header class="masthead" style="background-image: url('/img/bg-post.jpg')">  
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1>MyBlogs</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="row mb-5">
                <div class="col-md-6">
                    <form action="" method="get" id="category-filter-form">
                        <select name="category" id="category-filter" class="form-control">
                            <option value="">Filter by category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ Request::query('category') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </form>                
                </div>
                <div class="col-md-6">
                    @if(Request::segment(1) === 'my-posts')
                    <a href="{{ route('create_post') }}" class="btn btn-md btn-primary float-right">Add New Post</a>
                    @endif
                </div>
            </div>
            <hr>
        </div>
    </div>    
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            @forelse($posts as $post)
            <div class="post-preview">
                <a href="{{ route('view_post', [$post->id, $post->url]) }}">
                    <span class="category-box" style="background:{{ $post->category->color_code }};">{{ $post->category->category_name }}</span>
                    <h2 class="post-title">{{ $post->title }}</h2>
                    <h3 class="post-subtitle">{{ $post->description }}</h3>
                </a>
                <div class="row">
                    <div class="col-md-8">
                        <p class="post-meta">Posted by {{ Auth::check() && $post->user_id === Auth::user()->id ? 'you' : $post->user->name }} on {{ date('F d, Y', strtotime($post->created_at)) }}</p>
                    </div>
                    <div class="col-md-4 pt-3">
                        @if(Auth::check() && $post->user_id === Auth::user()->id && Request::segment(1) === 'my-posts')
                        <a href="{{ route('edit_post', [$post->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger delete-post-btn" data-href="{{ route('delete_post', [$post->id]) }}" data-target="#deletePostModal" data-toggle="modal">Delete</button>
                        @endif
                    </div>
                </div>                
            </div>
            <hr>
            @empty
            <p class="text-center">Posts not found</p>
            @endforelse
            <!-- Pager -->
            <div class="float-right">
                @if(Request::query('category') !== '')
                {{ $posts->appends(['category' => Request::query('category')])->links() }}
                @else
                {{ $posts->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deletePostModal" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePostModalLabel">Delete Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 17px;">
                Do you want to delete this post?
            </div>
            <div class="modal-footer">
                <form action="" id="delete-post-form" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger delete-comment-btn">Yes</button>
                </form>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>                   
@endsection
