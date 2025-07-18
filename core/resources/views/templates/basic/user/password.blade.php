@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="reset-area mt-30">
        <div class="panel panel-default">
            <div class="panel-form-area">
                <form class="panel-form" method="POST">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-lg-12 form-group">
                            <label>@lang('Current Password')</label>
                            <input type="password" name="current_password" class="form-control" placeholder="@lang('Current Password')"
                                required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>@lang('Password')</label>
                            <input type="password" name="password"
                                class="form-control @if (gs('secure_password')) secure-password @endif"
                                placeholder="@lang('Password')" required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <label>@lang('Confirm Password')</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="@lang('Confirm Password')" required>
                        </div>
                        <div class="col-lg-12 form-group">
                            <button type="submit"
                                class="btn--base border--rounded text-white btn-block p-2">@lang('Change Password')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .reset-area {
            overflow: visible !important;
        }
    </style>
@endpush

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
