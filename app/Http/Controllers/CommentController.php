<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
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

        try {
            $validator = validator::make(
                $request->all(),
                ['comment' => 'required'],
                ['comment.required' => '您沒有填寫留言內容喔~']
            );

            if ($validator->fails()) {
                $error = $validator->errors()->first();

                $message = $error;
                session()->flash('message', $message);
                return redirect()->back();
            }

            $comment->user_id       = $request->user_id;
            $comment->article_id    = $request->article_id;
            $comment->name          = $request->name;
            $comment->comment       = $request->comment;
            $comment->created_at    = $dateTimeStr;
            $comment->updated_at    = $dateTimeStr;

            $comment->save();

            session()->flash('message', '留言成功');
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

        try {
            $validator = validator::make(
                $request->all(),
                ['comment' => 'required'],
                ['comment.required' => '您沒有填寫留言內容喔~']
            );

            if ($validator->fails()) {
                $error = $validator->errors()->first();

                $message = $error;
                session()->flash('message', $message);
                return redirect()->back();
            }
            
            $comment->comment       = $request->comment;
            $comment->updated_at    = $dateTimeStr;

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
