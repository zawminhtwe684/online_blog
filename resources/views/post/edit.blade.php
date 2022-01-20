@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <div class="card">

                    <div class="card-header">
                        Edit Post
                    </div>
                    <div class="card-body">

                        <form action="{{ route('post.update',$post->id) }}" method="post" id="updateForm">
                            @csrf
                            @method('put')
                        </form>

                        <div class="mb-3">
                            <label class="form-label">Post Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" form="updateForm"
                                   value="{{ old('title',$post->title) }}" name="title">
                            @error('title')
                            <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Select Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" name="category" form="updateForm">
                                @foreach(\App\Models\Category::all() as $category)
                                    <option
                                        value="{{ $category->id }}" {{ $category->id == old('category',$post->category_id) ? 'selected' : '' }}>{{ $category->title }}</option>
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
{{--                                    {{in_array($tag->id,$post->tags->pluck("id")->toArray())?"checked":""}}--}}
                                    <input form="updateForm" class="form-check-input" type="checkbox" value="{{$tag->id}}" name="tags[]" id="{{$tag->id}}"  {{in_array($tag->id,old('tags',$post->tags->pluck("id")->toArray()))? 'checked':''}}>
                                </div>
                            @endforeach
                            @error('tags')
                            <p class="text-danger small">{{ $message }}</p>
                            @enderror
                            @error('tags.*')
                            <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="">
                            <label for="" class="form-label">Photo</label>
                            <div class="border rounded px-2 d-flex overflow-scroll mb-3">
                                <form action="{{route('photo.store')}}" method="post" enctype="multipart/form-data"
                                      class="d-none" id="photoUploadForm">
                                    @csrf
                                    {{--//ဘယ်သူ့အတွက်လည်းဆိုတာ လိုအပ်ပါသည် မြင်စရာမလို--}}
                                    <input type="hidden" name="post_id" value="{{$post->id}}">
                                    <div class="mb-3">
                                        <label class="form-label">Photo</label>
                                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                               id="photoInput" value="{{ old('photo') }}" name="photos[]" multiple>
                                        @error('photo')
                                        <p class="text-danger small">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary">Upload</button>
                                </form>


                                <div
                                    class="border border-2 uploader-ui d-flex justify-content-center align-items-center rounded border-dark w-25"
                                    id="photoUploadUi">
                                    <i class="fas fa-plus-circle fa-2x"></i>
                                </div>

                                @forelse($post->photos as $photo)
                                    <div class="position-relative">
                                        <form action="{{route("photo.destroy",$photo->id)}}" method="post"
                                              class="position-absolute bottom-0 start-0">
                                            @csrf
                                            @method("delete")
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        <a class="venobox" data-gall="{{$post->id}}" href="{{asset("storage/photo/".$photo->name)}}">
                                            <img src="{{asset("storage/thumbnail/".$photo->name)}}" alt="image" height="100" class="rounded border-dark me-1"/>
                                        </a>
                                    </div>
                                @empty
                                    <p class="text-muted">No Photo</p>
                                @endforelse
                            </div>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea type="text" rows="10" form="updateForm"
                                      class="form-control @error('description') is-invalid @enderror"
                                      name="description">{{ old('description',$post->description) }}</textarea>
                            @error('description')
                            <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" form="updateForm"
                                       id="flexSwitchCheckDefault" required>
                                <label class="form-check-label" for="flexSwitchCheckDefault" >Confirm</label>
                            </div>
                            <button class="btn btn-lg btn-primary" form="updateForm">Update Post</button>
                        </div>
                        <hr>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script>
        let photoUploadForm = document.getElementById('photoUploadForm');//သူ့ကို submit လုပ်မှာပါ 3
        let photoInput = document.getElementById('photoInput');//သူ့ကိုနှိုးမှာ 2
        let photoUploadUi = document.getElementById('photoUploadUi');//သူ့ကိုနှိပ်လိုက်ရင် 1

        photoUploadUi.addEventListener('click', function () {
            photoInput.click();
        })
        photoInput.addEventListener('change', function () {
            photoUploadForm.submit();
        })

    </script>


@endsection
