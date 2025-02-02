<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP verification UI using bootstrap</title>

    <!-- bootstrap 5 stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css"
        integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- fontawesome 6 stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        body {
            background-color: #ebecf0;
        }

        .otp-letter-input {
            max-width: 100%;
            height: 90px;
            border: 1px solid #198754;
            border-radius: 10px;
            color: #198754;
            font-size: 60px;
            text-align: center;
            font-weight: bold;
        }

        .btn {
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="container p-5">
        <div class="row">
            <div class="col-md-3"></div>

            <div class="col-md-5 mt-5">
                <div class="bg-white p-5 rounded-3 shadow-sm border">
                    <form action="{{ route('otpverify') }}" method="POST">
                        @csrf
                        <div>
                            <p class="text-center text-success" style="font-size: 5.5rem;"><i
                                    class="fa-solid fa-envelope-circle-check"></i></p>
                            @include('panel.layout._message')
                            <p class="text-center text-center h5 ">Please check your email</p>
                            <p class="text-muted text-center">We've sent a code to {{ session('email') }}</p>
                            <div class="row pt-4 pb-2 justify-content-center">
                                <div class="col-7">
                                    <input class="form-control" type="text" id="varification" name="otp"
                                        placeholder="ENTER 4 DIGIT OTP"
                                        onkeypress="limitInputLength();restrictInput(event);" required>
                                    <span class="text-danger">
                                        @error('otp')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <p class="text-muted text-center">Didn't get the code? <a href="{{ route('resendotp') }}"
                                    class="text-success">Click to resend.</a></p>

                            <div class="row pt-5">
                                <div class="col-6">
                                    <button class="btn btn-outline-secondary w-100">Cancel</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-success w-100">Verify</button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // document.getElementById('otpvalid').style.display = 'none';

    // function showotp() {
    //     document.getElementById("otpvalid").style.display = "block";
    // }

    function limitInputLength() {
        const number = document.getElementById('varification').value;
        const maxLength = 4;
        if (number.length >= maxLength) {
            event.preventDefault();
        }
    }

    function restrictInput(event) {
        const data = document.getElementById('varification').value;
        if (!/^\d*$/.test(data + event.key)) {
            event.preventDefault();
        }
    }
</script>

</html>
