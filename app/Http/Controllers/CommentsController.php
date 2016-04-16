<?php
namespace site\Http\Controllers;

use Illuminate\Http\Request;
use site\Http\Requests;
use site\Post;
use site\Comment;
use Redirect;

class CommentsController extends Controller
{
	public function store(Request $request)
	{
		$input['user_id'] = $request->user()->id;
		$input['post_id'] = $request->input('post_id');
		$input['body'] = $request->input('body');
		$slug = $request->input('slug');
		Comment::create($input);
		return redirect($slug)->with('message', 'Comment published');     
	}
}
