@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <select id="subjectFilter" class="form-control select2">
                                <option value="">@lang('All Subjects')</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 text-end">
                            <button type="button" class="btn btn-outline--primary" data-bs-toggle="modal" data-bs-target="#chapterModal">
                                <i class="las la-plus"></i> @lang('Add New Chapter')
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Chapter Name')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($chapters as $chapter)
                                    <tr>
                                        <td>{{ __($chapter->name) }}</td>
                                        <td>{{ __($chapter->subject->name ?? '-') }}</td>
                                        <td>
                                            @if ($chapter->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" data-chapter="{{ $chapter }}"
                                                data-route="{{ route('admin.chapter.update', $chapter->id) }}"
                                                class="btn btn-sm btn-outline--primary edit">
                                                <i class="las la-edit"></i> @lang('Edit')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">@lang('No Chapters Found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($chapters->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($chapters) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="chapterModal" tabindex="-1" role="dialog" aria-labelledby="chapterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('admin.chapter.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chapterModalLabel">@lang('Add Chapter')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Subject')</label>
                            <select name="subject_id" class="form-control select2" required>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Chapter Name')</label>
                            <input type="text" name="name" class="form-control" placeholder="@lang('Chapter Name')" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Slug')</label>
                            <input type="text" name="slug" class="form-control" placeholder="@lang('Slug')">
                        </div>
                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea name="description" class="form-control" placeholder="@lang('Description')"></textarea>
                        </div>
                        <div class="form-group">
                            <label>@lang('Banner')</label>
                            <input type="text" name="banner" class="form-control" placeholder="@lang('Banner URL')">
                        </div>
                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <input type="checkbox" name="status" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                data-bs-toggle="toggle" data-on="@lang('Active')" data-off="@lang('Inactive')">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100">@lang('Submit')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            'use strict';

            $('#subjectFilter').on('change', function() {
                let subjectId = $(this).val();
                let url = '{{ route('admin.chapter.index') }}';
                if (subjectId) {
                    url += '?subject_id=' + subjectId;
                }
                window.location.href = url;
            });

            $('.edit').on('click', function() {
                let chapter = $(this).data('chapter');
                let route = $(this).data('route');

                $('#chapterModal').find('select[name=subject_id]').val(chapter.subject_id).change();
                $('#chapterModal').find('input[name=name]').val(chapter.name);
                $('#chapterModal').find('input[name=slug]').val(chapter.slug);
                $('#chapterModal').find('textarea[name=description]').val(chapter.description);
                $('#chapterModal').find('input[name=banner]').val(chapter.banner);
                $('#chapterModal').find('form').attr('action', route);

                if (chapter.status == 1) {
                    $('#chapterModal').find('input[name=status]').bootstrapToggle('on');
                } else {
                    $('#chapterModal').find('input[name=status]').bootstrapToggle('off');
                }

                $('#chapterModalLabel').text('@lang("Edit Chapter")');
                $('#chapterModal').modal('show');
            });
        });
    </script>
@endpush
