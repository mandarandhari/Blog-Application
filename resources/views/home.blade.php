@extends('layouts.app')

@section('content')
<header class="masthead" style="background-image: url('/img/bg-index.jpg')">  
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
            @if(!empty($posts))
            @foreach($posts as $post)
            <div class="post-preview">
                <a href="{{ route('view_post', [$post->id, $post->url]) }}">
                    <span class="category-box" style="background:{{ $post->category->color_code }};">{{ $post->category->category_name }}</span>
                    <h2 class="post-title">{{ $post->title }}</h2>
                    <h3 class="post-subtitle">{{ $post->description }}</h3>
                </a>
                <p class="post-meta">Posted by <a href="#">{{ $post->user->name }}</a> on {{ date('F d, Y', strtotime($post->created_at)) }}</p>
            </div>
            <hr>
            @endforeach
            @endif
            <!-- Pager -->
            <div class="clearfix">
                <a class="btn btn-primary float-right" href="{{ route('posts') }}">View All Posts &rarr;</a>
            </div>
        </div>
    </div>
</div>
                    
@endsection
