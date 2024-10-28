@extends('panel.layout.app')

@section('content')
    <div class="pagetitle">
        <h1 class="text-center">Env File</h1>
    </div>
    <section class="section ">
        {{-- <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center"> --}}
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8  col-md-8 d-flex flex-column align-items-center justify-content-center">
                    @include('panel.layout._message')
                    <div class="card mb-3">
                        <div class="card-body py-5">
                            <form class="row g-3 needs-validation" novalidate action="{{ route('updateenv') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_MAILER</label>
                                    <input type="text" name="MAIL_MAILER" class="form-control"
                                        value="{{ env('MAIL_MAILER') }}" id="MAIL_MAILER" required>
                                    <span class="text-danger">
                                        @error('MAIL_MAILER')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_HOST</label>
                                    <input type="text" name="MAIL_HOST" class="form-control"
                                        value="{{ env('MAIL_HOST') }}" id="MAIL_HOST" required>
                                    <span class="text-danger">
                                        @error('MAIL_HOST')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_PORT</label>
                                    <input type="text" name="MAIL_PORT" class="form-control"
                                        value="{{ env('MAIL_PORT') }}" id="MAIL_PORT" required>
                                    <span class="text-danger">
                                        @error('MAIL_PORT')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_USERNAME</label>
                                    <input type="text" name="MAIL_USERNAME" class="form-control"
                                        value="{{ env('MAIL_USERNAME') }}" id="MAIL_USERNAME" required>
                                    <span class="text-danger">
                                        @error('MAIL_USERNAME')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_PASSWORD</label>
                                    <input type="text" name="MAIL_PASSWORD" class="form-control"
                                        value="{{ env('MAIL_PASSWORD') }}" id="MAIL_PASSWORD" required>
                                    <span class="text-danger">
                                        @error('MAIL_PASSWORD')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_FROM_ADDRESS</label>
                                    <input type="text" name="MAIL_FROM_ADDRESS" class="form-control"
                                        value="{{ env('MAIL_FROM_ADDRESS') }}" id="MAIL_FROM_ADDRESS" required>
                                    <span class="text-danger">
                                        @error('MAIL_FROM_ADDRESS')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_FROM_NAME</label>
                                    <input type="text" name="MAIL_FROM_NAME" class="form-control"
                                        value="{{ env('MAIL_FROM_NAME') }}" id="MAIL_FROM_NAME" required>
                                    <span class="text-danger">
                                        @error('MAIL_FROM_NAME')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-6">
                                    <label for="yourName" class="form-label">MAIL_ENCRYPTION</label>
                                    <input type="text" name="MAIL_ENCRYPTION" class="form-control"
                                        value="{{ env('MAIL_ENCRYPTION') }}" id="MAIL_ENCRYPTION" required>
                                    <span class="text-danger">
                                        @error('MAIL_ENCRYPTION')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="row py-3">
                                    <button class=" col-3 btn btn-primary m-auto" type="submit">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
