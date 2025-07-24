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
  <section class="job-section m-lf-10">
    <div class="container">
      <div class="section-top">
        <div class="d-flex align-items-center justify-content-center">
          <div class="s-middle">
          </div>
        </div>
        <div class="section-both-side d-flex align-items-center justify-content-between gap-3">
          <div class="s-left w-full">
            <h2 class="s-title text-center text-md-start">চাকরির বিজ্ঞপ্তি</h2>
          </div>
          <div class="s-right m-hide">
            <div class="job-section-btn align-items-center justify-content-center gap-3">
              <a href="{{ route('all.jobs') }}">View All</a>
              <i class="fa-solid fa-arrow-right"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('templates.basic.sections.job_section')
    <div class="container">
      <div class="m-visible  d-none">
        <div class="d-flex justify-content-center pt-4">
        <div class="job-section-btn align-items-center justify-content-center gap-3">
        <a href="#">View All</a>
        <i class="fa-solid fa-arrow-right"></i>
      </div>
      </div>
      </div>
    </div>
  </section>
  {{-- Job Section end here  --}}
  {{-- MCQ Section start here  --}}
  <section class="mcq-section">
    <div class="container">
      @include('templates.basic.sections.mcq_section')
    </div>
  </section>
  {{-- MCQ Section end here  --}}
  {{-- Guidline Section start here  --}}
  <section class="guidline-section m-lf-10">
    <div class="container">
      @include('templates.basic.sections.guideline_section')
    </div>
  </section>
  {{-- Guidline Section end here  --}}
  {{-- Features Section start here  --}}
  <section class="features-section">
    <div class="container">
      @include('templates.basic.sections.features_section')
    </div>
  </section>
  {{-- Features Section end here  --}}
  {{-- Advisor Section start here  --}}
  <section class="advisor-section m-lf-10">
    <div class="container">
      <div class="d-flex align-items-center justify-content-center">
        <h2 class="section-title text-center">এয়াডভাইসার প্যানেল</h2>
      </div>
    </div>
    @include('templates.basic.sections.advisor_section')
  </section>
  {{-- Advisor Section end here  --}}
  {{-- Blog Section start here  --}}
  <section class="blog-section m-lf-10">
    <div class="container">
      <div class="d-flex align-items-center justify-content-center">
        <h2 class="section-title text-center">ব্লগ</h2>
      </div>
    </div>
    @include('templates.basic.sections.blog_section')
  </section>
  {{-- Blog Section end here  --}}
  {{-- FAQS Section start here  --}}
  <section class="faqs-section m-lf-10">
    <div class="container">
      @include('templates.basic.sections.faq_section')
    </div>
  </section>
  {{-- FAQS Section end here  --}}
@endsection
