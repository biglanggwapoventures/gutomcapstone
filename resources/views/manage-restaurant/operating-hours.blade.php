@extends('manage-restaurant.layout', ['nav' => 'ophours'])

@section('form')
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h4><i class="fa fa-clock-o fa-fw"></i> Operating Hours</h4>
			</div>
			{!! Form::open(['url' => url('/my-restaurant/operating-hours'), 'method' => 'PATCH']) !!}
				<table class="table ophours" style="table-layout:fixed">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Opening</th>
                            <th>Closing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = [1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday']
                        @endphp
                        @foreach($days  AS $day => $name)
                        <tr>
                            <td>{{ $name }}</td>
                            <td>
                                {!! Form::text("days[{$day}][opening]", $restaurant->opening($day), ['class' => 'form-control timepicker']) !!}
                                @if($errors->has("days.{$day}.opening"))
                                    <small class="text-danger">{{ $errors->first("days.{$day}.opening") }}</small>
                                @endif
                            </td>
                            <td>
                                {!! Form::text("days[{$day}][closing]", $restaurant->closing($day), ['class' => 'form-control timepicker']) !!}
                                @if($errors->has("days.{$day}.closing"))
                                    <small class="text-danger">{{ $errors->first("days.{$day}.closing") }}</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
				<hr>
				<button type="submit" class="btn btn-success btn-block">Update</button>
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.timepicker').timepicker({
            disableFocus: true,
            defaultTime: false
        });
    })
</script>
@endpush