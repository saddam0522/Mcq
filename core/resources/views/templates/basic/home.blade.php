@extends($activeTemplate . 'layouts.frontend')
@section('content')
  @php
    $banner = @getContent('banner.content', true)->data_values;
  @endphp
  {{-- <section class="banner-section bg-overlay-white bg_img"
        data-background="{{ frontendImage('banner', @$banner->background_image) }}">
        <div class="container">
            <div class="row justify-content-center align-items-center mb-30-none">
                <div class="col-xl-10 text-center mb-30">
                    <div class="banner-content">
                        <h1 class="title text--base">{{ __(@$banner->heading) }}</h1>
                        <h3 class="sub-title text-white">{{ __(@$banner->sub_heading) }}</h3>
                        <div class="banner-btn">
                            <a href="{{ url(@$banner->button_1_link) }}"
                                class="btn--base">{{ __(@$banner->button_1_text) }}</a>
                            <a href="{{ url(@$banner->button_2_link) }}"
                                class="btn--base active">{{ __(@$banner->button_2_text) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
  {{-- @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif --}}
  {{-- Hero Section start here  --}}
  <section class="hero-section">
    <div class="container">
      @include('templates.basic.sections.hero_section')
    </div>
  </section>
  {{-- Hero Section end here  --}}
  {{-- Job Section start here  --}}
  <section class="job-section">
    <div class="container">
      <div class="row job-title-area px-3">
        <div class="col-md-3 p-0">
        <div class="job-section-title pt-3">
          <h2 class="m-0">চাকরির বিজ্ঞপ্তি</h2>
        </div>
        </div>
        <div class="col-md-6 job-title-middle p-0">
        </div>
        <div class="col-md-3 p-0">
        <div class="d-flex justify-content-end pt-2">
        <div class="job-section-btn align-items-center justify-content-center gap-3">
          <a href="#">View All</a>
          <i class="fa-solid fa-arrow-right"></i>
        </div>
        </div>
        </div>
      </div>
    </div>
    @include('templates.basic.sections.job_section')
  </section>
  {{-- Job Section end here  --}}
  {{-- MCQ Section start here  --}}
  <section class="mcq-section">
    <div class="container">
      @include('templates.basic.sections.job_section')
    </div>
  </section>
  {{-- MCQ Section end here  --}}
@endsection
