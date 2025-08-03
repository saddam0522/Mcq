@extends('templates.basic.layouts.auth')

@section('content')
    <section class="account-section section--bg bg-overlay-white bg_img" data-background="{{ asset('images/bg.jpg') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-6 col-xxl-5">
                    <div class="account-form-area">
                        <div class="account-header text-center">
                            <h2 class="title">@lang('Employer Registration')</h2>
                        </div>

                        <form method="POST" action="{{ route('employer.register') }}" class="account-form">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <label for="email" class="form-label form--label">@lang('Email')</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="password" class="form-label form--label">@lang('Password')</label>
                                    <input type="password" name="password" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="password_confirmation" class="form-label form--label">@lang('Confirm Password')</label>
                                    <input type="password" name="password_confirmation" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="company_name" class="form-label form--label">@lang('Company Name')</label>
                                    <input type="text" name="company_name" value="{{ old('company_name') }}" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <label for="representative_name" class="form-label form--label">@lang('Representative Name')</label>
                                    <input type="text" name="representative_name" value="{{ old('representative_name') }}" class="form-control form--control" required>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="submit-btn w-100">@lang('Register')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
