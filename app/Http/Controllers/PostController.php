<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Post;
use App\Models\User;
use App\Models\Saved;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //Direct post list page
    public function listPage() {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
            ->when(request('searchKey'), function($query) {
                $query->orWhere('topics.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('posts.desc', 'like', '%' . request('searchKey') . '%');
            })
            ->leftJoin('topics', 'posts.topic_id', 'topics.id')
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->where('posts.approved', 1) // ✅ Only approved posts
            ->orderBy('posts.created_at', 'desc')
            ->paginate(10); // ✅ Correct pagination

        return view('admin.post.list', compact('post'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'topicId' => 'required',
            'postImage' => 'nullable|image|max:2048',
            'desc' => 'required|min:5',
        ]);

        $post = new Post();
        $post->admin_id = auth()->id();
        $post->topic_id = $request->topicId;
        $post->desc = $request->desc;
        $post->approved = 0;

        if ($request->hasFile('postImage')) {
            $post->image = $request->file('postImage')->store('posts');
        }

        $post->save();

        return redirect()->back()->with('message', 'Your post has been submitted for approval.');
    }


 //Filter Ascending
 public function filterAsc() {
    $query = Post::select('posts.*', 'users.name as admin_name', 'topics.name as topic_name')
        ->leftJoin('topics', 'posts.topic_id', '=', 'topics.id')
        ->leftJoin('users', 'posts.admin_id', '=', 'users.id')
        ->where('posts.approved', 1); // ✅ Filter only approved posts

    $post = (clone $query)
        ->when(request('searchKey'), function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->orWhere('topics.name', 'like', '%' . request('searchKey') . '%')
                         ->orWhere('posts.desc', 'like', '%' . request('searchKey') . '%');
            });
        })
        ->orderBy('posts.created_at', 'asc')
        ->paginate(10); // ✅ Correct pagination count

    return view('admin.post.list', compact('post'));
}
public function home(Request $request) {
    $token = \Illuminate\Support\Str::random(32);
    $request->session()->put('post_token', $token);

    $topics = Topic::get();

    // ✅ Fetch ONLY approved posts BEFORE paginating
    $posts = Post::select('posts.*', 'users.name as admin_name', 'topics.name as topic_name', 'users.image as profile_image')
        ->leftJoin('users', 'posts.admin_id', '=', 'users.id')
        ->leftJoin('topics', 'posts.topic_id', '=', 'topics.id')
        ->where('posts.approved', 1) // ✅ Ensure only approved posts are fetched
        ->orderBy('posts.created_at', 'desc')
        ->paginate(10); // ✅ Paginate only approved posts

    return view('user.post.createPost', compact('topics', 'posts', 'token'));
}



