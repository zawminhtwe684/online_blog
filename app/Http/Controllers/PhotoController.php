<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
//        return $request;

        $request->validate([
            "post_id"=>"required|integer",
            "photos"=>"nullable",
            "photos.*"=>"file|max:3500|mimes:jpg,png"
        ]);

//        file တည်ဆောက်ခြင်း
        if(!Storage::exists("public/thumbnail")){
            Storage::makeDirectory("public/thumbnail");
        }

        if($request->hasFile("photos")){
            foreach ($request->file('photos')as $photo){
                //store file
                $newName= uniqid()."_photo.".$photo->extension();

                $photo->storeAs("public/photo/",$newName);//storeAs လို့ခေါ်လိုက်တာနဲ့ storage>app ကို ထောက်ထားပြီးသားပါ


                //intervention save image for making thumbnail
                $img=Image::make($photo);

                //reduce file size
                $img->fit(200,200);

                //to save file path
                $img->save("storage/thumbnail/".$newName);//public ဆိုတဲ့ folder ကို သုံးတာပါ


                //save in db
                $photo = new Photo();
                $photo->name = $newName;
                $photo->post_id=$request->post_id;
                $photo->user_id = Auth::id();
                $photo->save();

            }
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePhotoRequest  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {

//return $photo;
//delete path file location
        Storage::delete("public/photo/".$photo->name);
        Storage::delete("public/thumbnail/".$photo->name);

//        delete db record
        $photo->delete();

        return redirect()->back();
//        return dd($photo);

    }
}
