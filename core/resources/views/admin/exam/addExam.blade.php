@extends('admin.layouts.app')

@section('panel')
    <div class="container-fluid">

        <form action="{{ route('admin.exam.manage.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card b-radius--10 ">
                <div class="card-body">
                    <div class="row p-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Select Subject') </label>
                                <select class="form-control select2" data-minimum-results-for-search="-1" name="subject_id"
                                    required>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Title') </label>
                                <input class="form-control" placeholder="@lang('Exam Title')" type="text" name="title"
                                    required value="{{ old('title') }}">
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Instruction') </label>
                                <textarea class="form-control nicEdit" name="instruction" value="{{ old('instruction') }}"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Question Type') </label>
                                <select class="form-control select2" data-minimum-results-for-search="-1"
                                    name="question_type" id="qtype" required>
                                    <option value="1">@lang('MCQ')</option>
                                    <option value="2">@lang('Written')</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Total Mark') </label>
                                <input class="form-control" placeholder="@lang('Exam Total Mark')" type="text" name="totalmark"
                                    required value="{{ old('totalmark') }}">
                            </div>


                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Pass Mark Percentage') </label>
                                <div class="input-group">
                                    <input class="form-control" placeholder="@lang('Pass Mark Percentage eg: 33%')" type="text"
                                        name="pass_percentage" required value="{{ old('pass_percentage') }}">
                                    <span class="input-group-text" id="suffix">%</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Time Duration (in minute)') </label>
                                <input class="form-control" placeholder="@lang('Exam time duration in minute')" type="text" name="duration"
                                    required value="{{ old('duration') }}">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Payment Type') </label>
                                <select class="form-control value select2" data-minimum-results-for-search="-1"
                                    name="value" required>

                                    <option value="1">@lang('Paid')</option>
                                    <option value="2" selected>@lang('Unpaid')</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Exam Fee') </label>
                                <div class="input-group">
                                    <input class="form-control exam_fee" placeholder="@lang('Exam Fee')" type="text"
                                        name="exam_fee" required value="{{ old('exam_fee') }}">
                                    <span class="input-group-text" id="suffix">{{ gs()->cur_text }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Start date') </label>

                                <input type="text" name="start_date" class="datepicker-here form-control"
                                    data-language='en' data-date-format="dd-mm-yyyy" data-position='top left'
                                    placeholder="@lang('Start Date')" required value="{{ old('start_date') }}">

                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('End Date') </label>
                                <input type="text" name="end_date" class="datepicker-here form-control"
                                    data-language='en' data-date-format="dd-mm-yyyy" data-position='top left'
                                    placeholder="@lang('End Date')" required value="{{ old('end_date') }}">

                            </div>


                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-edit">
                                            <x-image-uploader class="w-100" type="examThumbnail" :required=false />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-control-label  font-weight-bold">@lang('Negative Marking (optional)') <small
                                        class="warning text-danger"></small> </label>
                                <input type="checkbox" class="neg_status removeEl" data-width="100%"
                                    data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle"
                                    data-on="@lang('ON')" data-off="@lang('OFF')" name="neg_status">
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Reduce Mark')</label>
                                <input class="form-control reduce" type="text" placeholder="@lang('Reduce Mark')"
                                    name="reduce_mark" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Question Randomize (optional)') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('ON')" data-off="@lang('OFF')"
                                    name="randomize">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Question options suffle (optional)') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('ON')" data-off="@lang('OFF')"
                                    name="opt_suffle">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status">
                            </div>
                        </div>

                        <div class="col-lg-12">
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
    <x-back route="{{ route('admin.exam.manage.all') }}" />
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
        $('.datepicker-here').datepicker();
        (function($) {

            function options(data) {
                if ($(data).val() == 1) {
                    $('.exam_fee').removeAttr('disabled')
                } else if ($(data).val() == 2) {
                    $('.exam_fee').attr('disabled', true)
                } else {
                    return false;
                }
            }

            $('.value option').each(function() {
                options(this);

            })

            $('.value').on('change', function() {
                options(this);
            });

            $('.neg_status').on('change', function() {
                if ($(".neg_status").is(':checked'))
                    $(".reduce").removeAttr('disabled');
                else
                    $(".reduce").attr('disabled', true);
            });

            $('#qtype').on('change', function() {

                if ($(this).val() == 2) {
                    $('.warning').text('Negative marking is disabled when question type is written')
                    $('.removeEl').attr('disabled', true)
                } else if ($(this).val() == 1) {
                    $('.warning').text('')
                    $('.removeEl').attr('disabled', false)
                }
            })

        })(jQuery);
    </script>
@endpush
