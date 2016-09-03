@extends('main')


@section('title', '| create New Post')

@section('stylesheet')
	<link href="{{ asset('css/parsley.css') }}" rel="stylesheet">
	{{ Html::style('css/select2.min.css') }}

	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

	<script>
		tinymce.init({
			selector: 'textarea',
			plugins: 'link code',
			menubar: false

		});
		
	</script>
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
				
				{{ Form::label('category_id','Category:') }}
				<select class="form-control" name="category_id">
					@foreach($categories as $category)
						<option value="{{ $category->id }}">{{ $category->name }}</option>					
					@endforeach
				</select>

				{{ Form::label('tags','Tags:') }}
				<select class="form-control select2-multi" name="tags[]" multiple="multiple">
					@foreach($tags as $tag)
						<option value="{{ $tag->id }}">{{ $tag->name }}</option>					
					@endforeach
				</select>

				<label name="body">Post Body:</label>
				<textarea name="body" class="form-control" ></textarea>

				<button type="submit" class="btn btn-success btn-lg btn-block" style="margin-top: 20px">Create Post</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
		</form>
			
		</div>
	</div>

@section('scripts')
	<script src="{{ asset('js/parsley.min.js') }}"></script>
	{{ Html::script('js/select2.min.js') }}
	<script type="text/javascript">
		$('#form').parsley();

	</script>
	<script type="text/javascript">
		$('.select2-multi').select2();
	</script>
	
	<!-- -HTML::script automatic go to the public folder->
@endsection

@endsection