<article class="job-card d-flex flex-column gap-3">
    <div class="card-top d-flex flex-column gap-4">
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="date">{{ \Carbon\Carbon::parse($job->published_at)->format('d M Y') }}</div>
            <div class="bookmark">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="19" viewBox="0 0 14 19" fill="none">
                    <path d="M10.7536 1.65381H3.47662C2.37205 1.65381 1.47662 2.54924 1.47662 3.65381V17.4416L7.11511 14.8103L12.7536 17.4416V3.65381C12.7536 2.54924 11.8582 1.65381 10.7536 1.65381Z" stroke="#242328" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between gap-2">
            <div class="d-flex flex-column gap-0">
                <h5 class="mb-0 job-title">{{ $job->title }}</h5>
                <span class="mb-0 company">{{ $job->employer->company_name ?? '-' }}</span>
            </div>
            <div class="company-logo">
                <img src="{{ asset($job->employer->logo ?? 'default-logo.png') }}" alt="Company Logo">
            </div>
        </div>
        <div class="job-require-btns d-flex align-items-center justify-content-center gap-2">
            <span class="rq-btn">{{ $job->job_type }}</span>
            <span class="rq-btn">{{ $job->work_mode }}</span>
            <span class="rq-btn">{{ $job->experience_required }} years</span>
        </div>
        <p>{{ Str::limit($job->short_description, 100) }}</p>
    </div>
    <div class="card-bottom d-flex align-items-center justify-content-between gap-3">
        <div class="d-flex flex-column gap-0">
            <p class="mb-0">৳{{ number_format($job->salary, 2) }} {{ $job->currency }}</p>
            <span>{{ $job->location }}</span>
        </div>
        <div class="dark-btn">
            <a href="{{ route('job.details', ['id' => $job->id]) }}">@lang('Details')</a>
        </div>
    </div>
</article>