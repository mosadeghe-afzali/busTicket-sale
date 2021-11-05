@extends('master.master')

@section('cssLinks')
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{asset('css/reset.css')}}"> <!-- CSS reset -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}"> <!-- Resource style -->
    <link rel="stylesheet" href="{{asset('css/demo.css')}}"> <!-- Demo style -->
@endsection
@section('title', 'login/register')


@section('content')
    <header class="cd-main-header">
        <div class="cd-main-header__logo"><a href="#0"><img src="img/cd-logo.svg" alt="Logo"></a></div>

        <nav class="cd-main-nav js-main-nav">
            <ul class="cd-main-nav__list js-signin-modal-trigger">
                <!-- inser more links here -->
                <li><a class="cd-main-nav__item cd-main-nav__item--signin" href="#0" data-signin="login">ورود/ثبت نام</a></li>
            </ul>
        </nav>
    </header>

    <div class="cd-intro">
        <h1>Login/Signup Modal Window</h1>
        <div class="cd-nugget-info">
            <a href="http://codyhouse.co/gem/loginsignup-modal-window/">
				<span>
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve">
						<style type="text/css">
							.cd-nugget-info-arrow{fill:#383838;}
						</style>
						<polygon class="cd-nugget-info-arrow" points="15,7 4.4,7 8.4,3 7,1.6 0.6,8 0.6,8 0.6,8 7,14.4 8.4,13 4.4,9 15,9 "/>
					</svg>
				</span>
                Article &amp; Download
            </a>
        </div> <!-- cd-nugget-info -->
    </div>

    <div class="cd-signin-modal js-signin-modal"> <!-- this is the entire modal form, including the background -->
        <div class="cd-signin-modal__container"> <!-- this is the container wrapper -->
            <ul class="cd-signin-modal__switcher js-signin-modal-switcher js-signin-modal-trigger">
                <li><a href="#0" data-signin="login" data-type="login">ورود</a></li>
                <li><a href="#0" data-signin="signup" data-type="signup">عضویت </a></li>
            </ul>

            <div class="cd-signin-modal__block js-signin-modal-block" data-type="login"> <!-- log in form -->
                <form class="cd-signin-modal__form">
                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="signin-email">ایمیل</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signin-email" type="email" placeholder="ایمیل">
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signin-password">پسورد</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signin-password" type="text"  placeholder="پسورد">
                        <a href="#0" class="cd-signin-modal__hide-password js-hide-password">مخفی</a>
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <input type="checkbox" id="remember-me" checked class="cd-signin-modal__input ">
                        <label for="remember-me">مرا به خاطر بسپار</label>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width" type="submit" value="ورود">
                    </p>
                </form>

                <p class="cd-signin-modal__bottom-message js-signin-modal-trigger"><a href="#0" data-signin="reset">Forgot your password?</a></p>
            </div> <!-- cd-signin-modal__block -->

            <div class="cd-signin-modal__block js-signin-modal-block" data-type="signup"> <!-- sign up form -->
                <form class="cd-signin-modal__form">
                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--name cd-signin-modal__label--image-replace" for="signup-name">نام</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-name" type="text" placeholder="نام">
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="signup-email">ایمیل</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-email" type="email" placeholder="ایمیل">
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <label><b>جنسیت</b></label><br>
                    <label for="female">زن</label>
                    <input type="radio" name="gender" id="female" value="female" checked>
                    <label for="male">مرد</label>
                    <input type="radio" name="gender" id="male" value="male"><br><br>

                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signup-password">پسورد</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-password" type="text"  placeholder="پسورد">
                        <a href="#0" class="cd-signin-modal__hide-password js-hide-password">مخفی</a>
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--password cd-signin-modal__label--image-replace" for="signup-password">تایید پسورد</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="signup-password" type="text"  placeholder="تاییید پسورد">
                        <a href="#0" class="cd-signin-modal__hide-password js-hide-password">مخفی</a>
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <input type="checkbox" id="accept-terms" class="cd-signin-modal__input ">
                        <label for="accept-terms">با قوانین سایت موافقم <a href="#0">Terms</a></label>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding" type="submit" value="ثبت">
                    </p>
                </form>
            </div> <!-- cd-signin-modal__block -->

            <div class="cd-signin-modal__block js-signin-modal-block" data-type="reset"> <!-- reset password form -->
                <p class="cd-signin-modal__message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

                <form class="cd-signin-modal__form">
                    <p class="cd-signin-modal__fieldset">
                        <label class="cd-signin-modal__label cd-signin-modal__label--email cd-signin-modal__label--image-replace" for="reset-email">E-mail</label>
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding cd-signin-modal__input--has-border" id="reset-email" type="email" placeholder="E-mail">
                        <span class="cd-signin-modal__error">Error message here!</span>
                    </p>

                    <p class="cd-signin-modal__fieldset">
                        <input class="cd-signin-modal__input cd-signin-modal__input--full-width cd-signin-modal__input--has-padding" type="submit" value="Reset password">
                    </p>
                </form>

                <p class="cd-signin-modal__bottom-message js-signin-modal-trigger"><a href="#0" data-signin="login">Back to log-in</a></p>
            </div> <!-- cd-signin-modal__block -->
            <a href="#0" class="cd-signin-modal__close js-close">بستن</a>
        </div> <!-- cd-signin-modal__container -->
    </div> <!-- cd-signin-modal -->
@endsection

@section('jsLinks')
    <script src="{{asset('js/placeholders.min.js')}}"></script> <!-- polyfill for the HTML5 placeholder attribute -->
    <script src="{{asset('js/main.js')}}"></script> <!-- Resource JavaScript -->
@endsection
