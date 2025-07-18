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
                                    <th>@lang('Status')</th>


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
                                                <span class="badge badge--success">@lang('PASSED')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('FAILED')</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="12">@lang('No result available')</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($histories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($histories) }}
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
