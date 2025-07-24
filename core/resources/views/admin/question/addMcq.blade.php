@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <!-- Left Column: Question Form -->
        <div class="col-md-8">
            <form action="{{ route('admin.question.store') }}" method="POST" id="questionForm">
                @csrf
                <div id="questionContainer">
                    <div class="card question-card mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <label>@lang('Question Type')</label>
                                <select class="form-control question-type" name="questions[0][type]" required>
                                    <option value="both">@lang('Both')</option>
                                    <option value="question_bank">@lang('Question Bank')</option>
                                    <option value="subjective">@lang('Subjective')</option>
                                </select>
                            </div>
                            <div class="form-group question-bank-group">
                                <label>@lang('Question Bank')</label>
                                <select class="form-control" name="questions[0][question_bank_ids][]" multiple>
                                    @foreach ($questionBanks as $questionBank)
                                        <option value="{{ $questionBank->id }}">{{ $questionBank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group subject-group">
                                <label>@lang('Subject')</label>
                                <select class="form-control subject-select" name="questions[0][subject_id]">
                                    <option value="" disabled selected>@lang('Select Subject')</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group chapter-group">
                                <label>@lang('Chapter')</label>
                                <select class="form-control chapter-select" name="questions[0][chapter_id]">
                                    <option value="" disabled selected>@lang('Select Chapter')</option>
                                </select>
                            </div>
                            <div class="form-group topic-group">
                                <label>@lang('Topic')</label>
                                <select class="form-control" name="questions[0][topic_ids][]" multiple>
                                    <option value="" disabled>@lang('Select Topic')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Question Text')</label>
                                <textarea class="form-control" name="questions[0][question_text]" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>@lang('Options')</label>
                                <div class="options-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="questions[0][options][]" placeholder="@lang('Option')" required>
                                        <button type="button" class="btn btn-danger remove-option">@lang('Remove')</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary add-option">@lang('Add Option')</button>
                            </div>
                            <div class="form-group">
                                <label>@lang('Correct Answer')</label>
                                <select class="form-control" name="questions[0][correct_answer]" required>
                                    <option value="" disabled selected>@lang('Select Correct Answer')</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Explanation')</label>
                                <textarea class="form-control nicEdit" name="questions[0][explanation]"></textarea>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-danger remove-question">@lang('Remove Question')</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-question">@lang('Add Question')</button>
                <button type="submit" class="btn btn-primary">@lang('Submit')</button>
            </form>
        </div>

        <!-- Right Column: Search Similar Questions -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('Similar Questions')</h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" id="searchQuestion" placeholder="@lang('Search Question')">
                    <ul class="list-group mt-3" id="similarQuestionsList">
                        <!-- Similar questions will be dynamically populated here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    (function($) {
        'use strict';

        let questionIndex = 1;

        // Add new question block
        $('.add-question').on('click', function() {
            let newQuestion = $('.question-card:first').clone();
            newQuestion.find('textarea, input').val('');
            newQuestion.find('select').val('').trigger('change');
            newQuestion.find('.options-container').html(`
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="questions[${questionIndex}][options][]" placeholder="@lang('Option')" required>
                    <button type="button" class="btn btn-danger remove-option">@lang('Remove')</button>
                </div>
            `);
            newQuestion.find('.remove-question').show();
            newQuestion.find('.nicEdit').removeClass('nicEdit').addClass('nicEdit-clone');
            newQuestion.appendTo('#questionContainer');
            questionIndex++;
        });

        // Remove question block
        $(document).on('click', '.remove-question', function() {
            $(this).closest('.question-card').remove();
        });

        // Add new option
        $(document).on('click', '.add-option', function() {
            let optionsContainer = $(this).siblings('.options-container');
            let optionIndex = optionsContainer.find('.input-group').length;
            optionsContainer.append(`
                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="questions[${optionIndex}][options][]" placeholder="@lang('Option')" required>
                    <button type="button" class="btn btn-danger remove-option">@lang('Remove')</button>
                </div>
            `);
        });

        // Remove option
        $(document).on('click', '.remove-option', function() {
            $(this).closest('.input-group').remove();
        });

        // Handle question type visibility
        $(document).on('change', '.question-type', function() {
            let type = $(this).val();
            let questionCard = $(this).closest('.question-card');
            let questionBankGroup = questionCard.find('.question-bank-group');
            let subjectGroup = questionCard.find('.subject-group');
            let chapterGroup = questionCard.find('.chapter-group');
            let topicGroup = questionCard.find('.topic-group');

            if (type === 'both') {
                questionBankGroup.show();
                subjectGroup.show();
                chapterGroup.show();
                topicGroup.show();
                subjectGroup.find('select').prop('required', true);
                chapterGroup.find('select').prop('required', true);
            } else if (type === 'question_bank') {
                questionBankGroup.show();
                subjectGroup.hide();
                chapterGroup.hide();
                topicGroup.hide();
                subjectGroup.find('select').prop('required', false);
                chapterGroup.find('select').prop('required', false);
            } else if (type === 'subjective') {
                questionBankGroup.hide();
                subjectGroup.show();
                chapterGroup.show();
                topicGroup.show();
                subjectGroup.find('select').prop('required', true);
                chapterGroup.find('select').prop('required', true);
            }
        }).trigger('change');

        // Handle dependent dropdowns
        $(document).on('change', '.subject-select', function() {
            let subjectId = $(this).val();
            let chapterSelect = $(this).closest('.question-card').find('.chapter-select');
            let topicSelect = $(this).closest('.question-card').find('.topic-group select');
            chapterSelect.html('<option value="" disabled selected>@lang("Select Chapter")</option>');
            topicSelect.html('<option value="" disabled>@lang("Select Topic")</option>');
            if (subjectId) {
                $.get('{{ route("admin.topic.chapterbySubject") }}', { subject_id: subjectId }, function(data) {
                    if (Array.isArray(data)) {
                        data.forEach(chapter => {
                            chapterSelect.append(`<option value="${chapter.id}">${chapter.name}</option>`);
                        });
                    } else {
                        console.error('Invalid data format for chapters:', data);
                    }
                }).fail(function() {
                    console.error('Failed to fetch chapters for subject ID:', subjectId);
                });
            }
        });

        $(document).on('change', '.chapter-select', function() {
            let chapterId = $(this).val();
            let topicSelect = $(this).closest('.question-card').find('.topic-group select');
            topicSelect.html('<option value="" disabled>@lang("Select Topic")</option>');
            if (chapterId) {
                $.get('{{ route("admin.topic.getTopicsByChapter") }}', { chapter_id: chapterId }, function(data) {
                    if (Array.isArray(data)) {
                        data.forEach(topic => {
                            topicSelect.append(`<option value="${topic.id}">${topic.title}</option>`);
                        });
                    } else {
                        console.error('Invalid data format for topics:', data);
                    }
                }).fail(function() {
                    console.error('Failed to fetch topics for chapter ID:', chapterId);
                });
            }
        });

        // Search similar questions
        $('#searchQuestion').on('input', function() {
            let query = $(this).val();
            if (query.length > 2) {
                $.get('{{ route("admin.question.search") }}', { query: query }, function(data) {
                    let list = $('#similarQuestionsList');
                    list.empty();
                    if (Array.isArray(data)) {
                        data.forEach(question => {
                            list.append(`<li class="list-group-item">${question.question_text}</li>`);
                        });
                    }
                });
            }
        });

    })(jQuery);
</script>
@endpush
