@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="deposit-area mt-30">
        <div class="panel-card-header bg--primary text-white">
            <div class="panel-card-title d-flex justify-content-between">
                <h5 class="mt-2 text-white">@lang($pageTitle)</h5>
                <a href="{{ route('ticket.index') }}" class="btn--dark border--rounded text-white p-2">
                    @lang('My Support Ticket')
                </a>
            </div>
        </div>
        <div class="panel-card-body">
            <div class="row justify-content-center mb-30-none">

                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body pb-5">

                            <form action="{{ route('ticket.store') }}" class="disableSubmission" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('Subject')</label>
                                        <input type="text" name="subject" value="{{ old('subject') }}" class="form-control form-control-lg" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">@lang('Priority')</label>
                                        <select name="priority" class="form-select form-control-lg select2" data-minimum-results-for-search="-1" required>
                                            <option value="3">@lang('High')</option>
                                            <option value="2">@lang('Medium')</option>
                                            <option value="1">@lang('Low')</option>
                                        </select>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="form-label">@lang('Message')</label>
                                        <textarea name="message" id="inputMessage" rows="6" class="form-control form-control-lg" required>{{ old('message') }}</textarea>
                                    </div>


                                    <div class="col-md-9">
                                        <button type="button" class="btn btn--base btn-sm addAttachment my-2"> <i class="fas fa-plus"></i> @lang('Add Attachment') </button>
                                        <p class="mb-2"><span class="text--info">@lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span></p>
                                        <div class="row fileUploadsContainer">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn--base w-100 my-2" type="submit"><i class="las la-paper-plane"></i> @lang('Submit')
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-4 col-md-12 removeFileInput">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control file-h" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text removeFile bg--danger border--danger file-py"><i class="fas fa-times"></i></button>
                                </div>

                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        .form-control {
            line-height: 1.2 !important
        }

        .file-h {
            line-height: 24px !important
        }

        .input-group-text:focus {
            box-shadow: none !important;
        }

        .input-group-text {
            background-color: red;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            border-color: rgba(0, 0, 0, 0.15) !important;
            padding-top: 9px !important;
            padding-bottom: 9px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            color: rgba(0, 0, 0, 0.541) !important;

        }

        .select2-dropdown {
            border: 1px solid rgba(41, 41, 41, 0.1) !important;
            background-color: #fff !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: rgb(41, 41, 41) !important;
        }

        .select2-results__option {
            color: rgb(41, 41, 41);
            border-color: rgba(41, 41, 41, 0.1);
        }
    </style>
@endpush
