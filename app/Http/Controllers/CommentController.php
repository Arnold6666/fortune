<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $comment = new Comment;

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        $comment->user_id       = $request->user_id;
        $comment->article_id    = $request->article_id;
        $comment->name          = $request->name;
        $comment->comment       = $request->comment;
        $comment->created_at    = $dateTimeStr;
        $comment->updated_at    = $dateTimeStr;

        try {
            $comment->save();

            session()->flash('message', '新增成功');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $comment        = Comment::where('id', $request->id)->first();

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        $comment->comment       = $request->comment;
        $comment->updated_at    = $dateTimeStr;

        try {
            $comment->save();

            session()->flash('message', '修改成功');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $article = Comment::find($id);

        if ($article) {
            $article->delete();
            session()->flash('message', '刪除成功');
            return redirect()->back();
        } else {
            return "刪除失敗";
        }
    }
}
