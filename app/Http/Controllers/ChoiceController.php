<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use Illuminate\Http\Request;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $choices = Choice::all();
        return $choices;
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
            'question_id' => 'required|integer',
            'is_correct_choice' =>  'boolean'
        ]);

        $question = Question::find($validatedData['question_id']);

        $choice = Choice::create([
            'title' => $validatedData['title'],
            'is_correct_choice' => $validatedData['is_correct_choice'],
        ]);

        $question->choices()->save($choice);

        return $choice;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $choice = Choice::find($id);
        return $choice;
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
            'title' => 'required|string',
            'is_correct_choice' =>  'boolean'
        ]);

        $choice = Choice::find($id);
        $choice->title = $validatedData['title'];
        $choice->is_correct_choice = $validatedData['is_correct_choice'];

        return $choice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Choice::destroy($id);
    }
}
