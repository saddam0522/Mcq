@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Year')</th>
                                    <th>@lang('Created By')</th>
                                    <th>@lang('Updated By')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questionBanks as $questionBank)
                                    <tr>
                                        <td>{{ $questionBank->name }}</td>
                                        <td>{{ $questionBank->category->name }}</td>
                                        <td>{{ $questionBank->year }}</td>
                                        <td>{{ $questionBank->createdBy->name }}</td>
                                        <td>{{ optional($questionBank->updatedBy)->name }}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-questionbank="{{ $questionBank }}"
                                                data-route="{{ route('admin.questionbank.update', $questionBank->id) }}"
                                                class="btn btn-sm btn-outline--primary edit">
                                                <i class="las la-edit"></i> @lang('Edit')
                                            </a>
                                            <a href="javascript:void(0)" data-route="{{ route('admin.questionbank.delete', $questionBank->id) }}"
                                                class="btn btn-sm btn-outline--danger delete">
                                                <i class="las la-trash"></i> @lang('Delete')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($questionBanks->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($questionBanks) }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.questionbank.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">@lang('Add Question Bank')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Enter name')" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Category')</label>
                                <select class="form-control" name="category_id" required>
                                    <option value="" disabled selected>@lang('Select Category')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Year')</label>
                                <input type="number" class="form-control" name="year" placeholder="@lang('Enter year')">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">@lang('Edit Question Bank')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Enter name')" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Category')</label>
                                <select class="form-control" name="category_id" required>
                                    <option value="" disabled>@lang('Select Category')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Year')</label>
                                <input type="number" class="form-control" name="year" placeholder="@lang('Enter year')">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search by name" />
    <button type="button" class="btn btn-outline--primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush

@push('script')
    <script>
        (function($) {
            'use strict';
            $('.edit').on('click', function() {
                var questionBank = $(this).data('questionbank');
                var route = $(this).data('route');

                $('#editModal').find('input[name=name]').val(questionBank.name);
                $('#editModal').find('select[name=category_id]').val(questionBank.category_id);
                $('#editModal').find('input[name=year]').val(questionBank.year);
                $('#editModal').find('form').attr('action', route);
                $('#editModal').modal('show');
            });

            $('.delete').on('click', function() {
                var route = $(this).data('route');
                if (confirm('@lang("Are you sure you want to delete this question bank?")')) {
                    $.post(route, {_method: 'DELETE', _token: '{{ csrf_token() }}'}, function(response) {
                        location.reload();
                    });
                }
            });
        })(jQuery);
    </script>
@endpush
