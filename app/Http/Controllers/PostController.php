<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\Category;

use Session;

use App\Tag;

use Purifier;

use Image;

class PostController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        //$this->middleware('auth' ,['except' => 'logout']);
    }
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
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create')->with('categories',$categories)->with('tags',$tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request); //this is for debugging the information  and stops here nothing below will call
        // validate data
        $this->validate($request , array(
            'title' => 'required|max:255',
            'body' => 'required' ,
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer'
            ));
        $post = new Post; //save brand new object

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = Purifier::clean($request->body);//clean malicius code
        $post->category_id = $request->category_id;

        //save Image
        if ($request->hasFile('featured_image')){
            $image = $request->file('featured_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/'. $filename );

            Image::make($image)->resize(800,400)->save($location);

            $post->image = $filename;

        }

        $post->save();

        $post->tags()->sync($request->tags,false);

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
       // $categories = Category::all();
        $categories = Category::pluck('name','id');
        // $cats = array();
        // foreach ($categories as $category) {
        //     $cats[$category->id] = $category->name;
        // }
        $tags = Tag::pluck('name','id');
        return view('posts.edit')->with('post', $post)->with('categories',$categories)->with('tags',$tags);
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
            'category_id' => 'required|integer',      
            'body' => 'required'
            ));
        } else {
             $this->validate($request , array(
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer',
            'body' => 'required'
            ));

        }
        
        // save the data to the database
        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));//remove tags clean code

        $post->save();
        if(isset($request->tags)) {
            $post->tags()->sync($request->tags,true);//true for update
        } else {
            $post->tags()->sync(array());
        }
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

        $post->tags()->detach();

        $post->delete();
        Session::flash('success','The post was succesfully deleted');
        return redirect()->route('posts.index');
    }
}
