<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Saved;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedController extends Controller
{
    public function save(Request $request) {
        $user_id = Auth::user()->id;
        $isExist = Saved::where('user_id',$user_id)
        ->where('post_id',$request->post_id)->first();
        if($isExist) {
            return response()->json(['error' => 'already saved'], 400);
        }else {
            $post = Post::where('id',$request->post_id)->first();
            $save_count = $post->save_count;
            $save_count+=1;
            Post::where('id',$request->post_id)->update([
                'save_count' => $save_count
            ]);
            Saved::create([
                'user_id' => $user_id,
                'post_id' => $request->post_id
            ]);
            return response()->json(['saved'=>'Post Saved'], 200);
        }
    }

    public function unsave(Request $request) {
        $user_id = Auth::user()->id;
        $post = Post::where('id',$request->post_id)->first();
        $save_count = $post->save_count;
        $save_count-=1;
        Post::where('id',$request->post_id)->update([
            'save_count' => $save_count
        ]);
        Saved::where('user_id',$user_id)
        ->where('post_id',$request->post_id)
        ->delete();
        return response()->json(200);
    }

 // Saved list page
 public function savedList(Request $request) {
    $user_id = Auth::user()->id;
    $topic_id = $request->query('topic_id'); // Get selected topic ID from URL

    $postsQuery = Saved::select('saveds.*', 'users.role as role', 'posts.*', 'topics.name as topic_name', 'users.gender as admin_gender', 'users.name as admin_name', 'users.image as profile_image')
        ->leftJoin('posts', 'saveds.post_id', 'posts.id')
        ->leftJoin('users', 'posts.admin_id', 'users.id')
        ->leftJoin('topics', 'posts.topic_id', 'topics.id')
        ->where('saveds.user_id', $user_id)
        ->orderBy('posts.created_at', 'desc');

    // Filter posts by topic if a topic is selected
    if ($topic_id) {
        $postsQuery->where('posts.topic_id', $topic_id);
    }

    $posts = $postsQuery->paginate(3);

    // Get only topics that have saved posts by this user
    $topics = Topic::whereIn('id', function ($query) use ($user_id) {
        $query->select('posts.topic_id')
              ->from('saveds')
              ->leftJoin('posts', 'saveds.post_id', 'posts.id')
              ->where('saveds.user_id', $user_id);
    })->get();

    return view('user.saved', compact('posts', 'topics'));
}



}
