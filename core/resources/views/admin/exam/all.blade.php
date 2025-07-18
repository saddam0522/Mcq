@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Exam type')</th>
                                    <th>@lang('Pass Percentage')</th>
                                    <th>@lang('Exam Fee')</th>
                                    <th>@lang('More Info.')</th>
                                    <th>@lang('Start Date')</th>
                                    <th>@lang('End Date')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($exams as $exam)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img
                                                        src="{{ getImage('assets/images/exam/' . $exam->image) }}"
                                                        alt="image"></div>
                                                <span class="name">{{ strLimit($exam->title, 20) }}</span>
                                            </div>
                                        </td>
                                        <td><span
                                                class="text--small badge font-weight-normal badge--success">{{ $exam->subject->name }}</span>
                                        </td>
                                        <td><span
                                                class="badge badge-pill {{ $exam->question_type == 1 ? 'bg--primary' : 'bg--success' }} ">{{ $exam->question_type == 1 ? 'MCQ' : 'Written' }}</span>
                                        </td>
                                        <td>{{ $exam->pass_percentage }}%</td>
                                        <td>{{ $exam->exam_fee ?? 'Free' }} {{ $exam->exam_fee ? gs()->cur_text : '' }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline--primary options"
                                                data-options="{{ json_encode($exam) }}">
                                                <i class="las la-eye"></i>
                                                @lang('See')</button>
                                        </td>
                                        <td>{{ $exam->start_date }}</td>
                                        <td>{{ $exam->end_date }}</td>
                                        <td>
                                            @if ($exam->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td data-label="Action">
                                            <a href="{{ route('admin.exam.questions', $exam->id) }}"
                                                class="btn btn-sm btn-outline--primary mr-2">
                                                <i class="las la-question-circle"></i> @lang('Questions')
                                            </a>
                                            <a href="{{ route('admin.exam.manage.edit', $exam->id) }}"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-edit"></i> @lang('Edit')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
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
        <!-- option list Modal -->
        <div class="modal fade" id="optionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title " id="exampleModalLabel">@lang('More Info.')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('breadcrumb-plugins')
        <x-search-form placeholder="Search by title" />

        <!-- Button trigger modal -->
        <a href="{{ route('admin.exam.manage.add') }}" class="btn btn-outline--primary">
            <i class="las la-plus"></i>@lang('Add New')
        </a>
    @endpush
    @push('script')
        <script>
            'use strict';
            $('.options').on('click', function() {
                var val = $(this).data('options')
                $('#optionModal').find('.list-group').empty()
                var el = ` <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Duration')<span class="">${val.duration} @lang('minutes')
                </span></li>
                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Total Mark')<span class="">${val.totalmark}
                </span></li>

                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Negative Marking')<span class="">${val.negative_marking==0?'No':'Yes'}
                </span></li>
                <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Reduce Mark')<span class="">${val.reduce_mark??'N/A'}
                </span></li>
                `
                $('#optionModal').find('.list-group').append(el)
                $('#optionModal').modal('show')
            });
        </script>
    @endpush
