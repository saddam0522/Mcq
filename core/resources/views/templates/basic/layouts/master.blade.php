<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ gs()->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Fredericka+the+Great|Josefin+Sans:400,400i,500,500i,600,600i,700,700i&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/lightcase.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/style.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/custom.css') }}">

    @stack('style-lib')
    @stack('style')


    <link
        href="{{ asset('assets/templates/basic/css/color.php') }}?color={{ gs()->base_color }}&color2={{ gs()->secondary_color }}"rel="stylesheet" />
</head>

@php echo loadExtension('google-analytics') @endphp

<body class="bg--gray">

    <div class="preloader">
        <div class="loader book">
            <figure class="page"></figure>
            <figure class="page"></figure>
            <figure class="page"></figure>
        </div>
    </div>

    @if (Str::contains(request()->url(), 'user'))
        <section class="page-container">
            @include($activeTemplate . 'partials.sidemenu')
            <div class="body-wrapper">
                @include($activeTemplate . 'partials.dashboardHeader')
                @yield('content')
            </div>
        </section>
    @else
        <section class="page-container">
            @include($activeTemplate . 'employer.partials.sidebar')
            <div class="body-wrapper">
                @include($activeTemplate . 'employer.partials.dashboard-header')
                @yield('content')
            </div>
        </section>
    @endif

    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>

    <script src="{{ asset($activeTemplateTrue . 'js/swiper.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/odometer.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/lightcase.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/main.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue . 'js/nicEdit.js') }}"></script>

    @stack('script-lib')

    @php echo loadExtension('tawk-chat') @endphp

    @include('partials.notify')


    @if (gs('pn'))
        @include('partials.push_script')
    @endif


    <style>
        .deposit-area {
            background-color: transparent;
        }
    </style>


    @stack('script')

    <script>
        (function($, document) {
            "use strict";
            bkLib.onDomLoaded(function() {
                $(".nicEdit").each(function(index) {
                    $(this).attr("id", "nicEditor" + index);
                    new nicEditor({
                        fullPanel: true
                    }).panelInstance('nicEditor' + index, {
                        hasPanel: true
                    });
                });
            });
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });


        })(jQuery, document);
    </script>

    <script>
        (function($) {
            "use strict";
            $(".langSel").on("change", function() {
                window.location.href = "{{ route('home') }}/change/" + $(this).val();
            });

            var inputElements = $('[type=text],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function(i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }

            });


            let disableSubmission = false;
            $('.disableSubmission').on('submit', function(e) {
                if (disableSubmission) {
                    e.preventDefault()
                } else {
                    disableSubmission = true;
                }
            });

            $('.select2').each(function(index, element) {
                $(element).select2();
            });


            $('.select2-basic').each(function(index, element) {
                $(element).select2({
                    dropdownParent: $(element).closest('.select2-parent')
                });
            });


        })(jQuery);
    </script>

</body>

</html>
