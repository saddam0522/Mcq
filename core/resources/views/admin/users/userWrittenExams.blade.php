@extends('admin.layouts.app')

@section('panel')

    <div class="row">

        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr class="bg--primary">
                                    <th>@lang('Title')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('User Mark')</th>
                                    <th>@lang('Pass Mark')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($exams as $exam)
                                    @php
                                        $qCount = $exam->written->where('user_id', $userid)->count();
                                        $sCount = $exam->written->where('user_id', $userid)->where('status', 1)->count();
                                        $passmark = $exam->passmark();
                                        $getMark = $exam->totalWrittenMark($userid);
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
                                                <span class="badge badge--warning">@lang('PENDING')</span>
                                            @else
                                                @if ($passmark < $getMark)
                                                    <span class="badge badge--success">@lang('PASSED')</span>
                                                @else
                                                    <span class="badge badge--danger">@lang('FAILED')</span>
                                                @endif
                                            @endif
                                        </td>


                                    </tr>

                                @empty
                                    <tr>
                                        <td class="text-center" colspan="12">@lang('No results available')</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($exams->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($exams) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.users.detail', $userid) }}" />

    <x-search-form placeholder="Search by exam title" />
@endpush
