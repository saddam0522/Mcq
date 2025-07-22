@extends('templates.basic.layouts.auth')

@php
  $bg = getContent('login.content', true);
@endphp

@section('content')
  <section class="auth-section d-flex align-items-center justify-content-center py-4 py-lg-0">
    <div class="container">
      <div class="row flex-column-reverse flex-lg-row align-items-center g-5">
        <div class="col-lg-6">
          <div class="auth-slides h-100">
            <div class="swiper auth-slide h-100">
              <div class="swiper-wrapper h-100">
                <div class="swiper-slide h-100">
                  <img src="../../assets/images/img/slide1.png" alt="Slide Image">
                  <div class="overlay">
                    <div class="overlay-top">
                      <h2 class="mb-0 text-center">Welcome to SimpleFlow</h2>
                      <p class="text-center">Your Gateway to Effortless Management.</p>
                    </div>
                    <div class="overlay-bottom">
                      <h2 class="mb-0 text-center">Seamless Collaboration </h2>
                      <p class="text-center">Effortlessly work together with your team in real-time.</p>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide h-100">
                  <img src="../../assets/images/img/slide1.png" alt="Slide Image">
                  <div class="overlay">
                    <div class="overlay-top">
                      <h2 class="mb-0 text-center">Welcome to SimpleFlow</h2>
                      <p class="text-center">Your Gateway to Effortless Management.</p>
                    </div>
                    <div class="overlay-bottom">
                      <h2 class="mb-0 text-center">Seamless Collaboration </h2>
                      <p class="text-center">Effortlessly work together with your team in real-time.</p>
                    </div>
                  </div>
                </div>
                <div class="swiper-slide h-100">
                  <img src="../../assets/images/img/slide1.png" alt="Slide Image">
                  <div class="overlay">
                    <div class="overlay-top">
                      <h2 class="mb-0 text-center">Welcome to SimpleFlow</h2>
                      <p class="text-center">Your Gateway to Effortless Management.</p>
                    </div>
                    <div class="overlay-bottom">
                      <h2 class="mb-0 text-center">Seamless Collaboration </h2>
                      <p class="text-center">Effortlessly work together with your team in real-time.</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-pagination"></div>
            </div>

          </div>
        </div>
        <div class="col-lg-6 mb-4 mb-lg-0">
          <div class="auth-tabs d-flex flex-column gap-3">
            <img class="auth-logo" src="{{ siteLogo() }}" alt="Logo">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item d-flex align-items-center justify-content-center flex-grow-1" role="presentation">
                <button class="nav-link flex-grow-1 active" id="pills-sign-up-tab" data-bs-toggle="pill"
                  data-bs-target="#pills-sign-up" type="button" role="tab" aria-controls="pills-sign-up"
                  aria-selected="true">Reset Password</button>
              </li>
            </ul>
          </div>
          <div class="auth-tab-content">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-sign-up" role="tabpanel"
                aria-labelledby="pills-sign-up-tab" tabindex="0">
                <form method="POST" class="">
                  <div class="row gy-2">
                    <div class="col-12">
                      <label class="form-label form--label" for="email">Email or Username</label>
                      <input type="email" class="form-control form--control checkUser" name="email" value=""
                        required="" placeholder="Email or Username" id="email">
                    </div>



                    <div class="col-12">
                      <button type="submit" id="recaptcha" class="submit-btn w-100">
                        Reset</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane fade" id="pills-sign-in" role="tabpanel" aria-labelledby="pills-sign-in-tab"
                tabindex="0">
                <form method="POST" class="">
                  <div class="row gy-2">
                    <div class="col-12">
                      <label class="form-label form--label" for="email">Email Id <span>*</span></label>
                      <input type="email" class="form-control form--control checkUser" name="email" value=""
                        required="" placeholder="Email" id="email">
                      <p class="forgot-pass text-end"><a href="{{ route('user.password.request') }}">Forgot
                          Password?</a>
                      </p>
                    </div>
                    <div class="col-12">
                      <label class="form-label form--label" for="password">Password <span>*</span></label>
                      <input type="password" class="form-control form--control " name="password" required=""
                        placeholder="Enter Password" id="password">
                    </div>
                    <div class="col-12">
                      <button type="submit" id="recaptcha" class="submit-btn w-100">
                        Sign In</button>
                    </div>
                  </div>
                  <div class="row">
                    <div class="or"><span>Or</span></div>
                    <div class="social-auth d-flex align-items-center justify-content-between gap-3">
                      <a href="#" class="d-flex align-items-center justify-content-center flex-grow-1">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35"
                          viewBox="0 0 48 48">
                          <path fill="#fbc02d"
                            d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12	s5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20	s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                          </path>
                          <path fill="#e53935"
                            d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039	l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                          </path>
                          <path fill="#4caf50"
                            d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36	c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                          </path>
                          <path fill="#1565c0"
                            d="M43.611,20.083L43.595,20L42,20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571	c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                          </path>
                        </svg>
                        <a href="#" class="d-flex align-items-center justify-content-center flex-grow-1">
                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35"
                            viewBox="0 0 48 48">
                            <linearGradient id="CXanuwD9EGkBgTn76_1mxa_p62ASPK2Kpqp_gr1" x1="9.993" x2="40.615"
                              y1="-299.993" y2="-330.615" gradientTransform="matrix(1 0 0 -1 0 -290)"
                              gradientUnits="userSpaceOnUse">
                              <stop offset="0" stop-color="#2aa4f4"></stop>
                              <stop offset="1" stop-color="#007ad9"></stop>
                            </linearGradient>
                            <path fill="url(#CXanuwD9EGkBgTn76_1mxa_p62ASPK2Kpqp_gr1)"
                              d="M24,4C12.954,4,4,12.954,4,24c0,10.028,7.379,18.331,17.004,19.777	C21.981,43.924,22.982,41,24,41c0.919,0,1.824,2.938,2.711,2.818C36.475,42.495,44,34.127,44,24C44,12.954,35.046,4,24,4z">
                            </path>
                            <path
                              d="M27.707,21.169c0-1.424,0.305-3.121,1.757-3.121h4.283l-0.001-5.617l-0.05-0.852l-0.846-0.114	c-0.608-0.082-1.873-0.253-4.206-0.253c-5.569,0-8.636,3.315-8.636,9.334v2.498H15.06v7.258h4.948V43.6	C21.298,43.861,22.633,44,24,44c1.268,0,2.504-0.131,3.707-0.357V30.301h5.033l1.122-7.258h-6.155V21.169z"
                              opacity=".05"></path>
                            <path
                              d="M27.207,21.169c0-1.353,0.293-3.621,2.257-3.621h3.783V12.46l-0.026-0.44l-0.433-0.059	c-0.597-0.081-1.838-0.249-4.143-0.249c-5.323,0-8.136,3.055-8.136,8.834v2.998H15.56v6.258h4.948v13.874	C21.644,43.876,22.806,44,24,44c1.094,0,2.16-0.112,3.207-0.281V29.801h5.104l0.967-6.258h-6.072V21.169z"
                              opacity=".05"></path>
                            <path fill="#fff"
                              d="M26.707,29.301h5.176l0.813-5.258h-5.989v-2.874c0-2.184,0.714-4.121,2.757-4.121h3.283V12.46	c-0.577-0.078-1.797-0.248-4.102-0.248c-4.814,0-7.636,2.542-7.636,8.334v3.498H16.06v5.258h4.948v14.475	C21.988,43.923,22.981,44,24,44c0.921,0,1.82-0.062,2.707-0.182V29.301z">
                            </path>
                          </svg>
                        </a>
                        <a href="#" class="d-flex align-items-center justify-content-center flex-grow-1">
                          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35"
                            viewBox="0 0 48 48">
                            <path fill="#0078d4"
                              d="M24,4C12.954,4,4,12.954,4,24s8.954,20,20,20s20-8.954,20-20S35.046,4,24,4z"></path>
                            <path
                              d="M30,35v-9c0-1.103-0.897-2-2-2s-2,0.897-2,2v9h-6V18h6v1.027C27.04,18.359,28.252,18,29.5,18	c3.584,0,6.5,2.916,6.5,6.5V35H30z M13,35V18h2.966C14.247,18,13,16.738,13,14.999C13,13.261,14.267,12,16.011,12	c1.696,0,2.953,1.252,2.989,2.979C19,16.733,17.733,18,15.988,18H19v17H13z"
                              opacity=".05"></path>
                            <path
                              d="M30.5,34.5V26c0-1.378-1.121-2.5-2.5-2.5s-2.5,1.122-2.5,2.5v8.5h-5v-16h5v1.534	c1.09-0.977,2.512-1.534,4-1.534c3.309,0,6,2.691,6,6v10H30.5z M13.5,34.5v-16h5v16H13.5z M15.966,17.5	c-1.429,0-2.466-1.052-2.466-2.501c0-1.448,1.056-2.499,2.511-2.499c1.436,0,2.459,1.023,2.489,2.489	c0,1.459-1.057,2.511-2.512,2.511H15.966z"
                              opacity=".07"></path>
                            <path fill="#fff"
                              d="M14,19h4v15h-4V19z M15.988,17h-0.022C14.772,17,14,16.11,14,14.999C14,13.864,14.796,13,16.011,13	c1.217,0,1.966,0.864,1.989,1.999C18,16.11,17.228,17,15.988,17z M35,24.5c0-3.038-2.462-5.5-5.5-5.5	c-1.862,0-3.505,0.928-4.5,2.344V19h-4v15h4v-8c0-1.657,1.343-3,3-3s3,1.343,3,3v8h4C35,34,35,24.921,35,24.5z">
                            </path>
                          </svg>
                        </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- <section class="account-section section--bg bg-overlay-white bg_img" data-background="{{ frontendImage('login', @$bg->data_values->background_image) }}">
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
    </section> --}}
@endsection
@push('script')
  <script>
    var swiper = new Swiper(".auth-slide", {
      autoplay: {
        delay: 4000,
      },
      speed: 800,
      loop: true,
      slidesPerView: 1,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  </script>
@endpush
