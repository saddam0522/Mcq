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
                                    <th>@lang('Subject Name')</th>
                                    <th>@lang('Category Name')</th>
                                    <th>@lang('Is Popular')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                    <tr>
                                        <td>{{ __($subject->name) }}</td>

                                        <td>{{ __($subject->category->name??"-") }}</td>
                                        <td>
                                            @if ($subject->is_popular == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Yes')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($subject->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" data-subject="{{ $subject }}"
                                                data-route="{{ route('admin.exam.subject.update', $subject->id) }}"
                                                class="btn btn-sm btn-outline--primary edit">
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
                @if ($subjects->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subjects) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.exam.subject.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Add Subject')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>@lang('Subject Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Subject name')"
                                    required>

                            </div>
                            <div class="form-group">
                                <label>@lang('Short Details')</label>
                                <textarea type="text" class="form-control" name="short_details" placeholder="@lang('Short Details')" required></textarea>

                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Is Popular') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                                    name="is_popular">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <!-- edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Edit Subject')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>@lang('Subject Name')</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="@lang('Subject name')">

                            </div>
                            <div class="form-group">
                                <label>@lang('Short Details')</label>
                                <textarea type="text" class="form-control" name="short_details" placeholder="@lang('Short Details')"></textarea>

                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Is Popular') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Yes')" data-off="@lang('No')"
                                    name="is_popular">
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
    <x-search-form placeholder="Subject name" />

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline--primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush


@push('script')
    <script>
        $(function() {
            'use strict';
            $('.edit').on('click', function() {
                var subject = $(this).data('subject')
                var route = $(this).data('route')

                $('#editModal').find('select[name=category_id]').val(subject.category_id).change()
                $('#editModal').find('input[name=name]').val(subject.name)
                $('#editModal').find('textarea[name=short_details]').val(subject.short_details)
                $('#editModal').find('form').attr('action', route)
                if (subject.status == 1) {
                    $('#editModal').find('input[name=status]').bootstrapToggle('on')
                }
                if (subject.is_popular == 1) {
                    $('#editModal').find('input[name=is_popular]').bootstrapToggle('on')
                }
                $('#editModal').modal('show')

            });
        });
    </script>
@endpush
