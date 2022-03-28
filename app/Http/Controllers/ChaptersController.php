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

    public function edit(Chapters $chapters)
    {
        //
    }

    public function update(Request $request, Chapters $chapters)
    {
        //
    }

    public function destroy(Chapters $chapters)
    {
        //
    }
}
