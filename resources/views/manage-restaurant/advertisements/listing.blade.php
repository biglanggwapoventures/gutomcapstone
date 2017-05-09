@extends('manage-restaurant.layout', ['nav' => 'promos'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-bookmark-o fa-fw"></i> Advertisements</h4>
			</div>
            <a href="{{ route('advertisements.create') }}" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add new advertisement</a>
			<table class="table">
				<thead>
					<tr>
						<th></th>
						<th>Title</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
					</tr>
				</thead>	
				<tbody>
					@forelse($items AS $i)
						<tr>
							<td>
								<a href="{{ route('advertisements.edit', ['id' => $i->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
								{!! Form::open(['url' => route('advertisements.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
									<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
								{!! Form::close() !!}
							</td>
							<td>{{ $i->title }}</td>
							<td>{{ date_create_immutable($i->start_date)->format('F d, Y') }}</td>
							<td>{{ date_create_immutable($i->end_date)->format('F d, Y') }}</td>
							<td>
								@if($i->status === 'PENDING')
									<span class="text-warning"><i class="fa fa-time"></i> Pending</span>
								@elseif($i->status === 'REJECTED')
									<span class="text-danger"><i class="fa fa-times"></i> Rejected</span>
								@else
									<span class="text-success"><i class="fa fa-check"></i> Pending</span>
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="text-center">No advertisements recorded</td>
						</tr>
					@endforelse
				</tbody>
            </table>
			
		</div>
	</div>
@endsection