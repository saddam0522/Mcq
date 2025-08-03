@extends('templates.basic.layouts.master')

@section('content')
    <div class="dashboard-area mt-30">
        <h2>@lang('Profile Settings')</h2>
        <form method="POST" action="{{ route('employer.profile.setting') }}">
            @csrf
            <div class="form-group">
                <label>@lang('Company Name')</label>
                <input type="text" name="company_name" value="{{ old('company_name', $employer->company_name) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>@lang('Representative Name')</label>
                <input type="text" name="representative_name" value="{{ old('representative_name', $employer->representative_name) }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>@lang('Email')</label>
                <input type="email" name="email" value="{{ old('email', $employer->email) }}" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Update Profile')</button>
        </form>
    </div>
@endsection
