@extends('templates.basic.layouts.master')

@section('content')
    <div class="dashboard-area mt-30">
        <h2>@lang('Profile Settings')</h2>
        <form method="POST" action="{{ route('employer.profile.setting') }}" enctype="multipart/form-data">
            @csrf
            <div class="row gy-4">
                <!-- Company Name -->
                <div class="col-md-4">
                    <label for="company_name" class="form-label">@lang('Company Name')</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $employer->company_name) }}" class="form-control" required>
                </div>

                <!-- Industry -->
                <div class="col-md-4">
                    <label for="industry" class="form-label">@lang('Industry')</label>
                    <input type="text" name="industry" value="{{ old('industry', $employer->industry) }}" class="form-control">
                </div>

                <!-- Website -->
                <div class="col-md-4">
                    <label for="website" class="form-label">@lang('Website')</label>
                    <input type="url" name="website" value="{{ old('website', $employer->website) }}" class="form-control">
                </div>

                <!-- Company Address -->
                <div class="col-md-4">
                    <label for="company_address" class="form-label">@lang('Company Address')</label>
                    <input type="text" name="company_address" value="{{ old('company_address', $employer->company_address) }}" class="form-control">
                </div>

                <!-- Company City -->
                <div class="col-md-4">
                    <label for="company_city" class="form-label">@lang('Company City')</label>
                    <input type="text" name="company_city" value="{{ old('company_city', $employer->company_city) }}" class="form-control">
                </div>

                <!-- Company Country -->
                <div class="col-md-4">
                    <label for="company_country" class="form-label">@lang('Company Country')</label>
                    <input type="text" name="company_country" value="{{ old('company_country', $employer->company_country) }}" class="form-control">
                </div>

                <!-- Representative Name -->
                <div class="col-md-4">
                    <label for="representative_name" class="form-label">@lang('Representative Name')</label>
                    <input type="text" name="representative_name" value="{{ old('representative_name', $employer->representative_name) }}" class="form-control" required>
                </div>

                <!-- Representative Designation -->
                <div class="col-md-4">
                    <label for="representative_designation" class="form-label">@lang('Representative Designation')</label>
                    <input type="text" name="representative_designation" value="{{ old('representative_designation', $employer->representative_designation) }}" class="form-control">
                </div>

                <!-- Representative Email -->
                <div class="col-md-4">
                    <label for="representative_email" class="form-label">@lang('Representative Email')</label>
                    <input type="email" name="representative_email" value="{{ old('representative_email', $employer->representative_email) }}" class="form-control">
                </div>

                <!-- Representative Phone -->
                <div class="col-md-4">
                    <label for="representative_phone" class="form-label">@lang('Representative Phone')</label>
                    <input type="text" name="representative_phone" value="{{ old('representative_phone', $employer->representative_phone) }}" class="form-control">
                </div>

                <!-- Email (Non-editable) -->
                <div class="col-md-4">
                    <label for="email" class="form-label">@lang('Email')</label>
                    <input type="email" name="email" value="{{ $employer->email }}" class="form-control" readonly>
                </div>

                <!-- Logo Upload -->
                <div class="col-md-4">
                    <label for="logo" class="form-label">@lang('Company Logo')</label>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*" {{ $employer->logo ? '' : 'required' }}>
                    <div class="mt-2">
                        <img id="logo-preview" src="{{ $employer->logo ? asset($employer->logo) : asset('default-logo.png') }}" alt="Logo Preview" style="max-width: 100px; max-height: 100px;">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">@lang('Update Profile')</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        document.getElementById('logo').addEventListener('change', function (event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('logo-preview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endpush
