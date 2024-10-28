@extends('panel.layout.app')

@section('content')
    <div class="pagetitle">
        <h1>Post List</h1>
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
                                    <th scope="col">Title</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($post as $posts)
                                    <tr>
                                        <td>{{ $posts->id }}</td>
                                        <td>{{ $posts->title }}</td>
                                        <td>{{ $posts->description }}</td>
                                        <td><img src="{{ asset('storage/' . $posts->image) }}" alt="img"
                                                style="width: 50px"></td>
                                        <form action="{{ route('adminpostapprove', $posts->id) }}" method="POST">
                                            @csrf
                                            <td><button type="submit"
                                                    class="btn btn-{{ $posts->status ? 'success' : 'warning' }}"
                                                    id="approve">
                                                    {{ $posts->status ? 'approve' : 'pending' }}
                                                </button>
                                            </td>
                                        </form>
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admindeletepost', $posts->id) }}">Delete</a></td>


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
