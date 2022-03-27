<?php

namespace App\Http\Controllers;

use App\Models\Question_difficulty;
use Illuminate\Http\Request;

class QuestionDifficultyController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $questionDiffculty=new Question_difficulty();
        $questionDiffculty->name=$request->name;
        $questionDiffculty->difficulty=$request->difficulty;
        if($questionDiffculty->save()) {
            return ['status'=>'data inserted'];
        }
    }

    public function show(Question_difficulty $question_difficulty)
    {
        //
    }

    public function edit(Question_difficulty $question_difficulty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question_difficulty  $question_difficulty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question_difficulty $question_difficulty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question_difficulty  $question_difficulty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question_difficulty $question_difficulty)
    {
        //
    }
}
