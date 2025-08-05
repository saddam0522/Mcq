@extends('templates.basic.layouts.master')

@section('content')
    <div class="dashboard-area mt-30">
        <h2>@lang('Change Password')</h2>
        <form method="POST" action="{{ route('employer.change.password') }}">
            @csrf
            <div class="form-group">
                <label>@lang('Current Password')</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>@lang('New Password')</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>@lang('Confirm Password')</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">@lang('Update Password')</button>
        </form>
    </div>
@endsection
