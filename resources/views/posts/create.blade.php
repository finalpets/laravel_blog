@extends('main')


@section('title', '| create New Post')

@section('stylesheet')
	<link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
		<h1>Create New Post</h1>
		<hr>
		<form id="form" action="{{  route('posts.store') }}" method="post">
			
				<label name="title">Title:</label>
				<input type="text" class="form-control" name="title" value="" required="" maxlength="255">

				{{ Form::label('slug', 'Slug:') }}
				{{ Form::text('slug', null, array('class' => 'form-control', 'required' => '', 'minlength' => '5','maxlength' => '255')) }}

				<label name="body">Post Body:</label>
				<textarea name="body" class="form-control" required="" ></textarea>

				<button type="submit" class="btn btn-success btn-lg btn-block" style="margin-top: 20px">Create Post</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
		</form>
			
		</div>
	</div>

@section('scripts')
	<script src="{{ asset('js/parsley.min.js') }}"></script>
	<script type="text/javascript">
		$('#form').parsley();
	</script>
@endsection

@endsection