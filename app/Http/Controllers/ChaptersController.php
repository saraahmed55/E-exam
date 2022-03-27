<?php

namespace App\Http\Controllers;

use App\Models\Chapters;
use Illuminate\Http\Request;

class ChaptersController extends Controller
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
        $chapter=new Chapters();
        $chapter->chapter_number=$request->chapter_number;
        $chapter->chapter_name=$request->chapter_name;
        $chapter->subject_id=$request->subject_id;
        if($chapter->save()) {
            return ['status'=>'data inserted'];
        }
    }


    public function show(Chapters $chapters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chapters  $chapters
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapters $chapters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chapters  $chapters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapters $chapters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chapters  $chapters
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapters $chapters)
    {
        //
    }
}
