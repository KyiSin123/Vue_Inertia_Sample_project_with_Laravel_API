<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use App\Events\UpdateHistory;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::filter(request('search'))
            ->sort()
            ->paginate(5);

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Posts/Create'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        if ($request->file()) {
            $file_path = $request->file('image')->store('uploads', 'public');
        }
        $post = Post::create([
            'name' => $request->name,
            'image' =>  '/storage/' . $file_path,
        ]);

        return redirect()->route('posts.index')->with('message', 'Post Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->name = $request->name;
        if($request->file()) {
            unlink(public_path($post->image));
            $file_path = $request->file('image')->store('uploads', 'public');
            $post->image = '/storage/' . $file_path;
        }
        $post->save();
        event(new UpdateHistory($post));

        return redirect()->route('posts.index')->with('message', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        unlink(public_path($post->image));
        $post->delete();
        sleep(1);

        return redirect()->route('posts.index')->with('message', 'Post Delete Successfully');
    }
}
