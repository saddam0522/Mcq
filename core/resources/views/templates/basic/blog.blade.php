@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @include($activeTemplate . 'partials.breadcrumb')

    <section class="exam-section ptb-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                @foreach ($blogElements as $el)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="{{ frontendImage('blog', '/thumb_' . @$el->data_values->cover_image, '420x225') }}"
                                    alt="blog">
                            </div>
                            <div class="blog-content d-flex flex-wrap align-items-center">
                                <span class="blog-date">
                                    <div class="date-icon">
                                        <i class="las la-calendar"></i>
                                    </div>
                                    <div class="date-content">
                                        {{ showDateTime($el->created_at, 'd M') }}
                                    </div>
                                </span>
                                <div class="blog-content-details">
                                    <h3 class="title"><a
                                            href="{{ route('blog.details', $el->slug) }}">{{ __(strLimit(@$el->data_values->title, 40)) }}</a>
                                    </h3>
                                    <div class="blog-btn">
                                        <a href="{{ route('blog.details', $el->slug) }}"
                                            class="custom-btn">@lang('Read More') <i
                                                class="las la-angle-double-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="mt-5">
                {{ paginateLinks($blogElements) }}
            </div>
        </div>
    </section>
@endsection
