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
                                        <th>@lang('Your Mark')</th>
                                        <th>@lang('Pass Mark')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Details')</th>
                                        <th>@lang('Certificate')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($exams as $exam)
                                        @php
                                            $qCount = $exam->written->where('user_id', auth()->id())->count();
                                            $sCount = $exam->written
                                                ->where('user_id', auth()->id())
                                                ->where('status', 1)
                                                ->count();
                                            $passmark = $exam->passmark();
                                            $getMark = $exam->totalWrittenMark(auth()->id());
                                        @endphp
                                        <tr>
                                            <td>{{ $exam->title }}</td>
                                            <td>{{ $exam->subject->category->name }}</td>
                                            <td>{{ $exam->subject->name }}</td>
                                            <td>
                                                @if ($qCount == $sCount)
                                                    {{ $getMark }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{ $passmark }}</td>
                                            <td>
                                                @if ($qCount > $sCount)
                                                    <span class="badge badge--dark text-white">@lang('PENDING')</span>
                                                @else
                                                    @if ($passmark < $getMark)
                                                        <span
                                                            class="badge badge--success text-white">@lang('PASSED')</span>
                                                    @else
                                                        <span
                                                            class="badge badge--danger text-white">@lang('FAILED')</span>
                                                    @endif
                                                @endif
                                            </td>

                                            @if ($qCount > $sCount)
                                                <td>@lang('N/A')</td>
                                            @else
                                                <td><a class="icon-btn btn--dark"
                                                        href="{{ route('user.exam.written.details', $exam->id) }}">@lang('More info.')</a>
                                                </td>
                                            @endif

                                            <td>
                                                @if ($passmark < $getMark)
                                                    <a target="_blank"
                                                        href="{{ route('user.exam.written.certificate', $exam->id) }}"
                                                        class="btn--primary border--rounded text-white p-2">@lang('View')</a>
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="12">@lang('No result available')</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{ paginateLinks($exams) }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

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
