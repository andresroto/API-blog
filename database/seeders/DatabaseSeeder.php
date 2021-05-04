<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // Users
        User::factory(1)->create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        
        User::factory(10)->create();
        
        // Categories
        Category::factory(50)->create();
        
        // Tags
        Tag::factory(15)->create();

        // Posts
        Post::factory(20)->create()->each(function($post) {
            $post->tags()->attach($this->tags(rand(1,15))); 
            // $post->tags()->attach(Tag::all()->random()->id); 
        });


    }


    public function tags($value) {
        $tags = []; 

        for($i=1; $i < $value; $i++) $tags[] = $i; 

        return $tags; 
    }
    
}