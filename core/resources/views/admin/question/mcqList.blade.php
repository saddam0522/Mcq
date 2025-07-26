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
                                            @foreach ($question->topics->take(2) as $topic)
                                                <span class="badge badge--primary">{{ $topic->title }}</span>
                                            @endforeach
                                            @if ($question->topics->count() > 2)
                                                <span class="badge badge--secondary">+{{ $question->topics->count() - 2 }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($question->topics->count() > 0)
                                                <span class="badge badge--info">
                                                    {{ $question->topics[0]->chapter ? $question->topics[0]->chapter->name : __('No Chapter') }}
                                                </span>
                                                @if ($question->topics->count() > 1)
                                                    <span class="badge badge--secondary">+{{ $question->topics->count() - 1 }}</span>
                                                @endif
                                            @else
                                                <span class="badge badge--warning">@lang('No Chapter')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($question->questionBanks as $bank)
                                                <span class="badge badge--success">{{ $bank->name }} - {{ $bank->year }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-outline--primary">
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
