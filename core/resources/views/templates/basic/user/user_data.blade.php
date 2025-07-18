@extends('templates.basic.layouts.auth')

@php
    $bg = getContent('login.content', true);
@endphp

@section('content')
    <section class="account-section section--bg bg-overlay-white bg_img pt-50 pb-30" data-background="{{ frontendImage('login', @$bg->data_values->background_image) }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-7 col-xl-6">
                    <div class="account-form-area">
                        <div class="account-header text-center">
                            <h2 class="title">{{ __($pageTitle) }}</h2>
                        </div>

                        <form method="POST" action="{{ route('user.data.submit') }}" class="account-form">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-12">
                                    <label class="form-label form--label">@lang('Username')</label>
                                    <input type="text" class="form-control form--control checkUser" name="username" value="{{ old('username') }}">
                                    <small class="text--danger usernameExist"></small>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label form--label">@lang('Country')</label>
                                    <select name="country" class="form-control form--control select2" required>
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">{{ __($country->country) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label form--label">@lang('Mobile')</label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="hidden" name="mobile_code">
                                        <input type="hidden" name="country_code">
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" class="form-control form--control checkUser" required>
                                    </div>
                                    <small class="text--danger mobileExist"></small>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label form--label">@lang('Address')</label>
                                    <input type="text" class="form-control form--control" name="address" value="{{ old('address') }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label form--label">@lang('State')</label>
                                    <input type="text" class="form-control form--control" name="state" value="{{ old('state') }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label form--label">@lang('Zip Code')</label>
                                    <input type="text" class="form-control form--control" name="zip" value="{{ old('zip') }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label form--label">@lang('City')</label>
                                    <input type="text" class="form-control form--control" name="city" value="{{ old('city') }}">
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="submit-btn w-100">
                                        @lang('Submit')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection




@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush


@push('script')
    <script>
        "use strict";
        (function($) {

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('.select2').select2();

            $('select[name=country]').on('change', function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
                var value = $('[name=mobile]').val();
                var name = 'mobile';
                checkUser(value, name);
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));


            $('.checkUser').on('focusout', function(e) {
                var value = $(this).val();
                var name = $(this).attr('name')
                checkUser(value, name);
            });

            function checkUser(value, name) {
                var url = '{{ route('user.checkUser') }}';
                var token = '{{ csrf_token() }}';

                if (name == 'mobile') {
                    var mobile = `${value}`;
                    var data = {
                        mobile: mobile,
                        mobile_code: $('.mobile-code').text().substr(1),
                        _token: token
                    }
                }
                if (name == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.field} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            }
        })(jQuery);
    </script>
@endpush
