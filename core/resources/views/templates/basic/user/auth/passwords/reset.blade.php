@extends($activeTemplate . 'layouts.auth')
@section('content')
  @php
    $bg = getContent('login.content', true);
  @endphp

  <section class="account-section section--bg bg-overlay-white bg_img"
    data-background="{{ frontendImage('login', @$bg->data_values->background_image) }}">
    <div class="container">
      <div class="row account-area align-items-center justify-content-center">
        <div class="col-lg-5">
          <div class="account-form-area">
            <div class="account-logo-area text-center">
              <div class="account-logo">
                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                    alt="logo"></a>
              </div>
            </div>
            <div class="account-header text-center">
              <h2 class="title">@lang('Reset Password')</h2>
            </div>

            <form class="account-form" method="POST" action="{{ route('user.password.update') }}">
              @csrf
              <input type="hidden" name="email" value="{{ $email }}">
              <input type="hidden" name="token" value="{{ $token }}">

              <div class="row ml-b-20">
              </div>
              <div class="col-lg-12 form-group">
                <label>@lang('Password')</label>
                <input type="password"
                  class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                  name="password" required>
              </div>
              <div class="col-lg-12 form-group">
                <label>@lang('Confirm Password')</label>
                <input type="password" class="form-control form--control" name="password_confirmation" required>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn--base w-100"> @lang('Submit')</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


@if (gs('secure_password'))
  @push('script-lib')
    <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
  @endpush
@endif

@push('style')
  <style>
    .form-group label {
      color: white;
    }

    .account-form-area {
      overflow: visible;
    }
  </style>
@endpush
