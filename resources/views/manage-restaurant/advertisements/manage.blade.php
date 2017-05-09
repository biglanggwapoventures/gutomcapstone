@extends('manage-restaurant.layout', ['nav' => 'promos'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-bookmark-o fa-fw"></i> Advertisements</h4>
			</div>
			@if($data->id)
				{!! Form::model($data, ['url' => route('advertisements.update', ['id' => $data->id]), 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
				<div class="row">
					<div class="col-sm-4 col-sm-offset-8">
						<img src="{{ $data->photo }}" alt="" class="img-thumbnail img-responsive">
					</div>
				</div>
			@else
				{!! Form::open(['url' => route('advertisements.store'), 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
			@endif
			
				<div class="row">
                    <div class="col-sm-6">
                        {!! Form::bsFile('photo', 'Photo') !!}
                    </div>
                </div>
				{!! Form::bsText('title', 'Advertisement Title') !!}
				<div class="row">
					<div class="col-sm-6">
						{!! Form::bsDate('start_date', 'Start Date') !!}
					</div>
					<div class="col-sm-6">
						{!! Form::bsDate('end_date', 'End Date') !!}
					</div>
				</div>
				
				
				{!! Form::bsTextarea('description', 'Advertisement Description') !!}
                
				<hr>
				<button type="submit" class="btn btn-success btn">Save</button>
                {!! link_to_route('advertisements.index', 'Back', null, ['class' => 'pull-right btn btn-default']) !!}
			{!! Form::close() !!}
			
		</div>
	</div>
@endsection



@push('scripts')
<script type="text/javascript" src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('select').select2();
    })
</script>
@endpush