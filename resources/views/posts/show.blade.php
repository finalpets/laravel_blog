@extends('main')

@section('tittle', '| View Post')

@section('content')

<div class="row">
	<div class="col-md-8">
		<h1>{{ $post->title }}</h1>			
		<p class="lead">{{ $post->body }} </p>
		<hr>
		<div class="tags">
			@foreach($post->tags as $tag)
				<span class="label label-default">{{ $tag->name }} </span>
			@endforeach
		</div>
	</div>

	<div class="col-md-4">
		<div class="well">
			<dl class="dl-horizontal">
			  <label>Url Slug:</label>
			  <p><a href="{{ url('blog/'.$post->slug) }}"> {{ url('blog/'.$post->slug) }} </a></p>
			  <!--or use this -->
			  <!-- route('blog.single', $post->slug) -->

			</dl>

			<dl class="dl-horizontal">
			  <label>Category:</label>
			  <p>{{ $post->category->name }}</p>
			  <!--or use this -->
			  <!-- route('blog.single', $post->slug) -->

			</dl

			<dl class="dl-horizontal">
			  <label>Created At:</label>
			  <p>{{ date('M j, Y h:ia',strtotime($post->created_at)) }}</p>
			</dl>

			<dl class="dl-horizontal">
			  <label>Last Updated:</label>
			  <p>{{ date('M j, Y h:ia',strtotime($post->updated_at)) }}</p>
			</dl>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-6">
				<a href="{{ route('posts.edit',$post->id) }}" class="btn btn-primary btn-block">Edit</a>
			</div>

			<div class="col-sm-6">
				{!! Form::open(['route' => ['posts.destroy',$post->id] , 'method' => 'DELETE']) !!}

				{!! Form::submit('Delete',['class' => 'btn btn-danger btn-block']) !!}
				{!! Form::close() !!}
			</div>
			<div class="row">
				<div class="col-md-12">
					{{ Html::linkRoute('posts.index', '<< See All Posts', [] ,['class' => 'btn btn-default btn-block btn-h1-spacing' ]) }}
				</div>			
				
			</div>
			
		</div>
		
	</div>
</div>

@endsection