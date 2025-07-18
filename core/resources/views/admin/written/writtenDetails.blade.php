@extends('admin.layouts.app')

@section('panel')
    <div class="container-fluid">
        <div class="row justify-content-center mb-3">
            <div class="col-xl-8">
                <div class="card b-radius--10 p-4">
                    <div class="card-body d-flex justify-content-between">
                        <h4 class="">@lang('Exam Title : ') <span class="text--primary">{{ $details->exam->title }}</span>
                        </h4>
                        <h4 class="ml-3">@lang('Student : ') <a href="{{ route('admin.users.detail', $details->user->id) }}"
                                class="text--primary h5">{{ $details->user->username }}</a></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card b-radius--10 p-4 content">
                    <div class="card-header d-flex justify-content-between">
                        <h4>@lang($details->question) </h4>
                        <small class="text--danger">(@lang('Mark'): {{ $details->writtenQuestion->marks }})</small>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold d-flex justify-content-between mb-3">@lang('Answer') :
                                <button type="button" class="btn btn-sm btn-outline--primary" data-bs-toggle="modal"
                                    data-bs-target="#correctAns">@lang('View correct ans.')</button>
                            </label>
                            <p>@lang($details->answer) </p>
                        </div>

                        <small class="given_mark font-weight-bold text-danger">@lang('Given Mark') :
                            {{ $details->given_mark ?? '' }}</small>
                    </div>
                    <div class="card-footer py-4">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="input-group parent">
                                    <input type="number" name="mark" min="0" class="form-control"
                                        placeholder="@lang('Give marks')">
                                    <button type="submit" class="btn btn--primary givemark m-0 givemark" id="my-addon"
                                        data-id="{{ $details->id }}">@lang('Submit')</button>

                                </div>
                            </div>
                            <div class="col-md-5 ">

                                @if ($details->correct_ans == 1)
                                    <button type="button" class="btn btn--secondary w-100 h-100"
                                        disabled>@lang('Correct Answer Provided ')</button>
                                @else
                                    <button type="button" class="btn btn--primary w-100 h-100 crrAns"
                                        data-id="{{ $details->id }}">@lang('Provide Correct Answer')</button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Correct ans Modal -->
        <div class="modal fade" id="correctAns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('Correct Answer')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <p>@lang($details->writtenQuestion->written_ans)</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- card end -->
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.written.pending.all') }}" />
@endpush


@push('style')
    <style>
        @media only screen and (max-width: 767px) {
            .card-footer .btn {
                margin-top: 15px;
            }
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . '/js/axios.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $('.givemark').on('click', function() {
            var thisButton = $(this)
            var id = $(this).data('id')
            var mark = $(this).parents('.parent').find('input[name=mark]').val()
            var route = `{{ route('admin.written.give.mark', '') }}/${id}`
            var data = {
                mark: mark,

            }
            axios.post(route, data, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(function(response) {

                    if (response.data.mark) {
                        $.each(response.data.mark, function(i, val) {
                            notify('error', val);
                        });

                    } else {
                        notify('success', response.data.yes);
                        thisButton.parents('.content').find('.given_mark').text('Given Mark : ' + mark);
                    }
                })
        })
        $('.crrAns').on('click', function() {
            var thisBtn = $(this)
            var id = $(this).data('id');
            var route = `{{ route('admin.written.give.correctans', '') }}/${id}`
            var data = {
                ans: id
            }
            axios.post(route, data, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(function(response) {
                    if (response.data.ans) {
                        $.each(response.data.ans, function(i, val) {
                            notify('error', val);
                        });

                    } else {
                        notify('success', response.data.yes);
                        thisBtn.text('Correct Answer Provided').addClass('btn--secondary').removeClass('crrAns')
                            .attr('disabled', true)

                    }
                })
        })
    </script>
@endpush
