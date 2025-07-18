@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive table-responsive--sm">
                        <table class="table align-items-center table--light">
                            <thead>
                                <tr>
                                    <th>@lang('Short Code')</th>
                                    <th>@lang('Description')</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse(@$certificate->shortcodes ?? [] as $shortcode => $key)
                                    <tr>
                                        <th>@php echo "{{ ". $shortcode ." }}"  @endphp</th>
                                        <td>{{ __($key) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header bg--primary">
                    <h5 class="card-title text-white my-1">{{ __($pageTitle) }}</h5>
                </div>
                <form action="{{ route('admin.exam.certificate.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="font-weight-bold">@lang('Message') <span class="text-danger">*</span></label>
                                <textarea name="body" rows="10" class="form-control nicEdit" placeholder="@lang('Your texts using shortcodes')">{{ @$certificate->body }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary w-100 h-45 mt-3">@lang('Submit')</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
