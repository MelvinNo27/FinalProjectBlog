<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // Display home page with posts and topics
    public function home()
    {
        $searchKey = request('searchKey');

        $posts = Post::select(
            'posts.*',
            'users.gender as admin_gender',
            'users.role as role',
            'users.name as admin_name',
            'users.image as profile_image',
            'topics.name as topic_name'
        )
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->leftJoin('topics', 'posts.topic_id', 'topics.id')
            ->when($searchKey, function ($query) use ($searchKey) {
                $query->where('desc', 'like', "%$searchKey%");
            })
            ->orderBy('posts.created_at', 'desc')
            ->paginate(10);

        $topics = Topic::orderBy('created_at', 'desc')->get();

        $saveStatus = [];
        if (Auth::check()) {
            $savedPosts = Saved::where('user_id', Auth::id())->pluck('post_id')->toArray();
            foreach ($posts as $post) {
                $saveStatus[$post->id] = in_array($post->id, $savedPosts);
            }
        }

        return view('user.home', compact('posts', 'topics', 'saveStatus'));
    }

    // Display a single post
    public function view($id)
    {
        $post = Post::select(
            'posts.*',
            'users.role as role',
            'users.gender as admin_gender',
            'users.name as admin_name',
            'users.image as profile_image'
        )
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->where('posts.id', $id)
            ->firstOrFail();

        $topic_name = Topic::where('id', $post->topic_id)->value('name');
        $topics = Topic::all();

        return view('user.view', compact('post', 'topic_name', 'topics'));
    }

    // Filter posts by topic
    public function topicFilter($topicId)
{
    $posts = Post::select(
        'posts.*',
        'users.role as role',
        'users.gender as admin_gender',
        'users.name as admin_name',
        'users.image as profile_image',
        'topics.name as topic_name'
    )
        ->leftJoin('users', 'posts.admin_id', 'users.id')
        ->leftJoin('topics', 'posts.topic_id', 'topics.id')
        ->where('posts.topic_id', $topicId)
        ->orderBy('posts.created_at', 'desc')
        ->paginate(10);

    $topics = Topic::orderBy('created_at', 'desc')->get();

    // Check saved post status
    $saveStatus = [];
    if (Auth::check()) {
        $savedPosts = Saved::where('user_id', Auth::id())->pluck('post_id')->toArray();
        foreach ($posts as $post) {
            $saveStatus[$post->id] = in_array($post->id, $savedPosts);
        }
    }

    // ✅ Ensure `$topicId` is passed to the view
    return view('user.home', compact('posts', 'topics', 'saveStatus', 'topicId'));
}

}
