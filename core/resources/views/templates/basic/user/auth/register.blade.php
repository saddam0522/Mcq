@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content', true);
    $elements = getContent('policy.element', false, '', true);
@endphp

@section('content')
    @if (gs('registration'))
        <section class="account-section section--bg bg-overlay-white bg_img pt-50 pb-30"
            data-background="{{ frontendImage('login', @$bg->data_values->background_image) }}">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                        <div class="account-form-area">
                            <div class="account-logo-area text-center">
                                <div class="account-logo">
                                    <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                                            alt="logo"></a>
                                </div>
                            </div>
                            <div class="account-header text-center">
                                <h2 class="title">@lang('Register Your Account Now')</h2>
                                <h3 class="sub-title"> @lang('Already Have An Account') ? <a
                                        href="{{ route('user.login') }}">@lang('Login Now')</a></h3>
                            </div>

                            @include($activeTemplate . 'partials.social_login')

                            <form action="{{ route('user.register') }}" method="POST"
                                class="verify-gcaptcha disableSubmission account-form">
                                @csrf
                                <div class="row gy-4">
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('First Name')</label>
                                        <input type="text" class="form-control form--control" name="firstname"
                                            value="{{ old('firstname') }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('Last Name')</label>
                                        <input type="text" class="form-control form--control" name="lastname"
                                            value="{{ old('lastname') }}" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label form--label">@lang('E-Mail Address')</label>
                                        <input type="email" class="form-control form--control checkUser" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('Password')</label>
                                        <input type="password"
                                            class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                            name="password" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label form--label">@lang('Confirm Password')</label>
                                        <input type="password" class="form-control form--control"
                                            name="password_confirmation" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <x-captcha />
                                        @if (gs('agree'))
                                            @php
                                                $policyPages = getContent(
                                                    'policy_pages.element',
                                                    false,
                                                    orderById: true,
                                                );
                                            @endphp
                                            <div class="form-check form--check">
                                                <input class="form-check-input" type="checkbox" id="agree"
                                                    @checked(old('agree')) name="agree" required>
                                                <label class="form-check-label" for="agree">
                                                    @lang('I agree with')

                                                    @foreach ($policyPages as $policy)
                                                        <a class="text--base"
                                                            href="{{ route('policy.pages', $policy->slug) }}"
                                                            target="_blank">
                                                            {{ __(@$policy->data_values->title) }}
                                                        </a>
                                                        @if (!$loop->last)
                                                            <span class="text--base">, </span>
                                                        @endif
                                                    @endforeach
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" id="recaptcha" class="submit-btn w-100">
                                            @lang('Register')</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        @include($activeTemplate . 'partials.registration_disabled')



    @endif


    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('style')
    <style>
        .social-login-btn {
            border: 1px solid #cbc4c4;
        }

        .register-disable {
            height: 100vh;
            width: 100%;
            background-color: #fff;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-disable-image {
            max-width: 300px;
            width: 100%;
            margin: 0 auto 32px;
        }

        .register-disable-title {
            color: rgb(0 0 0 / 80%);
            font-size: 42px;
            margin-bottom: 18px;
            text-align: center
        }

        .register-disable-icon {
            font-size: 16px;
            background: rgb(255, 15, 15, .07);
            color: rgb(255, 15, 15, .8);
            border-radius: 3px;
            padding: 6px;
            margin-right: 4px;
        }

        .register-disable-desc {
            color: rgb(0 0 0 / 50%);
            font-size: 18px;
            max-width: 565px;
            width: 100%;
            margin: 0 auto 32px;
            text-align: center;
        }

        .register-disable-footer-link {
            color: #fff;
            background-color: #5B28FF;
            padding: 13px 24px;
            border-radius: 6px;
            text-decoration: none
        }

        .register-disable-footer-link:hover {
            background-color: #440ef4;
            color: #fff;
        }


        .country-code .input-group-prepend .input-group-text {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .country-code select {
            border: none;
            background-color: transparent;
            color: #fff;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }
    </style>
@endpush




@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {

            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
