@extends('master.master')

@section('cssLinks')
    <link rel="stylesheet" href="{{asset('css/registerFormCss.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

@endsection

@section('content')
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">فرم ثبت نام</h3>
                            <form action="{{route('users.store')}}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label" for="Name">نام</label>
                                        <div class="form-outline">
                                            <input type="text" id="Name" name="name"
                                                   class="form-control form-control-lg"/>
                                        </div>


                                    </div>

                                    <div class="col-md-6 mb-4">

                                        <h5 class="mb-2 pb-1">جنسیت: </h5>

                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="gender"
                                                id="femaleGender"
                                                value="f"
                                                checked
                                            />
                                            <label class="form-check-label" for="femaleGender">زن</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="gender"
                                                id="maleGender"
                                                value="m"
                                            />
                                            <label class="form-check-label" for="maleGender">مرد</label>
                                        </div>

                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <label class="form-label" for="emailAddress">ایمیل</label>
                                            <input type="email" id="emailAddress" name="email"
                                                   class="form-control form-control-lg"/>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="password">پسورد</label>
                                            <input type="password" id="password" name="password"
                                                   class="form-control form-control-lg"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label class="form-label" for="password">تایید پسورد</label>
                                            <input type="password" id="password" name="password_confirmation"
                                                   class="form-control form-control-lg"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="validation-error col-md-6 mb-4 pb-2">
                                        @if($errors->any())
                                            <div>
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{$error}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-4 pt-2 ">
                                        <input class="btn btn-primary btn-lg" name="submit" type="submit" value="ورود"/>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jsLinks')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
@endsection
