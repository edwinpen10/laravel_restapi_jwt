<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{

    public function create(Request $request,$id)
    {
        $this->validate($request,
        [
            'body'=>'required'
        ]);

        $data = $request->user()->comments()->create([

            'body'=>$request->json('body'),
            'tutorial_id'=>$id
        ]);

        return response()->json($data, 200);

    }
}
