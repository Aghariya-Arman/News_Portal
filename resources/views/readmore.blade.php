<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Read More</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
        }

        .rating>input {
            display: none;
            /* Hide radio buttons */
        }

        .rating>label {
            font-size: 50px;
            color: black;
            /* Default star color */
            cursor: pointer;
        }

        /* Highlight the stars that are checked */
        .rating>input:checked~label {
            color: gold;
        }

        /* If hovered, show only hover effect without changing the selected value */
        .rating>label:hover,
        .rating>label:hover~label {
            color: #ffdd00;
        }

        .star li {
            list-style: none;
        }
    </style>
</head>

<body>
    @extends('panel.layout._message')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card mb-3">
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->description }}</p>
                        @php
                            $fivestar = 0;
                            $fourstar = 0;
                            $threestar = 0;
                            $twostar = 0;
                            $onestar = 0;

                            //overall review
                            $sum = $post->review->sum('rate');
                            $count = $post->review->count();
                            $avg = $count > 0 ? $sum / $count : 0;
                        @endphp
                        @foreach ($post->review as $posts)
                            @php
                                if ($posts->rate == 5) {
                                    $fivestar++;
                                } elseif ($posts->rate == 4) {
                                    $fourstar++;
                                } elseif ($posts->rate == 3) {
                                    $threestar++;
                                } elseif ($posts->rate == 2) {
                                    $twostar++;
                                } elseif ($posts->rate == 1) {
                                    $onestar++;
                                }
                            @endphp
                        @endforeach
                        @php

                            $totalreviews = $fivestar + $fourstar + $threestar + $twostar + $onestar;
                            // dd($totalreviews);
                            $fivepercent = 0;
                            $fourpercent = 0;
                            $threepercent = 0;
                            $twopercent = 0;
                            $onepercent = 0;

                            if ($totalreviews > 0) {
                                if ($fivestar > 0) {
                                    $fivepercent = ($fivestar / $totalreviews) * 100;
                                }
                                if ($fourstar > 0) {
                                    $fourpercent = ($fourstar / $totalreviews) * 100;
                                }
                                if ($threestar > 0) {
                                    $threepercent = ($threestar / $totalreviews) * 100;
                                }
                                if ($twostar > 0) {
                                    $twopercent = ($twostar / $totalreviews) * 100;
                                }
                                if ($onestar > 0) {
                                    $onepercent = ($onestar / $totalreviews) * 100;
                                }
                            } else {
                                $fivepercent = $fourpercent = $threepercent = $twopercent = $onepercent = 0;
                            }
                        @endphp

                        <h3> {{ number_format($avg, 1) }}/5.0</h3>
                        <div class="star">
                            <li>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= 5 ? 'fa-star' : 'fa-star-o' }}" style="color: gold;"></i>
                                @endfor:
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 7px; width:150px">
                                    <div class="progress-bar bg-success" style="width:{{ $fivepercent }}%">
                                    </div>
                                </div>
                                ({{ $fivestar }} reviws,{{ number_format($fivepercent, 1) }}%)
                            </li>
                            <li>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= 4 ? 'fa-star' : 'fa-star-o' }}" style="color: gold;"></i>
                                @endfor:
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 7px; width:150px">
                                    <div class="progress-bar bg-success" style="width: {{ $fourpercent }}%">
                                    </div>
                                </div>
                                ({{ $fourstar }}reviws,{{ number_format($fourpercent, 1) }}%)
                            </li>
                            <li>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= 3 ? 'fa-star' : 'fa-star-o' }}" style="color: gold;"></i>
                                @endfor:
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 7px; width:150px">
                                    <div class="progress-bar bg-success" style="width: {{ $threepercent }}%">
                                    </div>
                                </div>
                                ({{ $threestar }}reviws,{{ number_format($threepercent, 1) }}%)
                            </li>
                            <li>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= 2 ? 'fa-star' : 'fa-star-o' }}" style="color: gold;"></i>
                                @endfor:
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 7px; width:150px">
                                    <div class="progress-bar bg-success" style="width: {{ $twopercent }}%">
                                    </div>
                                </div>
                                ({{ $twostar }}reviws,{{ number_format($twopercent, 1) }}%)
                            </li>
                            <li>
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa {{ $i <= 1 ? 'fa-star' : 'fa-star-o' }}" style="color: gold;"></i>
                                @endfor:
                                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100" style="height: 7px; width:150px">
                                    <div class="progress-bar bg-success" style="width: {{ $onepercent }}%">
                                    </div>
                                </div>
                                ({{ $onestar }}reviws,{{ number_format($onepercent, 1) }}%)
                            </li>
                        </div>

                        <p class="card-text"><small class="text-body-secondary">Last updated
                                {{ $post->updated_at }}</small></p>
                    </div>
                    <div class="btn">
                        <a href="{{ route('homepage') }}" class="btn btn-primary">Back To..</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="mb-5 text-center">All Reviews Here..</h4>
                @foreach ($post->review as $posts)
                    <h6>{{ $posts->name }}</h6>
                    <p>{{ $posts->review_text }}</p>
                    @php
                        $maxstar = 5;
                        $userrate = $posts->rate;
                        $blankstar = $maxstar - $userrate;
                    @endphp

                    <div class="star-rating">
                        @for ($i = 1; $i <= $userrate; $i++)
                            <i class="fa fa-star" style="color: gold;"></i>
                        @endfor
                        @for ($i = 1; $i <= $blankstar; $i++)
                            <i class="fa fa-star-o" style="color: gold;"></i>
                        @endfor
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="col-md-8 mt-2">

                <form id="myform" style="line-height: 20px">
                    @csrf
                    <p class="text-center"><b>Give Some Spesific Review...</b></p>
                    <input type="hidden" value="{{ $post->id }}" name="post_id" id="post_id">
                    <div class="rating mb-5">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5"
                            onclick="setRating(5)">☆</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"
                            onclick="setRating(4)">☆</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"
                            onclick="setRating(3)">☆</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"
                            onclick="setRating(2)">☆</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"
                            onclick="setRating(1)">☆</label>
                    </div>
                    <div class="col-4 text-center m-auto">
                        <input type="text" name="name" class="form-control" placeholder="Enter UserName">
                    </div>
                    <div class="col-5 mt-1 p-4 text-center m-auto">
                        <textarea name="review" id="" cols="10" rows="2" class="form-control"
                            placeholder="Enter Review"></textarea>
                        <button class="btn btn-primary mt-2">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
<script>
    function setRating(rating) {
        const stars = document.querySelectorAll('.rating input');
        stars.forEach((star) => {
            star.checked = false;
        });
        document.getElementById('star' + rating).checked = true;
    }
</script>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#myform').submit(function(event) {
            event.preventDefault();

            var form = $('#myform')[0];
            var data = new FormData(form);

            $.ajax({
                type: "POST",
                url: "{{ route('review') }}",
                data: data,
                contentType: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    // alert('Review has been submitted successfully!');
                    window.location.reload();

                },
                error: function(e) {
                    console.error("Error:", e.responseText);
                }
            });
        });
    });
</script>


</html>
