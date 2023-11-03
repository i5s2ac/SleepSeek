<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::all();

        if ($request->wantsJson()) {
            return response()->json($posts, 200);
        }

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'PostName' => 'required|string|max:255',
            'PostInfo' => 'required|string|max:255',
        ]);

        $data['user_id'] = Auth::id();

        $post = Post::create($data);

        if ($request->wantsJson()) {
            return response()->json($post, 200);
        }

        return redirect()->route('posts.index')->with('success', 'Post creado con éxito.');
    }


    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'PostName' => 'required|string|max:255',
            'PostInfo' => 'required|string|max:255',
        ]);

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post actualizado con éxito.');
    }

    // Eliminar un post
    public function destroy(Post $post, Request $request)
    {
        $postDeleted = $post; 
        $post->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Post eliminado con éxito.', 'post_deleted' => $postDeleted], 200);
        }

        return redirect()->route('posts.index')->with('success', 'Post eliminado con éxito.');
    }


}
