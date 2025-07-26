@extends('admin.layouts.app')

<style>
    select[multiple] {
        min-height: 100px; /* Set a minimum height for multiple select dropdowns */
    }
</style>

@section('panel')
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.question.store') }}" method="POST">
            @csrf

            <!-- Shared Question Assignment Section -->
            <div class="card mb-4">
                <div class="card-body row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Question Type</label>
                            <select class="form-control" name="type" id="questionType" required>
                                <option value="both">Both</option>
                                <option value="question_bank">Question Bank</option>
                                <option value="subjective">Subjective</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 bank-group">
                        <div class="form-group">
                            <label>Question Bank</label>
                            <select class="form-control" name="question_bank_ids[]" multiple>
                                @foreach ($questionBanks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 subject-group">
                        <div class="form-group">
                            <label>Subject</label>
                            <select class="form-control" name="subject_id" id="subjectSelect">
                                <option value="">Select Subject</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 chapter-group">
                        <div class="form-group">
                            <label>Chapter</label>
                            <select class="form-control" name="chapter_id" id="chapterSelect">
                                <option value="">Select Chapter</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 topic-group">
                        <div class="form-group">
                            <label>Topics (Optional)</label>
                            <select class="form-control" name="topic_ids[]" id="topicSelect" multiple>
                                <option value="">Select Topics</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Blocks -->
            <div id="questionContainer">
                <div class="card question-card mb-3" data-index="0">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Question Text</label>
                            <textarea class="form-control" name="questions[0][question_text]" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Options</label>
                            <div class="options-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="questions[0][options][]" placeholder="Option" required>
                                    <button type="button" class="btn btn-danger remove-option">Remove</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary add-option">Add Option</button>
                        </div>

                        <div class="form-group">
                            <label>Correct Answer</label>
                            <select class="form-control correct-answer-select" name="questions[0][correct_answer][]" multiple required>
                                <option value="" disabled>Select Correct Answer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Explanation (Optional)</label>
                            <textarea class="form-control nicEdit" name="questions[0][explanation]"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-danger remove-question" style="display: none;">Remove Question</button>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-success add-question">Add Question</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
(function($){
    'use strict';

    let questionIndex = 1;

    function updateCorrectAnswers(card) {
        let index = card.data('index');
        let select = card.find('.correct-answer-select');
        select.html('<option value="" disabled selected>Select Correct Answer</option>');
        card.find('.options-container input').each(function(i) {
            let val = $(this).val();
            if (val.trim()) {
                select.append(`<option value="${i}">${val}</option>`);
            }
        });
    }

    // Add option (event delegation)
    $(document).on('click', '.add-option', function () {
        const card = $(this).closest('.question-card');
        const index = card.data('index');
        const container = card.find('.options-container');

        const html = `
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="questions[${index}][options][]" placeholder="Option" required>
                <button type="button" class="btn btn-danger remove-option">Remove</button>
            </div>
        `;
        container.append(html);
    });

    // Remove option
    $(document).on('click', '.remove-option', function () {
        const card = $(this).closest('.question-card');
        $(this).closest('.input-group').remove();
        updateCorrectAnswers(card);
    });

    // Update correct answer dropdown
    $(document).on('input', '.options-container input', function () {
        const card = $(this).closest('.question-card');
        updateCorrectAnswers(card);
    });

    // Add new question
    $('.add-question').on('click', function () {
        let base = $('.question-card:first').clone();
        base.attr('data-index', questionIndex);
        base.find('textarea, input').val('');
        base.find('select').val('').trigger('change');
        base.find('.nicEdit-main').html(''); // reset nicEdit content
        base.find('.options-container').html(`
            <div class="input-group mb-2">
                <input type="text" class="form-control" name="questions[${questionIndex}][options][]" placeholder="Option" required>
                <button type="button" class="btn btn-danger remove-option">Remove</button>
            </div>
        `);

        base.find('[name^="questions[0][question_text]"]').attr('name', `questions[${questionIndex}][question_text]`);
        base.find('[name^="questions[0][explanation]"]').attr('name', `questions[${questionIndex}][explanation]`);
        base.find('.correct-answer-select')
            .attr('name', `questions[${questionIndex}][correct_answer][]`)
            .html('<option value="" disabled selected>Select Correct Answer</option>');

        base.find('.remove-question').show();

        $('#questionContainer').append(base);
        questionIndex++;
    });

    // Remove question block
    $(document).on('click', '.remove-question', function () {
        $(this).closest('.question-card').remove();
    });

    // Handle question type toggle
    $('#questionType').on('change', function () {
        const val = $(this).val();
        $('.bank-group, .subject-group, .chapter-group, .topic-group').hide();

        if (val === 'both') {
            $('.bank-group, .subject-group, .chapter-group, .topic-group').show();
        } else if (val === 'question_bank') {
            $('.bank-group').show();
        } else if (val === 'subjective') {
            $('.subject-group, .chapter-group, .topic-group').show();
        }
    }).trigger('change');

    // Load chapters based on subject
    $('#subjectSelect').on('change', function () {
        const subjectId = $(this).val();
        $('#chapterSelect').html('<option value="">Select Chapter</option>');
        $('#topicSelect').html('<option value="">Select Topics</option>');

        if (subjectId) {
            $.get('{{ route("admin.topic.chapterbySubject") }}', { subject_id: subjectId }, function(data) {
                data.forEach(function(chapter) {
                    $('#chapterSelect').append(`<option value="${chapter.id}">${chapter.name}</option>`);
                });
            });
        }
    });

    // Load topics based on chapter
    $('#chapterSelect').on('change', function () {
        const chapterId = $(this).val();
        $('#topicSelect').html('<option value="">Select Topics</option>');

        if (chapterId) {
            $.get('{{ route("admin.topic.getTopicsByChapter") }}', { chapter_id: chapterId }, function(data) {
                data.forEach(function(topic) {
                    $('#topicSelect').append(`<option value="${topic.id}">${topic.title}</option>`);
                });
            });
        }
    });

})(jQuery);
</script>
@endpush
