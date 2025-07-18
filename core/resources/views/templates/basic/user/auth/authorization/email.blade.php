@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'partials.breadcrumb')

    <section class="exam-section ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">

                    <div class="d-flex justify-content-center">
                        <div class="verification-code-wrapper">
                            <div class="verification-area">
                                <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form">
                                    @csrf
                                    <p class="verification-text">@lang('A 6 digit verification code sent to your email address'):
                                        {{ showEmailAddress(auth()->user()->email) }}</p>

                                    @include($activeTemplate . 'partials.verification_code')

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                                    </div>

                                    <div class="mb-3">
                                        <p>
                                            @lang('If you don\'t get any code'), <span class="countdown-wrapper">@lang('try again after') <span
                                                    id="countdown" class="fw-bold">--</span> @lang('seconds')</span> <a
                                                href="{{ route('user.send.verify.code', 'email') }}"
                                                class="try-again-link d-none"> @lang('Try again')</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection

@push('style')
    <style>
        .verification-code input {
            letter-spacing: 51px;
            color: #121212 !important;
        }

        .verification-code span {
            background-color: #F1F1F1;
            color: black
        }

        .verification-code::after {
            background-color: transparent;
        }

        .form--label {
            color: black
        }
    </style>
@endpush

@push('script')
    <script>
        var distance = Number("{{ @$user->ver_code_send_at->addMinutes(2)->timestamp - time() }}");
        var x = setInterval(function() {
            distance--;
            document.getElementById("countdown").innerHTML = distance;
            if (distance <= 0) {
                clearInterval(x);
                document.querySelector('.countdown-wrapper').classList.add('d-none');
                document.querySelector('.try-again-link').classList.remove('d-none');
            }
        }, 1000);
    </script>
@endpush
