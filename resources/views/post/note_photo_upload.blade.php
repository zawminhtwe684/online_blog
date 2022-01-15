{{--1--}}
{{--terminal--}}
{{--php artisan make model Photo --all--}}
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--2--}}
{{--migration ထဲမှာ ဆောက်တာပါ--}}
{{--$table->id();--}}
{{--$table->string('name');--}}
{{--$table->bigInteger('user_id');--}}
{{--$table->bigInteger('post_id');--}}
{{--$table->timestamps();--}}
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--3--}}
{{--create.blade.php မှာရေးတာပါ-- multiple အတွက်ပါ}}
{{--လိုအပ်သည့်အချက်များ--}}
{{--1> enctype=multipart/form-date--}}
{{--2> type = "file"--}}
{{--3> multiple--}}
{{--4> name="photo[]"--}}

{{--<div class="mb-3">--}}
{{--    <label class="form-label">Photo</label>--}}
{{--    <input type="file" class="form-control @error('photo') is-invalid @enderror" value="{{ old('photo') }}" name="photo[]" multiple>--}}
{{--    @error('photo')--}}
{{--    <p class="text-danger small">{{ $message }}</p>--}}
{{--    @enderror--}}
{{--</div>--}}

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--4--}}
{{--store method မှာ--}}
{{--$request->validate([--}}
{{--"photo"=>"required", => ပုံမပါလည်းရတယ်ဆိုရင် nullable--}}
{{--"photo.*"=>"file|max:3500|mimes:jpg,png"--}}
{{--]);--}}

