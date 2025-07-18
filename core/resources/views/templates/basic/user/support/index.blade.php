@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="transaction-area mt-30">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-12 col-md-12 col-sm-12 mb-30">
                <div class="panel-table-area">
                    <div class="panel-table border-0">
                        <div class="panel-card-widget-area pt-0 d-flex flex-wrap align-items-center justify-content-end">
                            <div class="panel-card-widget-right">
                                <div class="panel-widget-search-area d-flex flex-wrap align-items-center">
                                    <a href="{{ route('ticket.open') }}" class="btn--primary border--rounded text-white p-2"
                                        id="my-addon"> <i class="las la-plus"></i> @lang('Create New')</a>

                                </div>
                            </div>

                        </div>
                        <div class="panel-card-body table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr class="bg--primary">
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Priority')</th>
                                        <th>@lang('Last Reply')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($supports as $key => $support)
                                        <tr>
                                            <td> <a href="{{ route('ticket.view', $support->ticket) }}"
                                                    class="font-weight-bold text--base"> [Ticket#{{ $support->ticket }}]
                                                    {{ __($support->subject) }}
                                                </a></td>
                                            <td>
                                                @php echo $support->statusBadge; @endphp
                                            </td>
                                            <td>
                                                @if ($support->priority == Status::PRIORITY_LOW)
                                                    <span class="badge badge--dark">@lang('Low')</span>
                                                @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                                    <span class="badge  badge--warning">@lang('Medium')</span>
                                                @elseif($support->priority == Status::PRIORITY_HIGH)
                                                    <span class="badge badge--danger">@lang('High')</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                            <td>
                                                <a href="{{ route('ticket.view', $support->ticket) }}" class="icon-btn">
                                                    <i class="fa fa-desktop"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center">
                            {{ $supports->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
