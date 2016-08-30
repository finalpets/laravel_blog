<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       // $posts = Post::all();//return all elements from the database
         $posts = Post::orderBy('id','desc')->paginate(5); //desc for descending order //asc asending order
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $this->validate($request , array(
            'title' => 'required|max:255',
            'body' => 'required' ,
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug'
            ));
        $post = new Post; //save brand new object

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;


        $post->save();

        Session::flash('success','The blog post was succesfully save!');

        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id); //only find by primary ID 
        return view('posts.show')->with('post', $post );
        //return view('posts.show')->withPost( $post );//OR use this one is the same
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {                        
        
        // validate the data
        $post = Post::find($id);
        if($request->input('slug') == $post->slug) {

            $this->validate($request , array(
            'title' => 'required|max:255',            
            'body' => 'required'
            ));
        } else {
             $this->validate($request , array(
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'body' => 'required'
            ));

        }
        
        // save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');

        $post->save();
        // set flash data with success message
        Session::flash('success','This post was Successfully saved.');

        // redirect with flash data to posts.show

        return redirect()->route('posts.show',$post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);

        $post->delete();
        Session::flash('success','The post was succesfully deleted');
        return redirect()->route('posts.index');
    }
}