{{--if($request->hasFile("photo")){--}}
{{--foreach ($request->file('photo')as $photo){--}}
{{--//store file--}}
{{--$newName= uniqid()."_photo.".$photo->extension();--}}

{{--//storeAs လို့ခေါ်လိုက်တာနဲ့ storage>app ကို ထောက်ထားပြီးသားပါ--}}
{{--$photo->storeAs("public/photo/",$newName);--}}

{{--//save in db--}}
{{--$photo = new Photo();--}}
{{--$photo->name = $newName;--}}
{{--$photo->post_id=$post->id;--}}
{{--$photo->user_id = Auth::id();--}}
{{--$photo->save();--}}

{{--}--}}
{{--}--}}

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--5 ပြန်ထုတ်ပြခြင်း မူရင်းပုံ--}}
{{--{{$post->photos}}--}}
{{--@forelse($post->photos as $photo)--}}
{{--    <img src="{{asset("storage/photo/".$photo->name)}}" height="30">--}}
{{--@empty--}}
{{--    <p class="text-muted">No Photo</p>--}}
{{--@endforelse--}}

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--6 နမူနာပုံပဲထုတ်ပြစေချင်ရင်  thumbnail ထည့်ပါသည်။ intervention save image for making thumbnail--}}
{{--composer require intervention/image--}}
{{--app>config>app.php ထဲမှာ ဖြည့်ရန် --}}
{{--$provider ထဲမှာ Intervention\Image\ImageServiceProvider::class--}}
{{--$aliases ထဲမှာ  'Image' => Intervention\Image\Facades\Image::class--}}
{{--ထည့်ပြီးရင် vendor public လုပ်ဖို့မမေ့ပါနဲ့--}}

{{--//        file ကိုသူ့အလိုလိုတည်ဆောက်ခြင်း--}}
{{--if(!Storage::exists("public/thumbnail")){--}}
{{--Storage::makeDirectory("public/thumbnail");--}}
{{--}--}}

{{--//intervention save image for making thumbnail--}}
{{--$img=Image::make($photo);--}}

{{--//reduce file size--}}
{{--$img->fit(200,200);--}}

{{--//to save file path--}}
{{--$img->save("storage/thumbnail/".$newName);--}}



>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--7-- ပုံကို edit လုပ်ဖို့ ပြန်ရဖို့ကိုသုံး}}
@forelse($post->photos as $photo)
    <img src="{{asset("storage/thumbnail/".$photo->name)}}" width="100" alt="">
@empty
    <p class="text-muted">No Photo</p>
@endforelse


crdu လုပ်ဖို့
   Route::resource('photo',\App\Http\Controllers\PhotoController::class);


                        7 ရဲ့အစထဲကနေပြန်ထည့်ရေးခြင်း
                        @forelse($post->photos as $photo)
                            <img src="{{asset("storage/thumbnail/".$photo->name)}}" width="100" alt="">
                            <form action="{{route("photo.destroy",$photo->id)}}" method="post">
                                @csrf
                                @method("delete")
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        @empty
                            <p class="text-muted">No Photo</p>
                        @endforelse

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
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
{{--8 ပုံတွေထပ်ထည့်မယ်--}}
{{--<form action="{{route('photo.store')}}" method="post">--}}
{{--    @csrf--}}
{{--    --}}{{--                               //ဘယ်သူ့အတွက်လည်းဆိုတာ လိုအပ်ပါသည် မြင်စရာမလို--}}
{{--    <input type="hidden" name="post_id" value="{{$post->id}}">--}}
{{--    <div class="mb-3">--}}
{{--        <label class="form-label">Photo</label>--}}
{{--        <input type="file" class="form-control @error('photo') is-invalid @enderror" value="{{ old('photo') }}" name="photo[]" multiple>--}}
{{--        @error('photo')--}}
{{--        <p class="text-danger small">{{ $message }}</p>--}}
{{--        @enderror--}}
{{--    </div>--}}
{{--    <button class="btn btn-primary">Upload</button>--}}
{{--</form>--}}

{{--store method ကိုရောက်မည်--}}
{{--public function store(StorePhotoRequest $request)--}}
{{--{--}}
{{--//        return $request;--}}

{{--$request->validate([--}}
{{--"post_id"=>"required|integer",--}}
{{--"photo"=>"nullable",--}}
{{--"photo.*"=>"file|max:3500|mimes:jpg,png"--}}
{{--]);--}}

{{--//        file တည်ဆောက်ခြင်း--}}
{{--if(!Storage::exists("public/thumbnail")){--}}
{{--Storage::makeDirectory("public/thumbnail");--}}
{{--}--}}

{{--if($request->hasFile("photo")){--}}
{{--foreach ($request->file('photo')as $photo){--}}
{{--//store file--}}
{{--$newName= uniqid()."_photo.".$photo->extension();--}}

{{--$photo->storeAs("public/photo/",$newName);//storeAs လို့ခေါ်လိုက်တာနဲ့ storage>app ကို ထောက်ထားပြီးသားပါ--}}


{{--//intervention save image for making thumbnail--}}
{{--$img=Image::make($photo);--}}

{{--//reduce file size--}}
{{--$img->fit(200,200);--}}

{{--//to save file path--}}
{{--$img->save("storage/thumbnail/".$newName);//public ဆိုတဲ့ folder ကို သုံးတာပါ--}}


{{--//save in db--}}
{{--$photo = new Photo();--}}
{{--$photo->name = $newName;--}}
{{--$photo->post_id=$request->post_id;--}}
{{--$photo->user_id = Auth::id();--}}
{{--$photo->save();--}}

{{--}--}}
{{--}--}}

{{--return redirect()->back();--}}
{{--}--}}
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
upload နှစ်ခုဖြစ်နေတာကို hide ထားခြင်း
form>class="d-none"
form>id="photoUploadForm"
form>input>id="photoInput"

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
ပုံအကြီးချဲ့ချင်ရင် venobox သုံးပါသည်။ >>> links ..>https://veno.es/venobox/ ထဲကမှ git ကိုဝင်ကြည့်ပါ
npm install venobox
>1>>@import "~venobox/dist/venobox.min.css";
>2>>window.VenoBox = require('venobox');
>3>>npm run dev
>4>>new VenoBox({
selector: '.venobox'
});
ချိတ်တဲ့ပုံစံပါ data-gall က ပုံတွေချိတ်ပြတာပါ
{{--<a class="venobox" data-gall="myGallery" href="{{asset("storage/photo/".$photo->name)}}">--}}
{{--    <img src="{{asset("storage/thumbnail/".$photo->name)}}" alt="image" height="30px"/>--}}
{{--</a>--}}

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
sweetalert2
>1>> သွင်း
npm install sweetalert2
>2>> ချိတ်
window.Swal = require('sweetalert2');

>3>> ခေါ်ခဲ့တာ
return redirect()->route('post.index')->with('status',"Post Created");

>4>> ပါရင်ပြန်ထုတ်ပြတာ

@if(session('status'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: '{{session('status')}}'
        })
    </script>
@endif
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
