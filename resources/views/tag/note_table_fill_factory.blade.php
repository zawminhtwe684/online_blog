return User::all();
User::first();
User::find(4);
User::inRandomOrder()->first()->id;

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Factory Auto fill to database
>>>1
>>>TagFactory မှာ
public function definition()
{
return [
"title"=> $this->faker->word(),
"user_id"=> User::inRandomOrder()->first()->id
];
}

>>> 2
>>> Seeders>DatabaseSeeder.php မှာရေး
public function run()
{
Tag::factory(20)->create();
}

>>>3
php artisan db:seed
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
post many & tag many >>> many to many လိုအပ်ချက်က pivot table လိုပါသည်။

{{--<div class="mb-3">--}}
{{--    <label for="form-lable" class="form-label">Select Tag</label>--}}
{{--    <br>--}}
{{--    @foreach(\App\Models\Tag::all() as $tag)--}}
{{--        <div class="form-check-inline">--}}
{{--            <label class="form-check-label" for="{{$tag->id}}">--}}
{{--                {{$tag->title}}--}}
{{--            </label>--}}
{{--            <input class="form-check-input" type="checkbox" value="{{$tag->id}}" name="tags[]" id="{{$tag->id}}" >--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}

>>>အက်ခရာအစဉ်အတိုင်း စီထားခြင်းဖြစပါသည်။ pivot table လိုပါသည်။>>php artisan make:migration create_post_tag_table
>>> $table->unsignedBigInteger("post_id");
    $table->unsignedBigInteger("tag_id");
>>> php artisan migrate

>>>many to many
public function tags(){
return $this->belongsToMany(Tag::class);
}

>>>save tags to pivot table ပို့တွေသိမ်းတဲ့ methods
$post->tags()->attach($request->tags);



>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Accessors ထုတ်ပြခြင်း & Mutators ပြန်သွင်းခြင်းဆိုသုံးပါသည် >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
ကိုယ်ရချင်တဲ့ Table Model ထဲမှာ ရေးရမှာပါ

FirstName ဆိုတာ Table ထဲက column ပါ စာတွေကို လျော့ပြချင်တဲ့အခါသုံးပါသည်။
public function getFirstNameAttribute($value)
{
return Str::words($value,10)."...";  // ဆိုးကြိုးက edit လုပ်ရင် ပြသာနာရှိပါသည်။
}

အောက်က ပုံစံသုံးလို့ကောင်းသည်။
public function getShortNameAttribute()
{
return Str::words($this->attributes['လိုချင်တဲ့ကော်လံ'],10)."...";  // ဆိုးကြိုးက edit လုပ်ရင် ပြသာနာရှိပါသည်။
return Str::words($this->လိုချင်တဲ့ကော်လံ,10)."...";  // ဆိုးကြိုးက edit လုပ်ရင် ပြသာနာရှိပါသည်။
}

ပြန်ခေါ်သုံးရင်
$post->short_name

public function getShowTime(){
return "<p class='small mb-0'>
        <i class='fas fa-calendar'></i>
        '.$this->created_at->format('Y-m-d').'
        </p>
        <p class='mb-0 small'>
            <i class='fas fa-clock'></i>
        '.$this->created_at->format('H:i a').'
        </p>"
}

အပေါ်က ကို ပြန်ခေါ်သုံးရင်
{!! $post->show_time !!}


Mutators က ပြန်သွင်းခြင်းဖြစ်ပါသည်။

public function setFirstNameAttribute($value)
{
$this->attributes['first_name'] = Str::slug($value);
}

>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Constraining Eager Loads>>>>>>>>>>>>>>>>>>>>>>query run တာကို လျော့ချခြင်းဖြစ်ပါသည်။ >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
public function index()
{
$posts = Post::when(isset(request()->search), function ($query) {
$search = request()->search;
$query->where('title', "LIKE", "%$search%")->orWhere('description', "LIKE", "%$search%");
})->with(['úser','category','photo','tags'])->latest('id')->paginate(5); // with နဲ့ table တွေကို ခေါ်သုံးထားလို့ query လျော့ချပါသည်။
return view('post.index', compact('posts'));
}

