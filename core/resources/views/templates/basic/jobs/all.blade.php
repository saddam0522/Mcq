@extends($activeTemplate . 'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<section class="exam-section pt-20 pb-50">
    <div class="container">
        <div class="row job-cards g-4">
            <div class="col-md-6 col-lg-4">
                @include('templates.basic.sections.job_card')
            </div>
            <div class="col-md-6 col-lg-4">
                @include('templates.basic.sections.job_card')
            </div>
            <div class="col-md-6 col-lg-4">
                @include('templates.basic.sections.job_card')
            </div>
            <div class="col-md-6 col-lg-4">
                @include('templates.basic.sections.job_card')
            </div>
            <div class="col-md-6 col-lg-4">
                @include('templates.basic.sections.job_card')
            </div>
        </div>
    </div>
</section>
@endsection