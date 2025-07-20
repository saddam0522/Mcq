@php
  $categories = \App\Models\Category::where('status', 1)->orderBy('name')->get();
  $pages = App\Models\Page::where('tempname', $activeTemplate)->where('is_default', Status::NO)->get();
@endphp

<header class="header-section">
  <div class="header">
    <div class="header-bottom-area">
      <div class="container">
        <div class="header-menu-content">
          <nav class="navbar navbar-expand-lg p-0">
            <div class="logo-area">
              <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
            </div>

            <button class="navbar-toggler ml-auto" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="fas fa-bars"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="header-nav-menus">
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
                        <a href="{{ route('category.subjects', $cat->slug) }}">{{ $cat->name }}</a>
                      </li>
                    @endforeach

                  </ul>
                </li>
                <li class="{{ menuActive('subjects') }}"><a href="{{ route('subjects') }}">@lang('Subjects')</a></li>
                <li class="{{ menuActive('exams') }}"><a href="{{ route('exams') }}">@lang('Exams')</a></li>
                <li class="{{ menuActive(['blog', 'blog.details']) }}"><a
                    href="{{ route('blog') }}">@lang('Blog')</a></li>
                <li class="{{ menuActive('faq') }}"><a href="{{ route('faq') }}">@lang('Faq')</a></li>
                <li class="{{ menuActive('contact') }}"><a href="{{ route('contact') }}">@lang('Contact')</a></li>
              </ul>
              </div>
              <div class="header-nav-btns">
                <div class="header-action">
                  @guest
                    @if (gs('registration'))
                      <a href="{{ route('user.register') }}" class="btn--base"><span>@lang('Register')</span></a>
                    @endif
                    <a href="{{ route('user.login') }}" class="btn--base active"><span>@lang('Login')</span></a>
                  @endguest
                  @auth
                    <a href="{{ route('user.home') }}" class="btn--base"><span>@lang('Dashboard')</span></a>
                    <a href="{{ route('user.logout') }}" class="btn--base active"><span>@lang('Logout')</span></a>
                  @endauth
                </div>
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
