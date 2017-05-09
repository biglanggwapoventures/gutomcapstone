@extends('manage-restaurant.layout', ['nav' => 'blog'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-pencil fa-fw"></i> Blog </h4>
			</div>
			@if($data->id)
				{!! Form::model($data, ['url' => route('blog.update', ['id' => $data->id]), 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
				<div class="row">
					<div class="col-sm-4 col-sm-offset-8">
						<img src="{{ $data->photo }}" alt="" class="img-thumbnail img-responsive">
					</div>
				</div>
			@else
				{!! Form::open(['url' => route('blog.store'), 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			@endif
				{!! Form::bsFile('photo', 'Post Photo') !!}
				{!! Form::bsText('title', 'Post Title') !!}
                {!! Form::bsTextarea('body', 'Content') !!}
				<div class="checkbox">
					<label>{!! Form::checkbox('published') !!} Publish this post</label>
				</div>
				<hr>
				<button type="submit" class="btn btn-success btn">Save</button>
                {!! link_to_route('blog.index', 'Back', null, ['class' => 'pull-right btn btn-default']) !!}
			{!! Form::close() !!}
			
		</div>
	</div>
@endsection