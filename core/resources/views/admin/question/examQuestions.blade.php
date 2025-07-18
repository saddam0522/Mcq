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
                                    <th>@lang('Exam')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Ques. & Ans')</th>
                                    <th>@lang('Mark')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($qstns as $qtn)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img
                                                        src="{{ getImage('assets/images/exam/' . $qtn->exam->image) }}"
                                                        alt="image"></div>
                                                <span class="name">{{ $qtn->exam->title }}</span>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge badge-pill {{ $qtn->exam->question_type == 1 ? 'bg--primary' : 'bg--success' }} ">{{ $qtn->exam->question_type == 1 ? 'MCQ' : 'Written' }}</span>
                                        </td>

                                        @if ($exam->question_type == 1)
                                            <td><button type="button" class="btn btn-sm btn-outline--primary mr-2 options"
                                                    data-options="{{ $qtn->options }}" data-qtn="{{ $qtn->question }}"><i
                                                        class="las la-eye"></i>
                                                    @lang('See')</button></td>
                                        @else
                                            <td><button type="button" class="btn btn-sm btn-outline--primary mr-2 ans"
                                                    data-ans="{{ $qtn->written_ans }}" data-qtn="{{ $qtn->question }}"><i
                                                        class="las la-eye"></i>
                                                    @lang('See')</button></td>
                                        @endif

                                        <td><span
                                                class="text--small badge font-weight-normal badge--success">{{ $qtn->marks }}</span>
                                        </td>

                                        <td>
                                            @if ($qtn->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($exam->question_type == 1)
                                                <a href="{{ route('admin.exam.edit.mcq', $qtn->id) }}"
                                                    class="btn btn-sm btn-outline--primary mr-2">
                                                    <i class="las la-edit"></i> @lang('Edit')
                                                </a>
                                            @else
                                                <a href="{{ route('admin.exam.written.edit', $qtn->id) }}"
                                                    class="btn btn-sm btn-outline--primary mr-2 edit">
                                                    <i class="las la-edit"></i> @lang('Edit')
                                                </a>
                                            @endif

                                            <a href="javascript:void(0)"
                                                data-route="{{ route('admin.question.remove', $qtn->id) }}"
                                                class="btn btn-sm btn-outline--danger mr-2 ml-2 delete">
                                                <i class="las la-trash-alt"></i> @lang('Delete')

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($qstns->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($qstns) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>



        <!-- option list Modal -->
        <div class="modal fade" id="optionModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('Question and Answer')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="qtn mb-3 font-weight-bold"></div>
                        <ul class="list-group">
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Answer Modal -->
        <div class="modal fade" id="ansModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('Question and Answer')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="qtn mb-3 font-weight-bold"></div>
                        <p class="answer border p-3"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">@lang('Delete Ques. !')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="modal-body">
                            @lang('Are You Sure Want to Delete This?')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn--dark"
                                data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn--primary del">@lang('Delete')</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('breadcrumb-plugins')


        @if ($exam->question_type == 1)
            <a href="{{ route('admin.exam.add.mcq', $exam->id) }}" class=" btn btn-outline--primary">
                <i class="las la-plus"></i> @lang('Add New')
            </a>
        @else
            <a href="{{ route('admin.exam.question.written', $exam->id) }}" class="btn btn-outline--primary">
                <i class="las la-plus"></i> @lang('Add New')
            </a>
        @endif

        <a href="{{ route('admin.exam.manage.all') }}" class="btn btn-outline--primary">
            <i class="las la-list"></i> @lang('Exam List')
        </a>


    @endpush


    @push('script')
        <script>
            'use strict';
            $('.options').on('click', function() {
                var options = $(this).data('options')
                var qtn = $(this).data('qtn')
                $('#optionModal').find('.list-group').empty()
                $('#optionModal').find('.qtn').empty()
                $.each(options, function(i, val) {
                    var cls = val.correct_ans == 1 ? 'btn--success' : 'btn--danger'
                    var ans = val.correct_ans == 1 ? 'las la-check-circle text--white' :
                        'las la-times-circle text--white'

                    var el =
                        ` <li class="list-group-item d-flex justify-content-between font-weight-bold">${val.option} <span class="icon-btn ${cls}"><i class="${ans}"></i></span></li>`

                    $('#optionModal').find('.list-group').append(el)
                });
                $('#optionModal').find('.qtn').append($.parseHTML(qtn))
                $('#optionModal').modal('show')
            });
            $('.ans').on('click', function() {
                var ans = $(this).data('ans')
                var qtn = $(this).data('qtn')

                $('#ansModal').find('.qtn').html(qtn)
                $('#ansModal').find('.answer').html(ans)

                $('#ansModal').modal('show')
            });

            $('.delete').on('click', function() {
                var route = $(this).data('route')
                var modal = $('#deleteModal');
                modal.find('form').attr('action', route)
                modal.modal('show');


            })
        </script>
    @endpush

    @push('style')
        <style>
            .answer {
                text-align: justify
            }
        </style>
    @endpush
