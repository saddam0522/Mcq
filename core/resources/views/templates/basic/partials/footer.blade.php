@php
    $footer = getContent('footer.content', true)->data_values;
    $element = getContent('footer.element', false, '', true);
    $policies = getContent('policy_pages.element', false, 4);
@endphp

<footer class="footer-section pt-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 text-center">
                <div class="footer-widget widget-menu">
                    <div class="footer-logo mb-20">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                                alt="logo"></a>
                    </div>
                    <p>{{ __(@$footer->short_details) }}</p>
                    <div class="social-area">
                        <ul class="footer-social">
                            @foreach (@$element ?? [] as $el)
                                <li><a target="_blank" href="{{ @$el->data_values->link }}">@php
                                    echo @$el->data_values->icon;
                                @endphp</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="copyright-area d-flex flex-wrap align-items-center justify-content-between mb-10-none">
                        <div class="copyright mb-10">
                            <p>@lang('Copyright') © {{ date('Y') }} @lang('All Rights reserved by') <a class="text--base"
                                    href="{{ route('home') }}">{{ gs()->site_name }}</a></p>
                        </div>
                        <ul class="copyright-list mb-10">
                            @foreach (@$policies ?? [] as $item)
                                <li><a
                                        href="{{ route('policy.pages', $item->slug) }}">{{ __(@$item->data_values->title) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
