@extends($activeTemplate . 'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<section class="exam-section pt-20 pb-50">
    <div class="container">
        <div class="row job-cards g-4">
            @forelse ($jobs as $job)
                <div class="col-md-6 col-lg-4">
                    @include('templates.basic.sections.job_card', ['job' => $job])
                </div>
            @empty
                <p class="text-center">@lang('No jobs found.')</p>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $jobs->links() }}
        </div>
    </div>
</section>
@endsection