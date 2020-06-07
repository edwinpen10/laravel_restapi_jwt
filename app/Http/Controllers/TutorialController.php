<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorial;
use Illuminate\Support\Str;

class TutorialController extends Controller
{
    public function index()
    {
        return Tutorial::all();
    }

    public function show($id)
    {
        $tutorial=Tutorial::with('comments')->where('id',$id)->get();

        if(!$tutorial){
            return response()->json([
                'error'=>'data not found'
            ],400);
        }
        else {
            return $tutorial;
        }
    }
    public function create(Request $request)
    {
        $this->validate($request,
        [
            'title'=>'required',
            'body'=>'required'
        ]);

        $data =  $request->user()->tutorial()->create([

            'title'=>$request->json('title'),
            'slug'=>Str::slug($request->json('title')),
            'body'=>$request->json('body')
        ]);

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,
        [
            'title'=>'required',
            'body'=>'required'
        ]);

        $tutorial= Tutorial::find($id);

        if($request->user()->id!=$tutorial->user_id){
            return response()->json(['error'=>'anda tidak memiliki akses untuk mengubah content ini'],403);
        }

        $tutorial->title = $request->json('title');
        $tutorial->slug = Str::slug($request->json('title'));
        $tutorial->body = $request->json('body');

        $tutorial->save();

        return $tutorial;
    }

    public function delete(Request $request, $id)
    {
        $tutorial= Tutorial::find($id);

        if($request->user()->id!=$tutorial->user_id){
            return response()->json(['error'=>'anda tidak memiliki akses untuk menghapus content ini'],403);
        }

        $tutorial->delete();

        return response()->json(['success'=>'true','message'=>'data berhasil dihapus', 'data' => $tutorial->title],200);
    }
}
