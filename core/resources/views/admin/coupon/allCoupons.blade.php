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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Coupon Code')</th>
                                    <th>@lang('Minimum Order')</th>
                                    <th>@lang('Total Limit')</th>
                                    <th>@lang('Per User Limit')</th>
                                    <th>@lang('Start Date')</th>
                                    <th>@lang('End Date')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Expiry')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->name }}</td>
                                        <td><span
                                                class="text--small badge font-weight-normal badge--success">{{ getAmount($coupon->coupon_amount) }}{{ $coupon->amount_type == 1 ? '%' : gs()->cur_text }}</span>
                                        </td>
                                        <td class="font-weight-bold">{{ $coupon->coupon_code }}</td>
                                        <td><span class="badge badge-pill bg--primary">{{ gs()->cur_sym }}
                                                {{ getAmount($coupon->min_order_amount) }} </span></td>
                                        <td>{{ $coupon->use_limit }}</td>
                                        <td>{{ $coupon->usage_per_user }}</td>
                                        <td>{{ $coupon->start_date }}</td>
                                        <td>{{ $coupon->end_date }}</td>
                                        <td>
                                            @if ($coupon->status == 1)
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Active')</span>
                                            @else
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (
                                                $coupon->start_date < \Carbon\Carbon::now()->toDateString() &&
                                                    $coupon->end_date > \Carbon\Carbon::now()->toDateString())
                                                <span
                                                    class="text--small badge font-weight-normal badge--success">@lang('Running')</span>
                                            @elseif($coupon->start_date > \Carbon\Carbon::now()->toDateString())
                                                <span
                                                    class="text--small badge font-weight-normal badge--primary">@lang('Upcoming')</span>
                                            @elseif($coupon->end_date < \Carbon\Carbon::now()->toDateString())
                                                <span
                                                    class="text--small badge font-weight-normal badge--warning">@lang('Expired')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.coupon.edit', $coupon->id) }}"
                                                class="btn btn-sm btn-outline--primary" data-original-title="">
                                                <i class="las la-edit"></i>
                                                @lang('Edit')
                                            </a>
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
                @if ($coupons->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($coupons) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>


    </div>
@endsection



@push('breadcrumb-plugins')
    <a href="{{ route('admin.coupon.add') }}" class="btn btn-outline--primary">
        <i class="las la-plus"></i>
        @lang('Add New')
    </a>
@endpush
