@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <div class="card">

                    <div class="card-header">
                        Create Post
                    </div>
                    <div class="card-body">

                        <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Post Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title">
                                @error('title')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Select Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" name="category">
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == old('category') ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="form-lable" class="form-label">Select Tag</label>
                                <br>
                                @foreach(\App\Models\Tag::all() as $tag)
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="{{$tag->id}}">
                                        {{$tag->title}}
                                    </label>
                                    <input class="form-check-input" type="checkbox" value="{{$tag->id}}" name="tags[]" id="{{$tag->id}}" {{in_array($tag->id,old('tags',[]))? 'checked':''}} >
                                </div>
                                    @endforeach
                                @error('tags')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                                @error('tags.*')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control @error('photos') is-invalid @enderror" name="photos[]" multiple>
                                @error('photos')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                                @error('photos.*')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea type="text" rows="10" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="text-danger small">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" required>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Confirm</label>
                                </div>
                                <button class="btn btn-lg btn-primary">Create Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
