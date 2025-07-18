@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @include($activeTemplate . 'partials.breadcrumb')

    <section class="exam-section ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                    <p class="text-center text--danger fw-bold fs-2">{{ $user->ban_reason }}</p>

                </div>
            </div>
        </div>
    </section>
@endsection
