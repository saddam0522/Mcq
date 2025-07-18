@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="transaction-area mt-30">

        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                <div class="panel-table-area">
                    <div class="panel-table border-0">
                        <div class="pt-0 d-flex flex-wrap align-items-center justify-content-end">
                            <div class="col-md-12">
                                <div class="show-filter mb-3 text-end">
                                    <button type="button" class="btn btn--base showFilterBtn btn-sm"><i
                                            class="las la-filter"></i> @lang('Filter')</button>
                                </div>
                                <div class="card responsive-filter-card mb-4">
                                    <div class="card-body">
                                        <form>
                                            <div class="d-flex flex-wrap gap-4">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">@lang('Transaction Number')</label>
                                                    <input type="search" name="search" value="{{ request()->search }}"
                                                        class="form-control form--control">
                                                </div>
                                                <div class="flex-grow-1 select2-parent">
                                                    <label class="form-label d-block">@lang('Type')</label>
                                                    <select name="trx_type" class="form-select form--control select2"
                                                        data-minimum-results-for-search="-1">
                                                        <option value="">@lang('All')</option>
                                                        <option value="+" @selected(request()->trx_type == '+')>
                                                            @lang('Plus')</option>
                                                        <option value="-" @selected(request()->trx_type == '-')>
                                                            @lang('Minus')</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1 select2-parent">
                                                    <label class="form-label d-block">@lang('Remark')</label>
                                                    <select class="form-select form--control select2"
                                                        data-minimum-results-for-search="-1" name="remark">
                                                        <option value="">@lang('All')</option>
                                                        @foreach ($remarks as $remark)
                                                            <option value="{{ $remark->remark }}"
                                                                @selected(request()->remark == $remark->remark)>
                                                                {{ __(keyToTitle($remark->remark)) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1 align-self-end">
                                                    <button class="submit-btn mb-1"><i class="las la-filter"></i>
                                                        @lang('Filter')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-card-body table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>@lang('Trx')</th>
                                        <th>@lang('Transacted')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Post Balance')</th>
                                        <th>@lang('Detail')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $trx)
                                        <tr>
                                            <td>
                                                <strong>{{ $trx->trx }}</strong>
                                            </td>

                                            <td>
                                                {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                            </td>

                                            <td>
                                                <span
                                                    class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                                    {{ $trx->trx_type }} {{ showAmount($trx->amount) }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ showAmount($trx->post_balance) }}
                                            </td>


                                            <td>{{ __($trx->details) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($transactions->hasPages())
                            <div class="card-footer">
                                {{ paginateLinks($transactions) }}
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            border-color: rgba(0, 0, 0, 0.15) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            color: rgba(0, 0, 0, 0.541) !important;

        }

        .select2-dropdown {
            border: 1px solid rgba(41, 41, 41, 0.1) !important;
            background-color: #fff !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: rgb(41, 41, 41) !important;
        }

        .select2-results__option {
            color: rgb(41, 41, 41);
            border-color: rgba(41, 41, 41, 0.1);
        }
    </style>
@endpush

@push('script')
    <script>
        'use strict'

        $(".showFilterBtn").on("click", function() {
            $(".responsive-filter-card").slideToggle();
        });
    </script>
@endpush
