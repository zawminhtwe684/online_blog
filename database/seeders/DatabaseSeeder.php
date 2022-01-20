<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
//        Category::factory(15)->create();
//        Post::factory(350)->create();
        Tag::factory(20)->create();

        User::create([
            "name"=>"Zaw Min Htwe",
            "email"=>"zawminhtwe199475@gmail.com",
            "email_verified_at"=>now(),
            "password"=>Hash::make("asdffdsa"),
            "remember_token"=>Str::random(10)

//            php artisan migrate:fresh --seed //အကုန်ဖျက်ချပြီး seeding ပြန်လုပ်ပေးပါတယ်
        ]);

//        foreach (Post::all() as $post){ အောက်ကရေးထုံးနှင့်တူသည်
//
//        }

        Post::all()->each(function ($post){ //foreach method နဲ့ ရေးထုံးတူပါသည်

           $tagIds = Tag::inRandomOrder()->limit(rand(1,3))->get()->pluck("id");// tag model ထဲကနေ အလှည့်ကျထုတ်ပြပြီး ကန့်သတ်ထုတ်လိုက်တယ် (၁,၃)ထက်မကျော်ပဲ ပြီးတော့ယူလိုက်တယ် id ပဲ
           $post->tags()->attach($tagIds);
        });

    }
}
