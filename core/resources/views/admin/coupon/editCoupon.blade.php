@extends('admin.layouts.app')

@section('panel')
    <div class="container-fluid">

        <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card b-radius--10 p-4">
                        <div class="card-body">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Coupon Name') </label>
                                <input class="form-control" type="text" placeholder="@lang('Coupon Name')" name="name"
                                    required value="{{ $coupon->name }}">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Short details') </label>
                                <textarea class="form-control" placeholder="@lang('Short Details')" name="details" required>{{ $coupon->details }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Select an Exam') </label>
                                <select name="exam_id" class="form-control select2" data-minimum-results-for-search="-1"
                                    required id="exam_id">
                                    <option value="">--@lang('Select Option')--</option>
                                    <option value="0" {{ $coupon->exam_id == 0 ? 'selected' : '' }}>@lang('For All Exam')
                                    </option>
                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}"
                                            {{ $coupon->exam_id == $exam->id ? 'selected' : '' }}>{{ $exam->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Amount Type') </label>
                                <select name="amount_type" class="form-control select2" data-minimum-results-for-search="-1"
                                    required id="amount_type">
                                    <option value="1" {{ $coupon->amount_type == 1 ? 'selected' : '' }}>
                                        @lang('Percentage')</option>
                                    <option value="2" {{ $coupon->amount_type == 2 ? 'selected' : '' }}>
                                        @lang('Fixed')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Discount Amount') </label>
                                <div class="input-group">
                                    <input class="form-control" type="number" min="1"
                                        placeholder="@lang('Discount Amount')" name="coupon_amount" required
                                        value="{{ getAmount($coupon->coupon_amount) }}">
                                    <span class="input-group-text" id="suffix">%</span>
                                </div>
                            </div>



                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Minmum Order Amount (optional)')</label>
                                <div class="input-group">
                                    <input class="form-control" type="number" min="0"
                                        placeholder="@lang('Minmum Order Amount (optional)')" name="min_order_amount"
                                        value="{{ getAmount($coupon->min_order_amount) }}">
                                    <span class="input-group-text" id="suffix">{{ gs()->cur_text }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Coupon Code') </label>
                                <input class="form-control" type="text" placeholder="@lang('Coupon Code')"
                                    name="coupon_code" required value="{{ $coupon->coupon_code }}">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Total Usage limit (optional)')</label>
                                <input class="form-control" type="number" min="0" placeholder="@lang('Total Usage limit')"
                                    name="use_limit" value="{{ $coupon->use_limit }}">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('User usage limit (optional)')</label>
                                <input class="form-control" type="number" min="0" placeholder="@lang('User usage limit (optional)')"
                                    name="usage_per_user" value="{{ $coupon->usage_per_user }}">
                            </div>


                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Start date') </label>
                                <input type="text" name="start_date" class="datepicker-here form-control"
                                    data-language='en' data-date-format="yyyy-mm-dd" data-position='top left'
                                    placeholder="@lang('Start Date')" required value="{{ $coupon->start_date }}">

                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('End date') </label>

                                <input type="text" name="end_date" class="datepicker-here form-control"
                                    data-language='en' data-date-format="yyyy-mm-dd" data-position='top left'
                                    placeholder="@lang('End Date')" required value="{{ $coupon->end_date }}">

                            </div>
                            <div class="form-group w-100">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status" @if ($coupon->status == 1) checked @endif>
                            </div>
                            <button type="submit" class="btn btn--primary w-100 h-45 mt-3">@lang('Submit')</button>
                        </div>

                    </div>
                </div>

            </div>


        </form>
    </div>
    <!-- card end -->
@endsection


@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.coupon.all') }}" />
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/datepicker.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict'
        $('#amount_type').on('change', function() {
            var cur = "{{ gs()->cur_text }}"
            if ($(this).val() == 1) {
                $('#suffix').text('%')
            } else if ($(this).val() == 2) {
                $('#suffix').text(cur)
            }
        })
    </script>
@endpush
