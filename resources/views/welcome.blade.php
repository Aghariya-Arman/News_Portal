<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <title>dashboard</title>
</head>
<style>
    h6 {
        color: rgb(255, 0, 0);
        font-weight: 800;
        font-size: 30px;
        font-family: Arial, Helvetica, sans-serif;
    }

    h3 {
        font-weight: bold;
    }
</style>
@extends('panel.layout._message')

<body>

    <div class="container-fluid">
        <div class="row py-1 bg-white shadow justify-content-around">
            <div class="col-lg-10 logo  ">
                <h6>24/7 NEWS</h6>
            </div>

            <div class="col-lg-2 d-flex float-end  ">
                <div class="btn">
                    <a href="{{ route('ulogin') }}" class="btn btn-primary  border-0 rounded">login</a>
                </div>
                <div class="btn">
                    <a href="{{ route('rpage') }}" class="btn btn-primary   border-0 rounded">Register</a>
                </div>
            </div>
        </div>
        <div class="row mt-4">

            <div class="col-md-8">
                {{-- fetch date wise --}}
                <form id="datewise" action="{{ route('homepage') }}" method="GET">
                    <div class="date col-md-12 d-flex">
                        <input type="date" class="form-control me-2" name="sdate">
                        <input type="date" class="form-control" name="edate">

                        <select name="categories" id="" class="form-control">
                            <option value="">Select Categories</option>

                            @foreach ($category as $categorys)
                                <option value="{{ $categorys->id }}">{{ $categorys->category_name }}</option>
                            @endforeach
                        </select>

                        <input type="text" class="form-control" id="rating" name="rating"
                            placeholder="Enter Rating (1 && 5)" onkeypress="limitInputLength(); restrictInput(event);">
                        <button type="submit" id="fetchdata" class="btn btn-success ms-2">Fetch</button>
                    </div>
                </form>
            </div>
            {{-- <div class="col-md-3">
                <form action="{{ route('homepage') }}" method="GET">
                    <div class="cate d-flex">
                        <select name="categories[]" id="" class="form-control" required>
                            <option value="">Select Categories</option>

                            @foreach ($category as $categorys)
                                <option value="{{ $categorys->id }}">{{ $categorys->category_name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" id="fetchdata" class="btn btn-success ms-2">Select</button>
                    </div>

                </form>
            </div> --}}
            {{-- <div class="col-md-3">
                <form action="{{ route('homepage') }}" method="GET">
                    <div class="inp d-flex">
                        <input type="text" class="form-control" id="rating" name="rating"
                            placeholder="Enter Rating (1 && 5)" onkeypress="limitInputLength(); restrictInput(event);">
                        <button type="submit" id="fetchdata" class="btn btn-success ms-2">Submit</button>
                    </div>

                </form>
            </div> --}}



        </div>
        <div class="post-part mt-5">
            <div class="top row text-center  text-success">
                <div class="tetx-part text-center m-auto col-lg-3">
                    <h3>OUR POST</h3>
                    <hr style="height: 5px;color:green">
                </div>
            </div>

            <div class="row" id="allpost">

                @foreach ($post->take(7) as $posts)
                    <div class="card shadow ms-3 mb-3" style="width: 18rem;">
                        <div class="img" style="height: 200px">
                            <img src="{{ asset('storage/' . $posts->image) }}" class="card-img-top mt-3  "
                                alt="...">
                        </div>
                        <div class="card-body  " style="height: 200px">
                            <h5 class="card-title" style="height: 60px; overflow: hidden;">{{ $posts->title }}</h5>
                            {{-- <p class="card-text" style="height: 100px">{{ $posts->description }}</p> --}}
                            <a href="{{ route('readmore', $posts->id) }}" class="btn btn-primary h-25">Read more</a>

                            @php
                                $sum = $posts->review->sum('rate');
                                $count = $posts->review->count();
                                $reviews = 0;
                                if ($count) {
                                    $reviews = $sum / $count;
                                } else {
                                    $reviews = 0;
                                }
                                $fullstar = floor($reviews);
                                $halfstar = $reviews - $fullstar >= 0.5 ? 1 : 0;
                                $emptystar = 5 - ($fullstar + $halfstar);
                            @endphp

                            {{-- <p> {{ $reviews }}</p> --}}
                            <div class="star-rating">
                                @for ($i = 1; $i <= $fullstar; $i++)
                                    <i class="fa fa-star" style="color: gold;"></i>
                                @endfor
                                @if ($halfstar)
                                    <i class="fa fa-star-half-o" style="color: gold;"></i>
                                @endif
                                @for ($i = 1; $i <= $emptystar; $i++)
                                    <i class="fa fa-star-o" style="color: gold;"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($post->count() > 8)
                    <div class="card shadow ms-3 mb-3" id="c11" style="width: 18rem;">
                        <div class="text-center" style="margin-top: 150px">
                            <button id="view-all-btn" class="btn btn-white">View All</button>
                        </div>
                    </div>
                @endif
            </div>


        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#view-all-btn').on('click', function() {
            $.ajax({
                url: '{{ route('loadallpost') }}',
                method: 'GET',
                success: function(response) {
                    $('#allpost').append(response.html);
                    $('#c11').remove();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Failed to load posts.');
                }
            });
        });
    });
</script>
<script>
    function limitInputLength() {
        const number = document.getElementById('rating').value;
        const maxLength = 1;
        if (number.length >= maxLength) {
            event.preventDefault();
        }
    }

    function restrictInput(e) {
        var char = String.fromCharCode(e.which);
        if (!(/[0-5]/.test(char))) {
            e.preventDefault();
        }
    }
</script>

</html>
