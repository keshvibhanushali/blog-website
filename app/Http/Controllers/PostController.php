<?php

namespace App\Http\Controllers;

use App\DataTables\PostsDataTable;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Favourites;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(PostsDataTable $dataTable)
    {
        return $dataTable->render('admin.post.index');
    }

    public function create()
    {
        $category = Category::all();
        return view('admin.post.create', compact('category'));
    }

    public function store(PostRequest $request)
    {
        try {
            $validated = $request->validated();
            $post = new Post();
            $post->user_id = $request->user_id;
            $post->title = $request->title;
            $post->excerpt = $request->excerpt;
            $post->description = $request->description;
            $post->thumbnail = $request->file('thumbnail')->store('thumbnail');
            $post->category_id = $request->category_id;
            $post->save();
            return redirect()->route('posts');
        } catch (Exception $e) {
        }
    }

    public function edit(Post $post)
    {
        $category = Category::all();
        return view('admin.post.edit', compact('post', 'category'));
    }

    public function update(Post $post, PostRequest $request)
    {
        try {
            $validated = $request->validated();
            $data = $request->all();
            $path = request('old_thumbnail');
            if (isset($data['thumbnail'])) {
                Storage::disk('local')->delete($path);
                $data['thumbnail'] = request()->file('thumbnail')->store('thumbnail');
            } else {
                $data['thumbnail'] = $data['old_thumbnail'];
            }
            unset($data['old_thumbnail']);
            $post->update($data);
            return redirect('posts')->with('success', 'updated successfully');
        } catch (Exception $e) {
            return redirect('posts')->with('Error', 'Data not updated successfully');
        }
    }

    public function delete(Post $post)
    {
        Storage::disk('public')->delete($post->thumbnail);
        unset($post->thumbnail);
        Post::where('id', $post->id)->delete();
    }

    public function removeAll(Request $request)
    {

        $posts = Post::whereIn('id', $request->ids)->get();
        foreach ($posts as $post) {
            $thumbnail = $post->thumbnail;
            $path = (public_path('storage/') . $thumbnail);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        Post::whereIn('id', $request->ids)->delete();
    }

    public function showPost(Category $category)
    {
        $posts = Post::with('favouritedByUser')->paginate(10);
        // dd($posts);
        return view('frontend.index', compact('posts'));
    }

    public function post($id)
    {
        $post = Post::find($id);
        // dd($post->user);
        return view('frontend.posts', ["post" => $post]);
    }

    public function postUser($id)
    {
        $postUser = Post::where('user_id', $id)->get();
        // dd($postuser);
        return view('frontend.post-by-users', compact('postUser'));
    }

    public function postCategory($id)
    {
        $postCategory = Post::where('category_id', $id)->get();
        return view('frontend.post-by-category', compact('postCategory'));
    }

    public function like(Request $request)
    {
        // $user = User::find($request->userid);
        $user=Auth::user()->load('favourites');
        // dd($request);
        // $user->favourites()->sync($request->postid);
        $fav = Favourites::where('user_id', $user->id)->where('post_id', $request->postid)->exists();
        if ($fav) {
            $user->favourites()->detach($request->postid);
        } else {
            $user->favourites()->attach($request->postid);
        }
        return response()->json(['message' => 'Like updated']);
    }
}
