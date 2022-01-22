Components Making
>>>php artisan make:component Alert
app>views
resource>views>components ဖိုင်နှစ်ခုတိုးပါသည်။

components ထဲက blade မှာရေးတာပါ>>>  <div class="alert alert-info">
                                    <h4>Components</h4>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium at atque distinctio doloremque, ea harum hic illum in ipsam ipsum itaque, maiores molestiae nam obcaecati odit quaerat suscipit tempora ut?</p>
                                    </div>
>>> <x-alert></x-alert> လို့ခေါ်သုံးလို့ရပါ။။။။။

သူ့ရဲ့ Components class မှာ သုံးခုထည့်ခဲံပါ

public $type;
public function __construct($type,$message=""){
$this->type = $type;
}


<div class="alert alert-{{$type}}">
    <h4>{{$message}}</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium at atque distinctio doloremque, ea harum hic illum in ipsam ipsum itaque, maiores molestiae nam obcaecati odit quaerat suscipit tempora ut?</p>
</div>

<x-alert type="error" :message="$message"/>
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
slot
<div class="">
    {{$slot}} က သူ့ရဲ့ ကလပ်မှာ ပြန်ကြေညာပေးစရာမလိုပါ။
</div>

<x-alert>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores debitis delectus ea expedita, facere nesciunt non quasi qui. Adipisci culpa cumque ipsum mollitia necessitatibus nobis, quam voluptates! Dolor id, quis.
</x-alert>



camelCase,=myName
kebab-case=my-name
https://github.com/protonemedia/laravel-form-components
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

View::share("myName","Zaw Min Htwe");


>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>global js connection >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
@stack('js')

@push("js")
    <script>

    </script>
@endpush

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>injection >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

@inject('cat',"\App\Models\Category")
{{$cat->first()->title}}


>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>directive >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Blade::directive("zmh",function(){
    return "<h1>Zaw Min Htwe</h1>"
});
@zmhလို့ခေါ်ချင်ရင်

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>php artisan make:provider view >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
တခြားအကြောင်းအရာတွေကို ထည့်ချင်လို့
config ထဲမှာ ပြန်ပြီးကြေညာပေးရပါသည်။


>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>relateion ship>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
look for post model
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Installation laravel>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
composer create-project laravel/laravel blog
composer require laravel/ui
php artisan ui bootstrap-auth
npm install & npm un dev
php artisan make:model Category --all
category route, category views, CRUD,dbseeding
php artisan make:model Post --all
post | category(one to many, one to one inverse)
Photo(one to many)
Tag(Many to Many)
user->photo, category->photo( has many through)
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>observer တစ်ခုခုကို crud လုပ်လိုက်ရင်တန်းပြပေးတာပါ >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
php artisan make:observer PostObserver --model=Post
provider>>>eventserviceprovider>>> မှာ ဝင်ကြေညာပေးရပါသည်။
Post::observe(PostObserver::class);
observer>>>postobserver ထဲမှာ
public function deleted(Post $post)
{
logger($post->title."is deleted by".Auth::user()->name);
}
။>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>//query scope ->local scope>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
method တွေကို ခွဲရေးတယ်ဆိုတဲ့သဘောပါ  သက်ဆိုင်ရာ model မှာ ရေးထားခြင်းဖြစ်ပါသည်။
//query scope ->local scope
public function scopeSearch($query){
if(isset(request()->search)){
$search =request()->search ;
return $query->where('title', "LIKE", "%$search%")->orWhere('description', "LIKE", "%$search%");
}
}
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Database Transation >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
အလုပ်တွေအကုန်လုံး လုပ်မှ Database ထဲကို သိမ်းရပါမည်
DB::transaction(function () use($request){ //save()ဆိုတာတွေအကုန် အလုပ်လုပ်မှ database ထဲကို သိမ်းမှာ ပါ
                                               //use($request) ရေးထားခြင်းက အထဲမှာ ပါနေလို့ပါ $request
});
အပေါ်ကရေးတာနဲ့ အဓိပ္ပါယ်အတူတူပါ

DB::beginTransaction();
try{
//save()ဆိုတာတွေအကုန် အလုပ်လုပ်မှ database ထဲကို သိမ်းမှာ ပါ
DB::commit();
}catch(Exception $e){
DB::rollBack();
throw $e;
}
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Foregin Constranins >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
child တွေကိုလည်း ဖျက်ပေးရတယ်
//            $table->foreignId('post_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
