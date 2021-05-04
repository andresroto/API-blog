<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostResource::collection(Post::all()); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()) {

            try {
                
                // Validations 
                $this->validate($request, [
                    'title' => 'required|string|max:255', 
                    'description' => 'required|string|max:255', 
                    'content' => 'required|string', 
                    'category' => 'required|numeric|',
                    'published' => 'required|boolean', 
                    'tags' => 'required'
                ]);


                // Slug
                $slug = preg_replace('/[^A-Za-z0-9-]+/','-',$request->title);
                $slug = strtolower($slug); 

                // Save fields
                $post = new Post; 
                $post->user_id = Auth::user()->id; 
                $post->title = $request->title; 
                $post->slug = $slug;
                $post->description = $request->description;
                $post->content = $request->content; 
                $post->category_id = $request->category; 
                $post->published = $request->published; 
                $post->save();

                // Save tags
                $tags = explode(",", $request->tags); 
                $post->tags()->attach($tags);   
                

                // Return response
                return response()->json([
                    'Message' => 'Ok', 
                    'Post' => new PostResource($post) 
                ]); 
            
            } catch (ValidationException $e) {
                return response()->json(
                    $e->validator->errors()
                ); 
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource(Post::findOrFail($post->id)); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        // if (! Gate::allows('update-post', $post)) {
        //     abort(403);
        // }

        $response = Gate::inspect('update', $post);

        if ($response->allowed()) {
            
            if($request->ajax()) {

                try {
                    
                    // Validations 
                    $this->validate($request, [
                        'title' => 'required|string|max:255', 
                        'description' => 'required|string|max:255', 
                        'content' => 'required|string', 
                        'category' => 'required|numeric|',
                        'published' => 'required|boolean', 
                        'tags' => 'required'
                    ]);
    
    
                    // Slug
                    $slug = preg_replace('/[^A-Za-z0-9-]+/','-',$request->title);
                    $slug = strtolower($slug); 
    
                    // Save fields
                    $post->title = $request->title; 
                    $post->slug = $slug;
                    $post->description = $request->description;
                    $post->content = $request->content; 
                    $post->category_id = $request->category; 
                    $post->published = $request->published; 
                    $post->save();
    
                    // Save tags
                    $tags = explode(",", $request->tags); 
                    $post->tags()->sync($tags);   
                    
    
                    // Return response
                    return response()->json([
                        'Message' => 'Ok', 
                        'Post' => new PostResource($post) 
                    ]); 
                        
                } catch (ValidationException $e) {
                    return response()->json(
                        $e->validator->errors()
                    ); 
                }
            }

        } else {
            echo $response->message();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $response = Gate::inspect('delete', $post);

        if ($response->allowed()) {
            $post->delete(); 
            return response()->json([
                'message' => 'Ok', 
                'post' => new PostResource($post)
            ]); 
        } else {
            echo $response->message();
        }
    }
}
