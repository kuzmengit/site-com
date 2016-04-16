@extends('site')
@section('title')
  @if($post)
    {{ $post->title }}
    @if(!Auth::guest() && ($post->user_id == Auth::user()->id || Auth::user()->is_admin()))
		<a href="{{ url('edit/'.$post->slug)}}" class="btn" style="float: right">Edit Post</a>
    @endif
  @else
    Page does not exist
  @endif
@endsection
@section('title-meta')
<p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a href="{{ url('/user/'.$post->user_id)}}">{{ $post->user->name }}</a></p>
@endsection
@section('content')
@if($post)
  <div>
    {!! $post->body !!}
  </div>    
  <div>
    <h2>Leave a comment</h2>
  </div>
  @if(Auth::guest())
    <p>Login to Comment</p>
  @else
    <div class="panel-body">
      <form method="post" action="/comment/add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="hidden" name="slug" value="{{ $post->slug }}">
        <div class="form-group">
          <textarea required="required" placeholder="Enter comment here" name = "body" class="form-control"></textarea>
        </div>
        <input type="submit" name='post_comment' class="btn btn-success" value = "Post"/>
      </form>
    </div>
  @endif
  <div>
    @if($post->comments)
    <ul style="list-style: none; padding: 0">
      @foreach($post->comments as $comment)
        <li class="panel-body">
          <div class="list-group">
            <div class="list-group-item">
              <h3>{{ $comment->user->name }}</h3>
              <p>{{ $comment->created_at->format('M d,Y \a\t h:i a') }}</p>
            </div>
            <div class="list-group-item">
              <p>{{ $comment->body }}</p>
            </div>
          </div>
        </li>
      @endforeach
    </ul>
    @endif
  </div>
@else
404 error
@endif
@endsection