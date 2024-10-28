@extends('panel.layout.app')


@section('content')
    <div class="pagetitle">
        <h1 class="text-center">Add User Post</h1>
    </div>
    <section class="section ">
        {{-- <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center"> --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8  col-md-8 d-flex flex-column align-items-center justify-content-center">
                    @include('panel.layout._message')
                    <div class="card mb-3">
                        <div class="card-body py-5">
                            <form class="row g-3 needs-validation" novalidate action="{{ route('post') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                {{-- <input type="hidden" value="{{ Auth::user()->id }}" name="user_id"> --}}
                                <div class="col-12">
                                    <label for="yourName" class="form-label">Post Title</label>
                                    <input type="text" name="title" class="form-control" value="" id="yourName"
                                        required>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-12">
                                    <label for="yourEmail" class="form-label"> Post Desc</label>
                                    <textarea class="form-control" name="desc" id="" cols="10" rows="2" required></textarea>
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-12">
                                    <label for="yourPhone" class="form-label">Post Image</label>
                                    <input type="file" name="image" class="form-control" value="" id=""
                                        required>
                                    <span class="text-danger">
                                        @error('number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-12">
                                    <label for="yourPassword" class="form-label">Select Category</label>
                                    <select name="category_id" id="" class="form-control">
                                        <option value="">select</option>
                                        @foreach ($post as $category)
                                            <option value="{{ $category->c_id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>


                                </div>
                                <div class="row py-3">
                                    <button class=" col-3 btn btn-primary m-auto" type="submit">Add Post</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
