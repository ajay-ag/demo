<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        $data['categories'] = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        return view('admin.question.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create([
            'question' => $request->question,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
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
            'back' => route('question.index'),
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
        $data['question'] = $question->load('category', 'answer');
        $data['categories'] = Cache::remember('categories', 3600, function () {
            return Category::all();
        });

        return view('admin.question.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->question = $request->question;
        $question->category_id = $request->category_id;
        $question->save();

        //check Array is empty then delete all
        if (count($request->fields) === 0) {

            $question->answer()->delete();

            return response()->json([
                'message' => 'Question updated successfully',
                'success' => true,
                'question' => $question,
                'back' => route('question.index'),
            ]);

        }

        //remove all record and update all record that have id and create
        $toDeleteId = collect($question->fields)->whereNotNull('id')->all();
        $delete = collect($question->answer()->pluck('id'))->whereNotIn('id', $toDeleteId)->all();
        $question->answer()->whereIn('id', $delete)->delete();
        foreach ($request->fields as $key => $value) {
            Answer::updateOrCreate(['id' => $value['id'] ?? 0], [
                'ans' => $value['ans'],
                'date' => $value['date'],
                'question_id' => $question->id,
            ]);
        }

        return response()->json([
            'message' => 'Question updated successfully',
            'success' => true,
            'question' => $question,
            'back' => route('question.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