//filter most saved
public function mostSaved() {
    $query = Post::select('posts.*', 'users.name as admin_name', 'topics.name as topic_name')
        ->leftJoin('topics', 'posts.topic_id', '=', 'topics.id')
        ->leftJoin('users', 'posts.admin_id', '=', 'users.id')
        ->where('posts.approved', 1); // ✅ Filter only approved posts

    $post = (clone $query)
        ->when(request('searchKey'), function ($query) {
            $query->where(function ($subQuery) {
                $subQuery->orWhere('topics.name', 'like', '%' . request('searchKey') . '%')
                         ->orWhere('posts.desc', 'like', '%' . request('searchKey') . '%');
            });
        })
        ->orderBy('posts.save_count', 'desc')
        ->paginate(10); // ✅ Correct pagination count

    return view('admin.post.list', compact('post'));
}


    // Direct post create page
    public function createPage() {
        $topic = Topic::select('id','name')->get();
        return view('admin.post.create',compact('topic'));
    }

    public function filterApproved() {
        $query = Post::select('posts.*', 'users.name as admin_name', 'topics.name as topic_name')
            ->leftJoin('topics', 'posts.topic_id', '=', 'topics.id')
            ->leftJoin('users', 'posts.admin_id', '=', 'users.id')
            ->where('posts.approved', 1); // ✅ Filter approved posts

        $post = (clone $query)
            ->when(request('searchKey'), function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->orWhere('topics.name', 'like', '%' . request('searchKey') . '%')
                             ->orWhere('posts.desc', 'like', '%' . request('searchKey') . '%');
                });
            })
            ->orderBy('posts.created_at', 'desc')
            ->paginate(10); // ✅ Correct pagination count

        return view('admin.post.list', compact('post'));
    }




    public function filterPending() {
        $post = Post::select('posts.*','users.name as admin_name','topics.name as topic_name')
            ->when(request('searchKey'), function ($query) {
                $query->orWhere('topics.name', 'like', '%' . request('searchKey') . '%')
                      ->orWhere('posts.desc', 'like', '%' . request('searchKey') . '%');
            })
            ->leftJoin('topics', 'posts.topic_id', 'topics.id')
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->where('posts.approved', 0) // ✅ Only Pending Posts
            ->orderBy('posts.created_at', 'desc')
            ->paginate(5);

        return view('admin.post.list', compact('post'));
    }


    public function pendingPosts() {
        $post = Post::select('posts.*', 'users.name as admin_name', 'topics.name as topic_name')
            ->leftJoin('topics', 'posts.topic_id', 'topics.id')
            ->leftJoin('users', 'posts.admin_id', 'users.id')
            ->where('posts.approved', 0) // Fetch only pending posts
            ->orderBy('posts.created_at', 'desc')->paginate(5);

        return view('admin.post.pending', compact('post'));
    }

    //Create Post
    public function create(Request $request) {
    $this->postValidationCheck($request);

    // ✅ Use Auth::user() to get the currently logged-in user
    $user = Auth::user();

    // ✅ Get post data and ensure admin auto-approval
    $post = $this->postGetData($request, $user);

    if ($request->hasFile('postImage')) {
        $postImageName = uniqid() . '_' . $request->file('postImage')->getClientOriginalName();
        $post['image'] = $postImageName;
        $request->file('postImage')->storeAs('public/', $postImageName);
    }

    // ✅ Auto-approve posts if the user is an admin
    if ($user->role === 'admin') {
        $post['approved'] = 1;
    }

    // ✅ Save the post
    Post::create($post);

    return redirect()->route('post#listPage')->with([
        'createMessage' => ($post['approved'] == 1)
            ? 'Post published successfully!'
            : 'Your post has been submitted for approval.'
    ]);
}





    public function approve($id) {
        $post = Post::findOrFail($id);

        if ($post) {
            $post->approved = 1; // ✅ Change approved status to 1
            $post->save(); // ✅ Save changes to the database

            return response()->json(['message' => 'Post approved successfully!'], 200);
        }

        return response()->json(['error' => 'Post not found.'], 404);
    }



    //validate post data
    private function postValidationCheck($request) {
        Validator::make($request->all(), [
            'desc' => 'required|min:10',
            'topicId' => 'required',
            'image' => 'mimes:png,jpg,jpeg,JPEG|file'
        ])->validate();
    }

    //get data from post input
    private function postGetData($request) {
        $user = User::find($request->adminId);

        return [
            'admin_id' => $request->adminId,
            'desc' => $request->desc,
            'topic_id' => $request->topicId,
            'approved' => ($user && $user->role === 'admin') ? 1 : 0 // ✅ Auto approve for admins
        ];
    }


    //view detail post
    public function view($id) {
        $post = Post::select('posts.*','users.gender as admin_gender','users.name as admin_name','users.image as profile_image')
        ->leftJoin('users','posts.admin_id','users.id')
        ->where('posts.id',$id)->first();
        $topic_name = Topic::where('id',$post->topic_id)->first();
        $topic_name =$topic_name->name;
        return view('admin.post.view',compact('post','topic_name'));
    }

    //delete post
    public function delete(Request $request) {
        $dbImage = Post::select('image')->where('id', $request->post_id)->first();
        $dbImage = $dbImage->image;
        if ($dbImage != null) {
            Storage::delete('public/' . $dbImage);
        }
        Saved::where('post_id', $request->post_id)->delete();
        Post::where('id', $request->post_id)->delete();
        return response()->json(200);
    }

    //edit page
    public function editPage($id) {
        $post = Post::select('posts.*', 'users.name as admin_name')
            ->leftJoin('users', 'posts.admin_id', 'users.id')->get();
        $post = $post->where('id', $id)->first();
        $topic = Topic::get();
        return view('admin.post.edit', compact('post', 'topic'));
    }

    //update post
    // Update Post (Resets approval status)
    public function edit(Request $request, $id) {
        $this->postValidationCheck($request);
        $data = $this->postGetData($request);

        // Reset approval status on edit
        $data['approved'] = 0; // Needs reapproval after editing

        // Image check
        if ($request->hasFile('postImage')) {
            $dbImage = Post::select('image')->where('id', $id)->first();
            $dbImage = $dbImage->image;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $imageName = uniqid() . '_' . $request->file('postImage')->getClientOriginalName();
            $data['image'] = $imageName;
            $request->file('postImage')->storeAs('public/', $imageName);
        }

        Post::where('id', $id)->update($data);
        return redirect()->route('post#listPage')->with(['editMessage' => 'Post updated successfully and is now pending approval.']);
    }
}
