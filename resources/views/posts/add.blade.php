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
            <form action="{{ route('save_post') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls floating-label-form-group-with-focus floating-label-form-group-with-value">
                        <label>Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" placeholder="Title" />
                        @error('title')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br />
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls floating-label-form-group-with-focus floating-label-form-group-with-value">
                        <label>Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5" placeholder="Description">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br />
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls floating-label-form-group-with-focus floating-label-form-group-with-value">
                        <label>Category</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br />
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls floating-label-form-group-with-focus floating-label-form-group-with-value">
                        <label>Content</label>
                        <textarea name="content" id="content" class="form-control" rows="5">{{ old('content') }}</textarea>
                        <script type="application/javascript">
                            CKEDITOR.replace('content');
                        </script>
                        @error('content')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br />
                <div class="control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls floating-label-form-group-with-focus floating-label-form-group-with-value">
                        <label>Banner Image</label>
                        <input type="file" name="banner_image" id="banner_image" />
                        @error('banner_image')
                        <p class="help-block text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <br>  
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="addPostBtn">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection