@php
  $footer = getContent('footer.content', true)->data_values;
  $element = getContent('footer.element', false, '', true);
  $policies = getContent('policy_pages.element', false, 4);
@endphp

<footer class="footer-section">
  <div class="footer-top-area">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-10 text-center">
          <div class="footer-widget widget-menu">
            <div class="footer-logo mb-20">
              <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}" alt="logo"></a>
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
  </div>
  <div class="footer-bottom-area mt-2">
    <div class="container">
      <div class="copyright text-center">
        <p>© কপিরাইট ২০১৭ - ২০২৫ | <a href="#">Jobcoachbd </a> কর্তৃক সব স্বত্ব সংরক্ষিত।</p>
      </div>
    </div>
  </div>
  </div>
</footer>
