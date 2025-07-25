@extends($activeTemplate . 'layouts.frontend')

@section('content')
  @include($activeTemplate . 'partials.breadcrumb')

  <section class="exam-section ptb-80">
    <div class="container">
      <div class="row justify-content-center mb-30-none">
        @foreach ($blogElements as $el)
          <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
            <article class="">
              <a href="{{ route('blog.details', $el->slug) }}" class="blog-card d-flex flex-column justify-content-between">
                <img src="{{ frontendImage('blog', '/thumb_' . @$el->data_values->cover_image, '420x225') }}"
                  alt="blog">
                <div class="d-flex flex-column gap-1 mt-4">
                  <h4 class="mb-1 blog-title">{{ __(strLimit(@$el->data_values->title, 40)) }}</h4>
                  <p class="blog-desc">লরেম ইপসাম ইংরেজিটা আমরা সবাই ব্যবহার করে থাকি। কিন্তু অনেক সময় আমাদের বাংলাতে লরেম ইপ্সাম প্রয়োজন
                    হয়।</p>
                </div>
              </a>
            </article>
          </div>
        @endforeach

      </div>
      <div class="mt-5">
        {{ paginateLinks($blogElements) }}
      </div>
    </div>
  </section>
@endsection
