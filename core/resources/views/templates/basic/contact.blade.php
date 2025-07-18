@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $contact = getContent('contact.content', true)->data_values;
    @endphp
    @include($activeTemplate . 'partials.breadcrumb')

    <section class="contact-section pt-80">
        <div class="container">
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-6 mb-30">
                    <div class="contact-info-item-area mb-40-none">
                        <div class="contact-info-header mb-30">
                            <h3 class="header-title">{{ __(@$contact->heading) }}</h3>
                            <p>{{ __(@$contact->short_details) }}</p>
                        </div>
                        <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                            <div class="contact-info-icon">
                                <i class="fas fa fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="title">@lang('Address')</h3>
                                <p>{{ @$contact->address }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                            <div class="contact-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="title">@lang('Email Address')</h3>
                                <p>{{ @$contact->email }}</p>
                            </div>
                        </div>
                        <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                            <div class="contact-info-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <h3 class="title">@lang('Phone Number')</h3>
                                <p>{{ @$contact->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-30">
                    <div class="contact-form-area">
                        <h3 class="title">@lang('Drop Us a Line')</h3>

                        <form method="post" class="contact-form verify-gcaptcha">
                            @csrf
                            <div class="row justify-content-center mb-10-none">
                                <div class="col-lg-12 form-group">
                                    <input name="name" type="text" placeholder="@lang('Your Name')"
                                        class="form-control form--control" value="{{ old('name', @$user->fullname) }}"
                                        @if ($user && $user->profile_complete) readonly @endif required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input name="email" type="email" placeholder="@lang('Enter E-Mail Address')"
                                        class="form-control form--control" value="{{ old('email', @$user->email) }}"
                                        @if ($user) readonly @endif required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input name="subject" type="text" placeholder="@lang('Write your subject')"
                                        class="form-control form--control" value="{{ old('subject') }}" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <textarea name="message" placeholder="@lang('Write your message')" class="form-control form--control" required>{{ old('message') }}</textarea>
                                </div>
                                <x-captcha />
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="submit-btn">@lang('Send Message')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-map-section mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 px-0">
                    <div class="contact-map">
                        <iframe
                            src="https://maps.google.com/maps?q={{ @$contact->latitude }},{{ @$contact->longitude }}&hl=es;z=14&amp;output=embed"
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
