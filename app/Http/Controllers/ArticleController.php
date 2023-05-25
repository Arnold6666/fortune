<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_hashtag;
use App\Models\Comment;
use App\Models\Hashtag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $articles = Article::with('hashtags')->orderBy('updated_at', 'desc')->get();

        return view('index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hashtags = Hashtag::all();
        return view('create', compact('hashtags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $article = new Article;

        $hashtags = $request->hashtag_id;

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        try {
            $validator = validator::make(
                $request->all(),
                [
                    'title'     => 'required',
                    'content'   => 'required',
                    'image'     => 'required',
                ],
                [
                    'title.required'   => '請填寫標題',
                    'content.required' => '請填寫內容',
                    'image.required'   => '請選擇圖片',
                ]
            );
            $errors = $validator->errors()->all();

            $message = "";

            for ($i = 0; $i < count($errors); $i++) {
                if ($i === count($errors) - 1) {
                    $message = $message . $errors[$i];
                    continue;
                }
                $message = $message . $errors[$i] . '，';
            }

            if ($validator->fails()) {
                session()->flash('message', $message);
                return redirect()->back();
            }

            $article->name           = Auth::user()->name;
            $article->user_id        = Auth::id();
            $article->title          = $request->title;
            $article->content        = $request->content;
            $article->created_at     = $dateTimeStr;
            $article->updated_at     = $dateTimeStr;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('public/articles');
                $article->image_path = Storage::url($imagePath);
                $article->image_filename = $image->getClientOriginalName();
            }

            $article->save();

            $articleId = $article->id;

            foreach ($hashtags as $hashtag_id) {
                $article_hashtag = new Article_hashtag;
                $article_hashtag->article_id = $articleId;
                $article_hashtag->hashtag_id = $hashtag_id;

                $article_hashtag->save();
            }

            session()->flash('message', '新增成功');
            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::with('hashtags')->find($id);
        $article->views += 1;
        $article->save();

        $comments = Comment::where('article_id', $id)->get();

        return view('article', compact('article'), compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::with('hashtags')->where('id', $id)->first();
        $hashtags = Hashtag::all();

        return view('edit', compact('article'), compact('hashtags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //

        $article = Article::where('id', $request->id)->first();

        $hashtags = $request->hashtag_id;

        Article_hashtag::where('article_id', $request->id)->delete();

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        try {

            $validator = validator::make(
                $request->all(),
                [
                    'title'     => 'required',
                    'content'   => 'required',
                ],
                [
                    'title.required'   => '請填寫標題',
                    'content.required' => '請填寫內容',
                ]
            );
            $errors = $validator->errors()->all();

            $message = "";

            for ($i = 0; $i < count($errors); $i++) {
                if ($i === count($errors) - 1) {
                    $message = $message . $errors[$i];
                    continue;
                }
                $message = $message . $errors[$i] . '，';
            }

            if ($validator->fails()) {
                session()->flash('message', $message);
                return redirect()->back();
            }

            if ($request->hasFile('image')) {
                Storage::disk('public')->delete(substr($article->image_path, 9));
                $image = $request->file('image');
                $imagePath = $image->store('public/articles');
                $article->image_path = Storage::url($imagePath);
                $article->image_filename = $image->getClientOriginalName();
            }

            $article->title          = $request->title;
            $article->content        = $request->content;
            $article->updated_at     = $dateTimeStr;

            $article->save();

            if ($hashtags !== null) {
                foreach ($hashtags as $hashtag_id) {
                    $article_hashtag = new Article_hashtag;
                    $article_hashtag->article_id = $request->id;
                    $article_hashtag->hashtag_id = $hashtag_id;

                    $article_hashtag->save();
                }
            }

            session()->flash('message', '修改成功');
            return redirect()->to('/article/' . $request->id);
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $article = Article::find($id);

        if ($article) {
            $article->delete();
            return redirect('/');
        } else {
            return "刪除失敗";
        }
    }

    public function search(Request $request)
    {
        $query = $request->search;
        $hashtag = $request->hashtag;

        if ($query) {

            $articles = Article::where('title', 'like', '%' . $query . '%')->with('hashtags')->orderBy('updated_at', 'desc')->get();

            return view('search', compact('articles'));

        } elseif ($hashtag) {

            $articles = Article::whereHas('hashtags', function ($query) use ($hashtag) {
                $query->where('name', $hashtag);
            })->orderBy('updated_at', 'desc')->get();

            return view('search', compact('articles'));
        }
    }
}
