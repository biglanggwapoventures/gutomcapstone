@extends('manage-restaurant.layout', ['nav' => 'blog'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-pencil fa-fw"></i> Blog</h4>
			</div>
            <a href="{{ route('blog.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add new blog post</a>
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Title</th>
						<th>Date Posted</th>
						<th>Published</th>
					</tr>
				</thead>	
				<tbody>
					@forelse($items AS $i)
						<tr>
							<td>
								<a href="{{ route('blog.edit', ['id' => $i->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
								{!! Form::open(['url' => route('blog.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
								{!! Form::close() !!}
							</td>
							<td>{{ $i->title }}</td>
							<td>{{ date_create_immutable($i->created_at)->format('F d, Y') }}</td>
							<td>{!! $i->published ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-warning"></i>' !!}</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center">No blog posts recorded</td>
						</tr>
					@endforelse
				</tbody>
            </table>
			
		</div>
	</div>
@endsection