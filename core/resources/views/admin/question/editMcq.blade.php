@extends('admin.layouts.app')

@section('panel')
    <div class="container-fluid">

        <form action="{{ route('admin.exam.question.update', $qtn->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card b-radius--10 p-4">
                        <div class="card-body">
                            <input type="hidden" name="examid" value="{{ $exam->id }}">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Question')</label>
                                <textarea class="form-control nicEdit" name="question" rows="6" placeholder="@lang('Question')">{{ $qtn->question }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('Mark')</label>
                                <input class="form-control" type="text" name="mark" placeholder="@lang('Mark')" value="{{ $qtn->marks }}" required>
                            </div>


                            <label class="font-weight-bold" for="exampleInputnumber1">@lang('Options')</label>
                            @foreach ($qtn->options as $key => $option)
                                <div class="form-group  d-flex justify-content-between">
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent" id="my-addon">
                                            <div class="custom-control custom-radio form-check-primary d-flex align-items-center">
                                                <input {{ $option->correct_ans == 1 ? 'checked' : '' }} type="radio" id="customRadio{{ $loop->iteration }}" name="correct" class="custom-control-input"
                                                    value="{{ $loop->iteration }}" required>
                                                <label class="custom-control-label text-secondary m-0 ps-2" for="customRadio{{ $loop->iteration }}">@lang('Correct')</label>
                                            </div>
                                        </span>
                                        <input type="text" class="form-control me-1" name="option[{{ $loop->iteration }}]" value="{{ $option->option }}" placeholder="@lang('Option')" required>
                                    </div>
                                    <button type="button" class="icon-btn btn--danger  text-center text-nowrap remove"><i class="las la-minus-circle text--white"></i></button>

                                </div>
                            @endforeach
                            <div class="append"></div>
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-sm btn-outline--primary mt-2" id="add"> <i class="las la-plus"></i> @lang('Add More')</button>
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
    <x-back route="{{ route('admin.exam.questions', $exam->id) }}" />
@endpush

@push('script')
    <script>
        'use strict'

        var i = $('.inx').children().last().find('input[name=correct]').val();
        $(document).on('click', '#add', function() {
            ++i
            var element = `
            <div class="form-group d-flex justify-content-between">
                <div class="input-group">
                    <span class="input-group-text bg-transparent" id="my-addon">
                        <div class="custom-control custom-radio form-check-primary d-flex align-items-center">
                            <input type="radio" id="customRadio${i}" name="correct" class="custom-control-input" value="${i}" required>
                            <label class="custom-control-label text-secondary m-0 px-2" for="customRadio${i}">@lang('Correct')</label>
                          </div>
                    </span>

                        <input type="text" class="form-control me-1" name="option[${i}]" placeholder="@lang('Option')" required>
                     </div>
                <button type="button" class="icon-btn btn--danger  text-center text-nowrap remove"><i class="las la-minus-circle text--white"></i></button>
            </div>`;

            $('.append').append(element);


        })


        $(document).on('click', '.remove', function() {
            $(this).parent('.form-group').remove()
        })
    </script>
@endpush
