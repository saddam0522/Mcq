@php
    $categories = \App\Models\Category::where('status', 1)->orderBy('name')->get();
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp

<header class="header-section">
    <div class="header">
        <div class="header-bottom-area">
            <div class="container">
                <div class="header-menu-content">
                    <nav class="navbar navbar-expand-lg p-0">
                        <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                                alt="logo"></a>

                        @php
                            $language = App\Models\Language::all();
                            $selectedLang = $language->where('code', session('lang'))->first();
                        @endphp

                        @if (gs('multi_language'))
                            <div class="language dropdown d-block d-lg-none ms-auto">
                                <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="language-content">
                                        <div class="language_flag">
                                            <img src="{{ getImage(getFilePath('language') . '/' . @$selectedLang->image, getFileSize('language')) }}"
                                                alt="flag">
                                        </div>
                                        <p class="language_text_select">{{ __(@$selectedLang->name) }}</p>
                                    </div>
                                    <span class="collapse-icon"><i class="las la-angle-down"></i></span>
                                </button>
                                <div class="dropdown-menu langList_dropdow py-2" style="">
                                    <ul class="langList">
                                        @foreach ($language as $item)
                                            <li class="language-list langSel" data-code="{{ $item->code }}">
                                                <div class="language_flag">
                                                    <img src="{{ getImage(getFilePath('language') . '/' . $item->image, getFileSize('language')) }}"
                                                        alt="flag">
                                                </div>
                                                <p class="language_text">{{ $item->name }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="fas fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav main-menu ms-auto me-auto">

                                @foreach ($pages as $k => $data)
                                    <li class="nav-item {{ menuActive('pages') }}">
                                        <a href="{{ route('pages', [$data->slug]) }}">{{ __($data->name) }}</a>
                                    </li>
                                @endforeach

                                <li class="menu_has_children {{ menuActive('category.subjects') }}">
                                    <a href="javascript:void(0)">@lang('Categories')</a>
                                    <ul class="sub-menu">
                                        @foreach ($categories as $cat)
                                            <li>
                                                <a
                                                    href="{{ route('category.subjects', $cat->slug) }}">{{ $cat->name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                                <li class="{{ menuActive('subjects') }}"><a
                                        href="{{ route('subjects') }}">@lang('Subjects')</a></li>
                                <li class="{{ menuActive('exams') }}"><a
                                        href="{{ route('exams') }}">@lang('Exams')</a></li>
                                <li class="{{ menuActive(['blog', 'blog.details']) }}"><a
                                        href="{{ route('blog') }}">@lang('Blog')</a></li>
                                <li class="{{ menuActive('faq') }}"><a
                                        href="{{ route('faq') }}">@lang('Faq')</a></li>
                                <li class="{{ menuActive('contact') }}"><a
                                        href="{{ route('contact') }}">@lang('Contact')</a></li>
                            </ul>

                            @if (gs('multi_language'))
                                <div class="language dropdown d-none d-xl-block me-2">
                                    <button class="language-wrapper" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="language-content">
                                            <div class="language_flag">
                                                <img src="{{ getImage(getFilePath('language') . '/' . @$selectedLang->image, getFileSize('language')) }}"
                                                    alt="flag">
                                            </div>
                                            <p class="language_text_select">{{ __(@$selectedLang->name) }}</p>
                                        </div>
                                        <span class="collapse-icon"><i class="las la-angle-down"></i></span>
                                    </button>
                                    <div class="dropdown-menu langList_dropdow py-2" style="">
                                        <ul class="langList">
                                            @foreach ($language as $item)
                                                <li class="language-list langSel" data-code="{{ $item->code }}">
                                                    <div class="language_flag">
                                                        <img src="{{ getImage(getFilePath('language') . '/' . $item->image, getFileSize('language')) }}"
                                                            alt="flag">
                                                    </div>
                                                    <p class="language_text">{{ $item->name }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif





                            <div class="header-action">
                                @guest
                                    @if (gs('registration'))
                                        <a href="{{ route('user.register') }}"
                                            class="btn--base"><span>@lang('Register')</span></a>
                                    @endif
                                    <a href="{{ route('user.login') }}"
                                        class="btn--base active"><span>@lang('Login')</span></a>
                                @endguest
                                @auth
                                    <a href="{{ route('user.home') }}" class="btn--base"><span>@lang('Dashboard')</span></a>
                                    <a href="{{ route('user.logout') }}"
                                        class="btn--base active"><span>@lang('Logout')</span></a>
                                @endauth
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

@push('script')
    <script>
        $(document).ready(function() {
            const $mainlangList = $(".langList");
            const $langBtn = $(".language-content");
            const $langListItem = $mainlangList.children();

            $langListItem.each(function() {
                const $innerItem = $(this);
                const $languageText = $innerItem.find(".language_text");
                const $languageFlag = $innerItem.find(".language_flag");

                $innerItem.on("click", function(e) {
                    $langBtn.find(".language_text_select").text($languageText.text());
                    $langBtn.find(".language_flag").html($languageFlag.html());
                });
            });
        });

        $(".langSel").on("click", function() {
            window.location.href = "{{ route('home') }}/change/" + $(this).data('code');
        });
    </script>
@endpush
