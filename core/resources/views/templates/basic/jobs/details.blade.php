@extends($activeTemplate . 'layouts.frontend')
@section('content')
@include($activeTemplate . 'partials.breadcrumb')
<section class="blog-details-section job-details-page blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-9 mb-30">
                <div class="job-details-content">
                    <div class="d-flex align-items-center justify-content-between gap-2 pb-2">
                        <h2 class="job-dt-title">{{ $job->title }}</h2>
                        <div class="d-flex align-items-center gap-2 job-share">
                            <a href="#"><i class="fa-solid fa-bookmark"></i></a>
                            <a href="#"><i class="fa-solid fa-share-nodes"></i></a>
                        </div>
                    </div>
                    <div class="company-dt d-flex align-items-center gap-3">
                        <div><img src="{{ asset($job->employer->logo ?? 'default-logo.png') }}" alt="Company Logo"></div>
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center gap-3">
                                <span>{{ $job->employer->company_name ?? '-' }}</span>
                                <span><i class="fa-solid fa-location-dot"></i> {{ $job->location }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-3 job-rqs pt-2">
                                <span>{{ $job->job_type }}</span>
                                <span>{{ $job->work_mode }}</span>
                                <span>{{ $job->experience_required }} years</span>
                            </div>
                        </div>
                    </div>
                    <div class="job-desc">
                        {!! $job->full_description !!}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="job-sidebar">
                    <h5 class="widget-title">Similar Jobs</h5>
                    <div class="popular-widget-box d-flex flex-column gap-3">
                        @foreach($similarJobs as $job)
                        <article class="job-card d-flex flex-column gap-3">
                            <div class="card-top d-flex flex-column gap-4">
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div class="date">{{ \Carbon\Carbon::parse($job->created_at)->format('j F, Y') }}</div>
                                    <div class="bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="19"
                                            viewBox="0 0 14 19" fill="none">
                                            <path
                                                d="M10.7536 1.65381H3.47662C2.37205 1.65381 1.47662 2.54924 1.47662 3.65381V17.4416L7.11511 14.8103L12.7536 17.4416V3.65381C12.7536 2.54924 11.8582 1.65381 10.7536 1.65381Z"
                                                stroke="#242328" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <div class="d-flex flex-column gap-0">
                                        <h5 class="mb-0 job-title">{{ $job->title }}</h5>
                                        <span class="mb-0 company">{{ $job->employer->company_name ?? '-' }}</span>
                                    </div>
                                    <div class="company-logo">
                                        <img src="{{ asset($job->employer->logo ?? 'default-logo.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="job-require-btns d-flex align-items-center justify-content-center gap-2">
                                    <span class="rq-btn">{{ $job->job_type }}</span>
                                    <span class="rq-btn">{{ $job->work_mode }}</span>
                                    <span class="rq-btn">{{ $job->experience_required }} years</span>
                                </div>
                            </div>
                            <div class="card-bottom d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex flex-column gap-0">
                                    <p class="mb-0">৳{{ number_format($job->salary_min) }} - ৳{{ number_format($job->salary_max) }} TK</p>
                                    <span>{{ $job->employer->company_name ?? '-' }}</span>
                                </div>
                                <div class="dark-btn">
                                    <a href="{{ route('job.details', $job->id) }}">বিস্তারিত</a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection