<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['questions'] = Question::paginate(15);

        return view('admin.question.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.question.create', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create([
            'question' => $request->question,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->fields as $key => $value) {
            $ans = new Answer();
            $ans->question_id = $question->id;
            $ans->ans = $value['ans'];
            $ans->date = $value['date'];
            $ans->save();
        }

        return response()->json([
            'message' => 'Question created successfully',
            'success' => true,
            'question' => $question,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $data['question'] = $question;

        return view('admin.question.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
