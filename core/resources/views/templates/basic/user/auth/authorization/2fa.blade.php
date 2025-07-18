@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'partials.breadcrumb')
    <section class="exam-section ptb-80">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="verification-code-wrapper">
                    <div class="verification-area">
                        <form action="{{ route('user.2fa.verify') }}" method="POST" class="submit-form">
                            @csrf
                            @include($activeTemplate . 'partials.verification_code')
                            <div class="form--group">
                                <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                            </div>
                        </form>
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
