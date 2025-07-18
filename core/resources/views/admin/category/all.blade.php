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
                                    <th>@lang('Category Name')</th>
                                    <th>@lang('Slug')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>

                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            @if ($category->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" data-category="{{ $category }}"
                                                data-route="{{ route('admin.exam.categories.update', $category->id) }}"
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
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>


        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('admin.exam.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('Add Category')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>@lang('Category Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Category name')">

                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status">
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
                        <div class="modal-header ">
                            <h5 class="modal-title " id="exampleModalLabel">@lang('Edit Category')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="las la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>@lang('Category Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Category name')">

                            </div>

                            <div class="form-group">
                                <label class="form-control-label font-weight-bold">@lang('Status') </label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')"
                                    name="status">
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

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline--primary" data-bs-toggle="modal" data-bs-target="#addModal">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
@endpush


@push('script')
    <script>
        (function($) {
            'use strict';
            $('.edit').on('click', function() {
                var category = $(this).data('category')
                var route = $(this).data('route')

                $('#editModal').find('input[name=name]').val(category.name)
                $('#editModal').find('form').attr('action', route)
                if (category.status == 1) {
                    $('#editModal').find('input[name=status]').bootstrapToggle('on')
                }
                $('#editModal').modal('show')

            });
        })(jQuery);
    </script>
@endpush
