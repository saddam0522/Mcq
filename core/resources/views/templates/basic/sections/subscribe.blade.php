@php
    $content = getContent('subscribe.content', true)->data_values;
@endphp

<section class="call-to-action-section ptb-80 bg-overlay-white bg_img"
    data-background="{{ frontendImage('subscribe', @$content->background_image) }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 text-center">
                <div class="section-header white">
                    <h2 class="section-title">{{ __(@$content->heading) }}</h2>
                    <span class="title-border"><i class="las la-book-reader text--base h2"></i></span>
                </div>
            </div>
        </div>
        <div class="call-to-action-area">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-10">
                    <div class="call-to-action-content">
                        <form class="call-to-action-form">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-12">
                                    <form class="subscribe-form">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control email"
                                                placeholder="{{ __(@$content->placeholder) }}" required>
                                            <button type="button"
                                                class="submit-btn mt-0 subscribe">{{ __(@$content->button_text) }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . '/js/axios.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $('.subscribe').click(function() {
            var data = {
                email: $('.email').val()
            }
            axios.post('{{ route('subscribe') }}', data, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(function(response) {
                    if (response.data.email) {
                        $.each(response.data.email, function(i, val) {
                            notify('error', val);
                        });
                    } else {
                        notify('success', response.data.success);
                    }

                })

        })
    </script>
@endpush
