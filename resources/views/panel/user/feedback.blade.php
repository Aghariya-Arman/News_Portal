@extends('panel.layout.app')

@section('content')
    <div class="pagetitle">
        <h1 class="text-center">Share Feedback</h1>
    </div>
    <section class="section ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8  col-md-8 d-flex flex-column align-items-center justify-content-center">
                    @include('panel.layout._message')
                    <div class="card mb-3">
                        <div class="card-body py-5">
                            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('feedback') }}">
                                @csrf
                                <div class="col-12">
                                    <input type="text" value="{{ $admin_email }}" readonly class="form-control">
                                </div>

                                <div class="col-12">
                                    <label for="yourName" class="form-label">Give Feedback</label>
                                    <textarea name="feedback" id="" cols="10" rows="2" class="form-control" required></textarea>
                                    <span class="text-danger">
                                        @error('feedback')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="row py-3">
                                    <button class="col-3 btn btn-primary m-auto" type="submit">Submit</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
