@extends('manage-restaurant.layout', ['nav' => 'overview'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-user-circle fa-fw"></i> Overview</h4>
			</div>
			
			{!! Form::model($restaurant, ['url' => url('/my-restaurant'), 'method' =>'PATCH']) !!}
				{!! Form::bsText('name', 'Restaurant Name', $restaurant->name) !!}
				{!! Form::bsSelect('categories[]', 'Category', $categories,  $restaurant->category_ids, ['class' => 'form-control', 'multiple' => 'true']) !!}
				{!! Form::bsText('address', 'Address') !!}
				{!! Form::bsText('contact_number', 'Contact Number') !!}
				{!! Form::bsTextarea('description', 'Description') !!}
				{!! Form::bsTextarea('policy', 'Policy') !!}
				<hr>
				<button type="submit" class="btn btn-success btn-block">Update</button>
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