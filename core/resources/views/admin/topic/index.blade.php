@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <select id="chapterFilter" class="form-control select2">
                                <option value="">@lang('All Chapters')</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 text-end">
                            <button type="button" class="btn btn-outline--primary" data-bs-toggle="modal" data-bs-target="#topicModal">
                                <i class="las la-plus"></i> @lang('Add New Topic')
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Topic Title')</th>
                                    <th>@lang('Chapter')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topics as $topic)
                                    <tr>
                                        <td>{{ __($topic->title) }}</td>
                                        <td>{{ __($topic->chapter->name ?? '-') }}</td>
                                        <td>
                                            @if ($topic->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" data-topic="{{ $topic }}"
                                                data-route="{{ route('admin.topic.update', $topic->id) }}"
                                                class="btn btn-sm btn-outline--primary edit">
                                                <i class="las la-edit"></i> @lang('Edit')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">@lang('No Topics Found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($topics->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($topics) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="topicModal" tabindex="-1" role="dialog" aria-labelledby="topicModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('admin.topic.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topicModalLabel">@lang('Add Topic')</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Chapter')</label>
                            <select name="chapter_id" class="form-control select2" required>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Topic Title')</label>
                            <input type="text" name="title" class="form-control" placeholder="@lang('Topic Title')" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Content')</label>
                            <textarea name="content" class="form-control" placeholder="@lang('Content')"></textarea>
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

            $('#chapterFilter').on('change', function() {
                let chapterId = $(this).val();
                let url = '{{ route('admin.topic.index') }}';
                if (chapterId) {
                    url += '?chapter_id=' + chapterId;
                }
                window.location.href = url;
            });

            $('.edit').on('click', function() {
                let topic = $(this).data('topic');
                let route = $(this).data('route');

                $('#topicModal').find('select[name=chapter_id]').val(topic.chapter_id).change();
                $('#topicModal').find('input[name=title]').val(topic.title);
                $('#topicModal').find('textarea[name=content]').val(topic.content);
                $('#topicModal').find('input[name=banner]').val(topic.banner);
                $('#topicModal').find('form').attr('action', route);

                if (topic.status == 1) {
                    $('#topicModal').find('input[name=status]').bootstrapToggle('on');
                } else {
                    $('#topicModal').find('input[name=status]').bootstrapToggle('off');
                }

                $('#topicModalLabel').text('@lang("Edit Topic")');
                $('#topicModal').modal('show');
            });
        });
    </script>
@endpush
