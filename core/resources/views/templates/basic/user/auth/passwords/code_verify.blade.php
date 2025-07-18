@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content', true);
@endphp

@section('content')
    <section class="account-section section--bg bg-overlay-white bg_img" data-background="{{ frontendImage('login', @$bg->data_values->background_image) }}">
        <div class="container">
            <div class="row account-area align-items-center justify-content-center">
                <div class="col-lg-5">
                    <div class="account-form-area">
                        <div class="account-logo-area text-center">
                            <div class="account-logo">
                                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
                            </div>
                        </div>
                        <div class="account-header text-center">
                            <h2 class="title">@lang('Reset Password')</h2>
                        </div>

                        <form action="{{ route('user.password.verify.code') }}" method="POST" class="account-form submit-form">
                            @csrf
                            <div class="row ml-b-20">
                                <p class="verification-text text-white">@lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}</p>
                                <input type="hidden" name="email" value="{{ $email }}">
                                @include($activeTemplate . 'partials.verification_code')
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="submit-btn">@lang('Submit')</button>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <p class="text-white">
                                        @lang('Please check including your Junk/Spam Folder. if not found, you can')
                                        <a class="text--base" href="{{ route('user.password.request') }}">@lang('Try to send again')</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
