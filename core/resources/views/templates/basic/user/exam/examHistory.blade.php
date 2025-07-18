@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="transaction-area mt-30">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                <div class="panel-table-area">
                    <div class="panel-table border-0">
                        <div class="panel-card-widget-area pt-0 d-flex flex-wrap align-items-center justify-content-end">

                            <form method="GET">
                                <div class="panel-card-widget-right">
                                    <div class="panel-widget-search-area d-flex flex-wrap align-items-center">
                                        <div class="input-group input--group-search">
                                            <input type="search" name="search" class="form-control"
                                                value="{{ request()->search }}" placeholder="@lang('Exam Title')">
                                            <button class="input-group-text text-white">
                                                <i class="las la-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel-card-body table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr class="bg--primary">
                                        <th>@lang('Title')</th>
                                        <th>@lang('Category')</th>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Details')</th>
                                        <th>@lang('Certificate')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($histories as $history)
                                        <tr>
                                            <td>{{ $history->exam->title }}</td>
                                            <td>{{ $history->exam->subject->category->name }}</td>
                                            <td>{{ $history->exam->subject->name }}</td>
                                            <td>
                                                @if ($history->result_status == 1)
                                                    <span class="badge badge--success text-white">@lang('PASSED')</span>
                                                @else
                                                    <span class="badge badge--danger text-white">@lang('FAILED')</span>
                                                @endif
                                            </td>
                                            <td><button class="icon-btn btn--dark details"
                                                    data-details="{{ $history }}"
                                                    data-tq="{{ $history->exam->questions->count() }}"
                                                    data-exam="{{ $history->exam }}">@lang('More info.')</button></td>
                                            <td>
                                                @if ($history->result_status == 1)
                                                    <a target="_blank"
                                                        href="{{ route('user.exam.mcq.certificate', $history->id) }}"
                                                        class="border--rounded btn--primary px-2 py-1 text-white detailBtn"><i
                                                            class="las la-desktop"></i></a>
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="12">@lang('No results available')</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{ paginateLinks($histories) }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="moreinfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">@lang('More info.')</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="panel-card-body table-responsive">
                        <table class="table  table-striped table-bordered">

                            <tr>
                                <th>@lang('Total Question')</th>
                                <td class="tq"></td>
                            </tr>
                            <tr>
                                <th>@lang('Total Mark')</th>
                                <td class="tm"></td>
                            </tr>
                            <tr>
                                <th>@lang('Pass Mark')</th>
                                <td class="pm"></td>
                            </tr>

                            <tr>
                                <th>@lang('Pass Mark Percentage')</th>
                                <td class="pmp"></td>
                            </tr>
                            <tr>
                                <th>@lang('Negative Marking')</th>
                                <td class="nm"></td>
                            </tr>
                            <tr>
                                <th>@lang('Total Time')</th>
                                <td class="tt"></td>
                            </tr>
                            <tr>
                                <th>@lang('Your mark')</th>
                                <td class="ym"></td>
                            </tr>
                            <tr>
                                <th>@lang('Total Correct Answer')</th>
                                <td class="tca"></td>
                            </tr>

                            <tr>
                                <th>@lang('Total Wrong Answer')</th>
                                <td class="twa"></td>
                            </tr>
                            <tr>
                                <th>@lang('Result')</th>
                                <td class="res"></td>
                            </tr>


                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn--base border--rounded text-white"
                        data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';

        $('.details').on('click', function() {
            var passed = "{{ trans('PASSED') }}"
            var failed = "{{ trans('FAILED') }}"
            var yes = "{{ trans('Yes') }}"
            var no = "{{ trans('No') }}"
            var minutes = "{{ trans('minutes') }}"

            var details = $(this).data('details')
            var exam = $(this).data('exam')
            var tq = $(this).data('tq')
            var pm = (exam.totalmark * exam.pass_percentage) / 100;
            $('.tq').text(tq);
            $('.tm').text(exam.totalmark);
            $('.pm').text(pm);
            $('.ym').text(details.result_mark);
            $('.tca').text(details.total_correct_ans);
            $('.twa').text(details.total_wrong_ans);
            $('.res').text(details.result_status == 1 ? passed : failed);
            $('.pmp').text(exam.pass_percentage);
            $('.nm').text(exam.negative_marking == 1 ? yes : no);
            $('.tt').text(exam.duration + ' ' + minutes);
            $('#moreinfoModal').modal('show')
        });
    </script>
@endpush


@push('style')
    <style>
        input:-webkit-autofill,
        textarea:-webkit-autofill,
        select:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px transparent inset;
            -webkit-text-fill-color: #212529 !important;
            caret-color: #212529;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-transition: background-color 5000s ease-in-out 0s;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
@endpush
