@extends('templates.basic.layouts.master')

@section('content')
    <div class="dashboard-area mt-30">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>@lang('Manage Jobs')</h2>
            <div class="d-flex gap-2">
                <form action="{{ route('employer.jobs.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control"
                        placeholder="@lang('Search Jobs')" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary ms-2">@lang('Search')</button>
                </form>
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#addJobModal">
                    <i class="las la-plus"></i> @lang('Add New Post')
                </button>
            </div>
        </div>

        <!-- Job Listing Table -->
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Title')</th>
                            <th>@lang('Category')</th>
                            <th>@lang('Location')</th>
                            <th>@lang('Type')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jobPosts as $job)
                            <tr>
                                <td>{{ $job->id }}</td>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->category->name ?? '-' }}</td>
                                <td>{{ $job->location }}</td>
                                <td>{{ $job->job_type }}</td>
                                <td>
                                    <select class="form-select status-dropdown" data-id="{{ $job->id }}">
                                        <option value="draft" {{ $job->status == 'draft' ? 'selected' : '' }}>@lang('Draft')
                                        </option>
                                        <option value="published" {{ $job->status == 'published' ? 'selected' : '' }}>@lang('Published')
                                        </option>
                                        <option value="unpublished" {{ $job->status == 'unpublished' ? 'selected' : '' }}>@lang('Unpublished')
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" data-job="{{ $job }}"
                                        data-route="{{ route('employer.jobs.update', $job->id) }}"
                                        class="btn btn-sm btn-outline-primary edit">
                                        <i class="las la-edit"></i> @lang('Edit')
                                    </a>
                                    <a href="javascript:void(0)" data-route="{{ route('employer.jobs.delete', $job->id) }}"
                                        class="btn btn-sm btn-outline-danger delete">
                                        <i class="las la-trash"></i> @lang('Delete')
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">@lang('No jobs found.')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $jobPosts->links() }}
            </div>
        </div>

        <!-- Add Job Modal -->
        <div class="modal fade" id="addJobModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('employer.jobs.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('Add Job')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal"><i class="las la-times"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>@lang('Title')</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Category')</label>
                                <select name="job_category_id" id="job_category_id" class="form-control select2" required>
                                    <option value="">@lang('Select Category')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Location')</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Job Type')</label>
                                <select name="job_type" class="form-control" required>
                                    <option value="Full Time">@lang('Full Time')</option>
                                    <option value="Part Time">@lang('Part Time')</option>
                                    <option value="Contract">@lang('Contract')</option>
                                    <option value="Internship">@lang('Internship')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Work Mode')</label>
                                <select name="work_mode" class="form-control" required>
                                    <option value="Office">@lang('Office')</option>
                                    <option value="Remote">@lang('Remote')</option>
                                    <option value="Hybrid">@lang('Hybrid')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Experience Required (Years)')</label>
                                <input type="number" name="experience_required" class="form-control" min="0">
                            </div>
                            <div class="form-group">
                                <label>@lang('Salary')</label>
                                <input type="number" name="salary" class="form-control" min="0">
                            </div>
                            <div class="form-group">
                                <label>@lang('Currency')</label>
                                <input type="text" name="currency" class="form-control" value="BDT" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Published At')</label>
                                <input type="date" name="published_at" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Deadline')</label>
                                <input type="date" name="deadline" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Short Description')</label>
                                <textarea name="short_description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('Full Description')</label>
                                <textarea id="full_description" name="full_description" class="form-control nicEdit" ></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('Skills')</label>
                                <input type="text" name="skills[]" class="form-control"
                                    placeholder="@lang('Comma-separated skills')">
                            </div>
                            <div class="form-group">
                                <label>@lang('Education')</label>
                                <input type="text" name="education" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>@lang('Gender Preference')</label>
                                <input type="text" name="gender_preference" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>@lang('Vacancies')</label>
                                <input type="number" name="vacancies" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Job Modal -->
        <div class="modal fade" id="editJobModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <form method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">@lang('Edit Job')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal"><i class="las la-times"></i></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form fields for editing job -->
                            <div class="form-group">
                                <label>@lang('Title')</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Category')</label>
                                <select name="job_category_id" id="edit_job_category_id" class="form-control select2" required>
                                    <option value="">@lang('Select Category')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Location')</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Job Type')</label>
                                <select name="job_type" class="form-control" required>
                                    <option value="Full Time">@lang('Full Time')</option>
                                    <option value="Part Time">@lang('Part Time')</option>
                                    <option value="Contract">@lang('Contract')</option>
                                    <option value="Internship">@lang('Internship')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Work Mode')</label>
                                <select name="work_mode" class="form-control" required>
                                    <option value="Office">@lang('Office')</option>
                                    <option value="Remote">@lang('Remote')</option>
                                    <option value="Hybrid">@lang('Hybrid')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Experience Required (Years)')</label>
                                <input type="number" name="experience_required" class="form-control" min="0">
                            </div>
                            <div class="form-group">
                                <label>@lang('Salary')</label>
                                <input type="number" name="salary" class="form-control" min="0">
                            </div>
                            <div class="form-group">
                                <label>@lang('Currency')</label>
                                <input type="text" name="currency" class="form-control" value="BDT" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Published At')</label>
                                <input type="date" name="published_at" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Deadline')</label>
                                <input type="date" name="deadline" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Short Description')</label>
                                <textarea name="short_description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('Full Description')</label>
                                <textarea id="edit_full_description" name="full_description" class="form-control nicEdit"></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('Skills')</label>
                                <input type="text" name="skills[]" class="form-control" placeholder="@lang('Comma-separated skills')">
                            </div>
                            <div class="form-group">
                                <label>@lang('Education')</label>
                                <input type="text" name="education" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>@lang('Gender Preference')</label>
                                <input type="text" name="gender_preference" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>@lang('Vacancies')</label>
                                <input type="number" name="vacancies" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">@lang('Update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css" />

    <style>
        .select2-container {
            z-index: 1055; /* Ensure it appears above the modal */
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 8px !important;
        color: #000 !important;
        }
        .nicEdit-main{
            width: 99% !important;
            min-height: 200px !important;
            box-shadow: 0 0 0 2px #007bff !important;
            outline: none !important;
            border: none !important;
        }
    </style>
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize select2 with proper z-index for modal
            $('#job_category_id').select2({
                dropdownParent: $('#addJobModal'),
                width: '100%',
                placeholder: "@lang('Select Category')",
                allowClear: true
            });

            // Populate job categories dynamically
            $.ajax({
                url: "{{ route('employer.job.categories') }}",
                method: "GET",
                success: function (response) {
                    let options = '<option value="">@lang("Select Category")</option>';
                    response.forEach(function (category) {
                        options += `<option value="${category.id}">${category.name}</option>`;
                    });
                    $('#job_category_id').html(options).trigger('change');
                },
                error: function () {
                    alert('@lang("Failed to load job categories.")');
                }
            });

            // Initialize nicEdit
            bkLib.onDomLoaded(function () {
                const editor = new nicEditor({ fullPanel: true }).panelInstance('full_description');
                $('.nicEdit-main').css({ 'width': '100%', 'min-height': '200px' });

                // Synchronize nicEdit content with the hidden textarea before form submission
                $('form').on('submit', function () {
                    $('#full_description').val($('.nicEdit-main').html());
                });
            });

            // Handle status change
            $('.status-dropdown').on('change', function () {
                const jobId = $(this).data('id');
                const status = $(this).val();

                $.ajax({
                    url: "{{ route('employer.jobs.update.status') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: jobId,
                        status: status
                    },
                    success: function (response) {
                        if (response.success) {
                            $.notify("@lang('Status updated successfully.')", "success");
                        } else {
                            toastr.error("@lang('Failed to update status.')");
                        }
                    },
                    error: function () {
                        toastr.error("@lang('Failed to update status.')");
                    }
                });
            });

            // Populate edit modal with job data
            $('.edit').on('click', function () {
                const job = $(this).data('job');
                const route = $(this).data('route');

                $('#editJobModal').find('form').attr('action', route);
                $('#editJobModal').find('input[name=title]').val(job.title);
                $('#editJobModal').find('input[name=location]').val(job.location);
                $('#editJobModal').find('select[name=job_type]').val(job.job_type);
                $('#editJobModal').find('select[name=work_mode]').val(job.work_mode);
                $('#editJobModal').find('input[name=experience_required]').val(job.experience_required);
                $('#editJobModal').find('input[name=salary]').val(job.salary);
                $('#editJobModal').find('input[name=currency]').val(job.currency);
                $('#editJobModal').find('input[name=published_at]').val(job.published_at);
                $('#editJobModal').find('input[name=deadline]').val(job.deadline);
                $('#editJobModal').find('textarea[name=short_description]').val(job.short_description);

                // Populate full description in nicEdit
                const fullDescription = job.full_description || '';
                bkLib.onDomLoaded(function () {
                    const nicEditorInstance = nicEditors.findEditor('edit_full_description');
                    nicEditorInstance.setContent(fullDescription);
                });

                // Handle skills field
                const skills = Array.isArray(job.skills) ? job.skills.join(', ') : job.skills || '';
                $('#editJobModal').find('input[name="skills[]"]').val(skills);

                $('#editJobModal').find('input[name=education]').val(job.education);
                $('#editJobModal').find('input[name=gender_preference]').val(job.gender_preference);
                $('#editJobModal').find('input[name=vacancies]').val(job.vacancies);

                $('#editJobModal').modal('show');
            });

            // Handle delete action
            $('.delete').on('click', function () {
                const route = $(this).data('route');
                if (confirm('@lang("Are you sure you want to delete this job?")')) {
                    $.post(route, { _token: '{{ csrf_token() }}' }, function (response) {
                        location.reload();
                    });
                }
            });
        });
    </script>
@endpush
