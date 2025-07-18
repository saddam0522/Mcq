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
                                    <th>@lang('Exam Title')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Question')</th>
                                    <th>@lang('User Name')</th>
                                    <th>@lang('Submitted At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendings as $pending)
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb"><img
                                                        src="{{ getImage('assets/images/exam/' . $pending->exam->image) }}"
                                                        alt="image"></div>
                                                <span class="name">{{ $pending->exam->title }}</span>
                                            </div>
                                        </td>
                                        <td><span
                                                class="text--small badge font-weight-normal badge--success">{{ $pending->exam->subject->name }}</span>
                                        </td>
                                        <td>@lang($pending->writtenQuestion->question)</td>
                                        <td><a
                                                href="{{ route('admin.users.detail', $pending->user_id) }}">{{ $pending->user->username }}</a>
                                        </td>
                                        <td>{{ showDateTime($pending->created_at, 'd M Y') }}</td>

                                        <td>
                                            <a href="{{ route('admin.written.details', [$pending->user_id, $pending->question_id]) }}"
                                                class="icon-btn">
                                                <i class="las la-desktop text--shadow"></i>
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
                @if ($pendings->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($pendings) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection



@push('breadcrumb-plugins')
    <x-search-form placeholder="Exam,Question, User" />
@endpush
