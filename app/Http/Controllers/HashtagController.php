<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $hashtags = Hashtag::get();

        return view('hashtag', compact('hashtags'));
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
        $hashtag = new Hashtag;

        $hashtag->name = $request->name;

        try {
            $hashtag->save();

            session()->flash('message', '新增成功');

            return redirect()->back();
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hashtag $hashtag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hashtag $hashtag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hashtag $hashtag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hashtag $hashtag)
    {
        //
    }
}
