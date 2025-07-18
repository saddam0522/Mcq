<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Category;
use App\Models\Questions;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function allExams(Request $request)
    {
        $pageTitle = 'All exams';
        $exams = Exam::searchable(['title'])->latest()->with('subject')->paginate(getPaginate());


        return view('admin.exam.all', compact('pageTitle', 'exams'));
    }

    public function addExam()
    {
        $pageTitle = 'Add New Exam';
        $subjects = Subject::all();
        $categories = Category::all();
        return view('admin.exam.addExam', compact('pageTitle', 'subjects', 'categories'));
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'subject_id' => 'required|numeric',
                'title'     => 'required',
                'instruction'     => 'required',
                'question_type' => 'required|in:1,2',
                'totalmark'  => 'required|numeric|min:0',
                'pass_percentage' => ' required|min:0',
                'duration' => 'required|numeric|min:1',
                'value' => 'required|in:1,2',
                'start_date' => 'required',
                'end_date' => 'required|after:start_date',
                'exam_fee' => 'required_if:value,1|numeric',
                'reduce_mark' => 'required_with:nag_status|min:0',
            ],
            [
                'reduce_mark.required_with' => 'Reduce mark is required when Negative marking is on',
                'exam_fee.required_if' => 'Exam Fee is required when Payment type is Paid'
            ]
        );

        $exam = new Exam();
        $exam->subject_id = $request->subject_id;
        $exam->title = $request->title;
        $exam->instruction = $request->instruction;
        $exam->question_type = $request->question_type;
        $exam->totalmark =  $request->totalmark;
        $exam->pass_percentage =  $request->pass_percentage;
        $exam->duration =  $request->duration;
        $exam->value =  $request->value;
        $exam->exam_fee =  $request->exam_fee ?? 0;
        $exam->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
        $exam->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');
        $exam->reduce_mark = 0;

        if ($request->hasFile('image')) {
            try {
                $exam->image = fileUploader($request->image, getFilePath('examThumbnail'), getFileSize('examThumbnail'), thumb: getFileThumb('examThumbnail'));
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        if ($request->question_type == 1) {
            $exam->reduce_mark = $request->neg_status ? $request->reduce_mark : 0;
            $exam->negative_marking = $request->neg_status ? 1 : 0;
        }

        $exam->random_question = $request->randomize ? 1 : 0;
        $exam->option_suffle = $request->opt_suffle ? 1 : 0;
        $exam->status = $request->status ? 1 : 0;
        $exam->save();

        $notify[] = ['success', 'Exam created successfully'];
        return back()->withNotify($notify);
    }

    public function editExam($id)
    {
        $pageTitle = 'Edit Exam';
        $subjects = Subject::all();
        $categories = Category::all();
        $exam = Exam::findOrFail($id);
        return view('admin.exam.editExam', compact('pageTitle', 'exam', 'subjects', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'subject_id' => 'required|numeric',
                'title'     => 'required',
                'instruction'     => 'required',
                'question_type' => 'required|in:1,2',
                'totalmark'  => 'required|numeric|min:0',
                'pass_percentage' => ' required|min:0',
                'duration' => 'required|numeric|min:1',
                'value' => 'required|in:1,2',
                'start_date' => 'required',
                'end_date' => 'required|after:start_date',
                'exam_fee' => 'required_if:value,1|numeric',
                'reduce_mark' => 'required_with:nag_status|min:0',
            ],
            [
                'reduce_mark.required_with' => 'Reduce mark is required when Negative marking is on',
                'exam_fee.required_if' => 'Exam Fee is required when Payment type is Paid'
            ]
        );

        $exam = Exam::findOrFail($id);
        $exam->subject_id = $request->subject_id;
        $exam->title = $request->title;
        $exam->instruction = $request->instruction;
        $exam->question_type = $request->question_type;
        $exam->totalmark =  $request->totalmark;
        $exam->pass_percentage =  $request->pass_percentage;
        $exam->duration =  $request->duration;
        $exam->value =  $request->value;
        $exam->exam_fee =  $request->exam_fee;
        $exam->start_date =  Carbon::parse($request->start_date)->format('Y-m-d');
        $exam->end_date =  Carbon::parse($request->end_date)->format('Y-m-d');
        $exam->reduce_mark = 0;

        if ($request->hasFile('image')) {
            try {
                $old = $exam->image ?? null;
                $exam->image = fileUploader($request->image, getFilePath('examThumbnail'), getFileSize('examThumbnail'), $old, getFileThumb('examThumbnail'));
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        if ($request->question_type == 1) {
            $exam->reduce_mark = $request->neg_status ? $request->reduce_mark : 0;
            $exam->negative_marking = $request->neg_status ? 1 : 0;
        }

        $exam->random_question = $request->randomize ? 1 : 0;
        $exam->option_suffle = $request->opt_suffle ? 1 : 0;
        $exam->status = $request->status ? 1 : 0;
        $exam->update();

        $notify[] = ['success', 'Exam Updated successfully'];
        return back()->withNotify($notify);
    }

    public function examQuestions($examid)
    {
        $pageTitle = 'Exam Questions';
        $qstns = Questions::where('exam_id', $examid)->paginate(15);
        $exam = Exam::findOrFail($examid);
        return view('admin.question.examQuestions', compact('pageTitle', 'qstns',  'exam'));
    }

    public function certificate()
    {
        $pageTitle = "Exam Certificate template";
        $certificate = Certificate::first();
        return view('admin.exam.certificate', compact('pageTitle', 'certificate'));
    }
    public function certificateUpdate(Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);
        $certificate = Certificate::first();
        $certificate->body = $request->body;
        $certificate->update();
        $notify[] = ['success', 'Certificate updated successfully'];
        return back()->withNotify($notify);
    }
}
