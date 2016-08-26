<?php
namespace App\Http\Controllers;
use App\Post;

class PagesController extends Controller{

	public function getIndex(){
		$posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
		//Post::// means SELECT * from table(example posts)
		return view('pages.welcome')->with('posts',$posts);
	}

	public function getAbout(){
		$first = 'Peter';
		$last = 'Leyva';

		$fullname = $first . " " . $last;
		$email = 'Peter.leyva.bazan@gmail.com';
		return view('pages.about')->withFullname($fullname)->withEmail($email);
	}

	public function getContact(){
		return view('pages.contact');

	}

}