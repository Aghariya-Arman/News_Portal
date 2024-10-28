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
                    <form action="{{ route('updatepost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="post_id" name="post_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Description</label>
                            <textarea class="form-control" name="desc" id="desc" cols="10" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Post Image</label>
                            <img class="img-thumbnail w-25" src="" alt="" id="viewimage">
                            <input type="file" name="image" class="form-control" value="" id="image">
                        </div>
                        <div class="mb-3">
                            <label for="yourPassword" class="form-label">Select Category</label>
                            <select name="category_id" id="category" class="form-control">
                                <option value="">select</option>
                                @foreach ($role as $category)
                                    <option value="{{ $category->c_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>


                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="row d-flex">
        <div class="col">
            <h1>User Post</h1>
        </div>

        <div class="col">
            <a href="{{ route('addpost') }}" class=" col-md-4 btn btn-primary float-end ">Add new Post</a>
        </div>
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
                                    <th scope="col">title</th>
                                    <th scope="col">description</th>
                                    <th scope="col">image</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Status</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->description }}</td>
                                        <td><img class="container-fluid"
                                                src="{{ asset('storage/' . $post->image) }}"alt="img" style="width: 120px">
                                        </td>
                                        <td><button class="btn editbtn btn-warning"
                                                value="{{ $post->id }}">Update</button>
                                            <a href="{{ route('deletepost', $post->id) }}"class="btn btn-danger">Delete</a>
                                        </td>
                                        <td><button
                                                class="btn btn-{{ $post->status ? 'success' : 'warning' }}">{{ $post->status ? 'approve' : 'pending' }}</button>
                                        </td>
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

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.editbtn', function() {
            var id = $(this).val();

            $('#editmodal').modal('show');

            $.ajax({
                type: "GET",
                url: "/edit-post/" + id,
                success: function(response) {

                    $('#title').val(response.post.title);
                    $('#desc').val(response.post.description);
                    $('#viewimage').attr('src', '/storage/' + response.post.image);
                    $('#post_id').val(response.post.id);


                    //category update code
                    $('#category').find('option').removeAttr('selected');
                    // Find the option that matches the category_id and mark it as selected
                    $('#category option').each(function() {
                        if ($(this).val() == response.post.category_id) {
                            $(this).attr('selected', 'selected');
                        }
                    });
                }
            });
        });
    });
</script>
