@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        Edit Tag
                    </div>
                    <div class="card-body">

                        <form action="{{ route('tag.update',$tag->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="row align-items-end">
                                <div class="col-6 col-lg-3">
                                    <label class="form-label">Tag Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title',$tag->title) }}" name="title">
                                </div>
                                <div class="col-6 col-lg-3">
                                    <button class="btn btn-primary">Update Tag</button>
                                </div>
                            </div>
                            @error('title')
                            <p class="text-danger small">{{ $message }}</p>
                            @enderror
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection