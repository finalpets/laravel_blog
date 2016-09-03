<?php
namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

use Session;

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
	public function postContact(Request $request){
	
		$this->validate($request , [
			'email' => 'required|email',
			'subject' => 'min:3',
			'message' => 'min:10'
			]);
		$data = array(
			'email' => $request->email,
			'subject' => $request->subject,
			'bodyMessage' => $request->message //you cant use message is reserved variable change to bodyMessage
			);

		Mail::send('emails.contact',$data,function($message) use ($data){
			$message->from($data['email']);
			$message->to('peter.leyva.bazan@gmail.com');
			$message->subject($data['subject']);

		} );

	Session::flash('success','Your Email was Sent');

	return redirect('/');



	}

}