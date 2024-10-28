@extends('panel.layout.app')


@section('content')
    <!-- Modal -->
    <div class="modal fade" id="editmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editmodalLabel">Update Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update') }}" method="POST">
                        @csrf
                        <input type="hidden" id="detail_id" name="detail_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Number</label>
                            <input type="text" class="form-control" id="number" name="number"
                                onkeypress="limitInputLength(); restrictInput(event);" required>
                        </div>
                        <div class="modal-footer">
                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="pagetitle">
        <h1>User Datails</h1>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">email</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $detail->id }}</td>
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->email }}</td>
                                    <td>{{ $detail->number }}</td>
                                    <td><button class="btn editbtn btn-warning" value="{{ $detail->id }}">Update</button>
                                        <a href="{{ route('remove_user', $detail->id) }}" class="btn btn-danger">Remove</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.editbtn', function() {
            var id = $(this).val();
            $('#editmodal').modal('show');

            $.ajax({
                type: "GET",
                url: "/edit-details/" + id,
                success: function(response) {
                    $('#name').val(response.data.name);
                    $('#email').val(response.data.email);
                    $('#number').val(response.data.number);
                    $('#detail_id').val(response.data.id);


                }
            });
        });
    });

    //validation code
    function limitInputLength() {
        const number = document.getElementById('number').value;
        const maxLength = 10;
        if (number.length >= maxLength) {
            event.preventDefault();
        }
    }

    function restrictInput(event) {
        const data = document.getElementById('number').value;
        if (!/^\d*$/.test(data + event.key)) {
            event.preventDefault();
        }
    }
</script>
