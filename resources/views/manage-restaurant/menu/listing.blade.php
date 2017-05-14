@extends('manage-restaurant.layout', ['nav' => 'menu'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-book fa-fw"></i> Menu</h4>
			</div>
            <a href="{{ route('menu.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add new item</a>
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Name</th>
						<th>Category</th>
						<th>Price</th>
						<th>Availability</th>
					</tr>
				</thead>	
				<tbody>
					@forelse($items AS $i)
						<tr>
							<td>
								<a href="{{ route('menu.edit', ['id' => $i->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
								{!! Form::open(['url' => route('menu.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
								{!! Form::close() !!}
							</td>
							<td>{{ $i->name }}</td>
							<td>{{ implode(', ', $i->categories->pluck('name')->toArray()) }}</td>
							<td>{{ number_format($i->price, 2) }}</td>
							<td>
							@if($i->available)
								<span><i class="fa fa-check text-success"></i></span>
							@else
								<span><i class="fa fa-times text-warning"></i></span>
							@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center">No categories recorded</td>
						</tr>
					@endforelse
				</tbody>
            </table>
			
		</div>
	</div>
@endsection