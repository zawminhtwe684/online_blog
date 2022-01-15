<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(isset(request()->search), function ($query) {
            $search = request()->search;
            $query->where('title', "LIKE", "%$search%")->orWhere('description', "LIKE", "%$search%");
        })->latest('id')->paginate(5);
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
//        return $request;
        $request->validate([
            "title" => "required|unique:posts,title|min:3",
            "category" => "required|integer|exists:categories,id",
            "description" => "required|min:20",
            "photo" => "required",
            "photo.*" => "file|max:3500|mimes:jpg,png"
        ]);


        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description, 20);
        $post->category_id = $request->category;
        $post->user_id = Auth::id();
        $post->is_publish = true;
        $post->save();


//        file တည်ဆောက်ခြင်း
        if (!Storage::exists("public/thumbnail")) {
            Storage::makeDirectory("public/thumbnail");
        }

        if ($request->hasFile("photo")) {
            foreach ($request->file('photo') as $photo) {
                //store file
                $newName = uniqid() . "_photo." . $photo->extension();

                $photo->storeAs("public/photo/", $newName);//storeAs လို့ခေါ်လိုက်တာနဲ့ storage>app ကို ထောက်ထားပြီးသားပါ


                //intervention save image for making thumbnail
                $img = Image::make($photo);

                //reduce file size
                $img->fit(200, 200);

                //to save file path
                $img->save("storage/thumbnail/" . $newName);//public ဆိုတဲ့ folder ကို သုံးတာပါ


                //save in db
                $photo = new Photo();
                $photo->name = $newName;
                $photo->post_id = $post->id;
                $photo->user_id = Auth::id();
                $photo->save();

            }
        }

        return redirect()->route('post.index')->with('status', "Post Created");

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'))->with('status', "Post Edit");;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validate([
            "title" => "required|unique:posts,title,$post->id|min:3",
            "category" => "required|integer|exists:categories,id",
            "description" => "required|min:20"
        ]);


        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->description = $request->description;
        $post->excerpt = Str::words($request->description, 20);
        $post->category_id = $request->category;
        $post->update();


        return redirect()->route('post.index')->with('status', "Post Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
//        return [$post,$post->photos];
        foreach ($post->photos as $photo) {
            Storage::delete("public/photo/" . $photo->name);
            Storage::delete("public/thumbnail/" . $photo->name);

//            $photo->delete(); //query တစ်ကြောင်းခြင်းစီကို ဖျက်တာမို့ပါ
        }
        //delete all record from hasMany
        $post->photos()->delete();
        $post->delete();
        return redirect()->back()->with('status', "Post Deleted");

    }
}
