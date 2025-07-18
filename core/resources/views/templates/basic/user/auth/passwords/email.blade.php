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


                        <form method="POST" action="{{ route('user.password.email') }}" class="account-form verify-gcaptcha">
                            @csrf
                            <div class="row ml-b-20">

                            </div>

                            <div class="col-lg-12 form-group">
                                <label class="form-label form--label">@lang('Email or Username')</label>
                                <input type="text" class="form-control form--control" name="value" value="{{ old('value') }}" required autofocus="off">
                            </div>

                            <x-captcha />

                            <div class="col-lg-12 form-group">
                                <button type="submit" class="submit-btn">@lang('Submit')</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
