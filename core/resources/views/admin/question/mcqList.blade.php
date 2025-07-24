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
                                    <th>@lang('Question')</th>
                                    <th>@lang('Topics')</th>
                                    <th>@lang('Chapters')</th>
                                    <th>@lang('Question Banks')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questions as $question)
                                    <tr>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            @foreach ($question->topics as $topic)
                                                <span class="badge badge--primary">{{ $topic->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($question->chapters as $chapter)
                                                <span class="badge badge--info">{{ $chapter->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($question->questionBanks as $bank)
                                                <span class="badge badge--success">{{ $bank->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.question.edit.mcq', $question->id) }}" class="btn btn-sm btn-outline--primary">
                                                <i class="las la-edit"></i> @lang('Edit')
                                            </a>
                                            <a href="javascript:void(0)" data-route="{{ route('admin.question.remove', $question->id) }}" class="btn btn-sm btn-outline--danger delete">
                                                <i class="las la-trash"></i> @lang('Delete')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __('No questions found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($questions->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($questions) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';
            $('.delete').on('click', function() {
                var route = $(this).data('route');
                if (confirm('@lang("Are you sure you want to delete this question?")')) {
                    $.post(route, {_method: 'DELETE', _token: '{{ csrf_token() }}'}, function(response) {
                        location.reload();
                    });
                }
            });
        })(jQuery);
    </script>
@endpush
