<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/header.css')}}">
    <script src="{{asset('js/header.js')}}"></script>
</head>
<body>

<!-- Navigation Block -->
<div class="bloc l-bloc" id="nav-bloc">
    <div class="container">
        <nav class="navbar row">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Company</a>
                <button id="nav-toggle" type="button" class="ui-navbar-toggle navbar-toggle" data-toggle="collapse" data-target=".navbar-1">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
            </div>
            <div>@if($user =\Illuminate\Support\Facades\Auth::User()){{$user->name}} @endif</div>
            <div class="collapse navbar-collapse navbar-1">
                <ul class="site-navigation nav">
                    <li>
                        <a href="" class="  mb-4" data-toggle="modal" data-target="#modalLoginForm">ورود</a>
                    </li>
                    <li>
                        <a href="#">team</a>
                    </li>
                    <li>
                        <a href="{{route('loginPage')}}">logout</a>
                    </li>
                    <li>
                        <a href="{{route('users.create')}}">ثبت نام</a>
                    </li>
                    <li>
                        <a href="" class="  mb-4" data-toggle="modal" data-target="#modalLoginForm">ورود</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- Navigation Block END -->


<!-- Carousel -->
<div class="container">
    <div class="row">
        <!-- Carousel -->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img  src="{{asset('css/header.png')}}" alt="First slide">
                    <!-- Static Header -->
                    <div class="header-text hidden-xs">
                        <div class="col-md-12 text-center">
                            <h2>
                                <span>OUR VISION</span>
                            </h2>
                            <br>
                            <div class="">
                                <a class="btn btn-theme btn-sm btn-min-block" href="#">Read More</a></div>
                        </div>
                    </div><!-- /header-text -->
                </div>
                <div class="item">
                    <img src="https://unsplash.s3.amazonaws.com/batch%209/barcelona-boardwalk.jpg" alt="Second slide">
                    <!-- Static Header -->
                    <div class="header-text hidden-xs">
                        <div class="col-md-12 text-center">
                            <h2>
                                <span>OUR VISION</span>
                            </h2>
                            <br>
                            <div class="">
                                <a class="btn btn-theme btn-sm btn-min-block" href="#">Read More</a></div>
                        </div>
                    </div><!-- /header-text -->
                </div>
                <div class="item">
                    <img src="https://unsplash.s3.amazonaws.com/batch%209/barcelona-boardwalk.jpg" alt="Third slide">
                    <!-- Static Header -->
                    <div class="header-text hidden-xs">
                        <div class="col-md-12 text-center">
                            <h2>
                                <span>OUR VISION</span>
                            </h2>
                            <br>
                            <div class="">
                                <a class="btn btn-theme btn-sm btn-min-block" href="#">Read More</a></div>
                        </div>
                    </div><!-- /header-text -->
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div><!-- Carousel END -->
    </div>
</div>

<!-- Posts -->

<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="post news">
                <div class="post-img-content">
                    <img src="http://placehold.it/460x250/e67e22/ffffff&text=Lorem" class="img-responsive" />
                    <span class="post-date">Lorem Ipsum</span>
                </div>
                <br>
                <div class="content">
                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-md-5">
            <div class="post work">
                <div class="post-img-content">
                    <img src="http://placehold.it/460x250/2980b9/ffffff&text=Lorem" class="img-responsive" />
                    <span class="post-date">Lorem Ipsum</span>
                </div>
                <br>
                <div class="content">
                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-md-3">
            <div class="post feed">
                <div class="post-img-content">
                    <img src="http://placehold.it/460x250/47A447/ffffff&text=Lorem" class="img-responsive" />
                    <span class="post-date">Lorem Ipsum</span>
                </div>
                <br>
                <div class="content">
                    <div>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
