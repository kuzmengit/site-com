<?php

namespace site\Http\Controllers;

use Illuminate\Http\Request;
use site\Http\Requests;
use site\Post;
use site\User;
use Redirect;
use site\Http\Controllers\Controller;
use site\Http\Requests\PostFormRequest;

class PostsController extends Controller
{
	public function index()
	{
		//fetch 5 posts from database which are active and latest
		// \Log::info('It Logout -------------------------');
		$posts = Post::with('user')->where('active',1)->orderBy('created_at','desc')->paginate(5);
		//page heading
		$title = 'Latest Posts';
		//return home.blade.php template from resources/views folder
		return view('home')->withPosts($posts)->withTitle($title);
	}
	public function create(Request $request)
	{
		// if user can post i.e. user is admin or author
		if($request->user()->can_post())
		{
		  return view('posts.create');
		}    
		else 
		{
		  return redirect('/')->withErrors('You have not sufficient permissions for writing post');
		}
	}
	public function store(PostFormRequest $request)
	{
		$post = new Post();
		$post->title = $request->get('title');
		$post->body = $request->get('body');
		$post->slug = str_slug($post->title);
		$post->user_id = $request->user()->id;
		if($request->has('save'))
		{
		  $post->active = 0;
		  $message = 'Post saved successfully';            
		}            
		else 
		{
		  $post->active = 1;
		  $message = 'Post published successfully';
		}
		$post->save();
		return redirect('edit/'.$post->slug)->withMessage($message);
	}
	public function show($slug)
	{
		$post = Post::with(['comments' => function($query) {
							$query->orderBy('created_at','desc');	
							},'comments.user'])->where('slug',$slug)->first();
		if(!$post)
		{
		   return redirect('/')->withErrors('requested page not found');
		}
		// $comments = $post->comments;
		return view('posts.show')->withPost($post);//->withComments($comments);
	}
	public function edit(Request $request,$slug)
	{
		$post = Post::where('slug',$slug)->first();
		if($post && ($request->user()->id == $post->user_id || $request->user()->is_admin()))
		  return view('posts.edit')->with('post',$post);
		return redirect('/')->withErrors('you have not sufficient permissions');
	}
	public function update(Request $request)
	{
		$post_id = $request->input('post_id');
		$post = Post::find($post_id);
		if ($post && ($post->user_id == $request->user()->id || $request->user()->is_admin()))
		{
			$title = $request->input('title');
			$slug = str_slug($title);
			$duplicate = Post::where('slug',$slug)->first();
			if($duplicate)
			{
				if($duplicate->id != $post_id)
				{
					return redirect('edit/'.$post->slug)->withErrors('Title already exists.')->withInput();
				}
				else 
				{
					$post->slug = $slug;
				}
			}
			$post->title = $title;
			$post->body = $request->input('body');
			if($request->has('save'))
			{
				$post->active = 0;
				$message = 'Post saved successfully';
				$landing = 'edit/'.$post->slug;
			}            
			else
			{
				$post->active = 1;
				$message = 'Post updated successfully';
				$landing = $post->slug;
			}
			$post->save();
			return redirect($landing)->withMessage($message);
		}
		else
		{
			return redirect('/')->withErrors('you have not sufficient permissions');
		}
	}
	public function destroy(Request $request, $id)
	{
		$post = Post::find($id);
		if($post && ($post->user_id == $request->user()->id || $request->user()->is_admin()))
		{
			$post->delete();
			$data['message'] = 'Post deleted Successfully';
		}
		else 
		{
			$data['errors'] = 'Invalid Operation. You have not sufficient permissions';
		}
		return redirect('/')->with($data);
	}
}
