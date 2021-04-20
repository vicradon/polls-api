<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Poll;
use App\Models\Question;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $polls = [];
        if ($request->user()->is_admin) {
            $polls = Poll::all();
        } else {
            $polls = $request->user()->polls;
        }

        return ['success' => true, 'polls_count' => count($polls), 'data' => $polls];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $user = $request->user();


        $poll = Poll::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        $user->polls()->save($poll);

        return response()->json(['success' => true, 'data' => $poll], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poll = Poll::find($id);
        $questions = Question::where('poll_id', $id)->get();

        foreach ($questions as $question) {
            $choices = Choice::where('question_id', $question->id)->get();
            $question->choices = $choices;
        }

        $poll->questions = $questions;
        return response()->json(['success' => true, 'data' => $poll], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string',
            'description' => 'string',
        ]);

        $poll = Poll::find($id);
        $poll->title = $validatedData['title'] ?? $poll->title;
        $poll->description = $validatedData['description'] ?? $poll->description;

        return response()->json(['success' => true, 'data' => $poll]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Poll::destroy($id);

        return ['success' => true];
    }
}
