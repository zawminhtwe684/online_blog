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



>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
