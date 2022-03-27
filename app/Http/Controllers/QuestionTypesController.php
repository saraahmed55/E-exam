<?php

namespace App\Http\Controllers;

use App\Models\Question_types;
use Illuminate\Http\Request;

class QuestionTypesController extends Controller
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
        $question_type=new Question_types();
        $question_type->type_name=$request->type_name;
        if($question_type->save()) {
            return ['status'=>'data inserted'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question_types  $question_types
     * @return \Illuminate\Http\Response
     */
    public function show(Question_types $question_types)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question_types  $question_types
     * @return \Illuminate\Http\Response
     */
    public function edit(Question_types $question_types)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question_types  $question_types
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question_types $question_types)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question_types  $question_types
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question_types $question_types)
    {
        //
    }
}
