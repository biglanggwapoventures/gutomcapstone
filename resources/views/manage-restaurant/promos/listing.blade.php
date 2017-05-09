@extends('manage-restaurant.layout', ['nav' => 'promos'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-bullhorn fa-fw"></i> Promos</h4>
			</div>
            <a href="{{ route('promos.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add new promo</a>
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Title</th>
						<th>Start Date</th>
						<th>End Date</th>
					</tr>
				</thead>	
				<tbody>
					@forelse($items AS $i)
						<tr>
							<td>
								<a href="{{ route('promos.edit', ['id' => $i->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
								{!! Form::open(['url' => route('promos.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
								{!! Form::close() !!}
							</td>
							<td>{{ $i->title }}</td>
							<td>{{ date_create_immutable($i->start_date)->format('F d, Y') }}</td>
							<td>{{ date_create_immutable($i->end_date)->format('F d, Y') }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center">No promos recorded</td>
						</tr>
					@endforelse
				</tbody>
            </table>
			
		</div>
	</div>
@endsection