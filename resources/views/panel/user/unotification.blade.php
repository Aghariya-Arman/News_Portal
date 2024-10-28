@extends('panel.layout.app')

@section('content')
    <div class="pagetitle">
        <h1>Notification</h1>
    </div>


    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>

                        <!-- Default Table -->
                        <table class="table">
                            @include('panel.layout._message')
                            <thead>

                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Notification</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chats as $chat)
                                    <tr>
                                        <td>{{ $chat->id }}</td>
                                        <td>{{ $chat->message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
