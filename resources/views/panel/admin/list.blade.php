@extends('panel.layout.app')

@section('content')
    <div class="pagetitle">
        <h1>User List</h1>
    </div>
    {{-- <section class="section dashboard">

    </section> --}}

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
                                    <th scope="col">Name</th>
                                    <th scope="col">email</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->number }}</td>
                                        {{-- @if ($user->type === null) --}}
                                        <form action="{{ route('approve', $user->id) }}" method="POST">
                                            @csrf
                                            <td><button type="submit"
                                                    class="btn btn-{{ $user->type ? 'danger' : 'warning' }}" id="approve">
                                                    {{ $user->type ? 'disapprove' : 'approve' }}
                                                </button>
                                            </td>
                                        </form>
                                        <td><a class="btn btn-danger"
                                                href="{{ route('admindelete', $user->id) }}">Delete</a></td>
                                        {{-- @endif --}}

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
