@extends('admin.layout')
@section('admin-title', 'Restaurant Advertisements')

@section('admin-content')
   {!! Form::open(['url' => route('restaurant-ads.index'), 'method' => 'GET', 'class' => 'form-inline']) !!}
            {!! Form::bsSelect('status', 'Filter by status', ['PENDING' => 'Pending', 'APPROVED' => 'Approved', 'REJECTED' => 'Rejected'], request()->input('status')) !!}
        <button type="submit" class="btn btn-default">Filter</button>
    {!! Form::close() !!}
    
    <table class="table table-bordered" style="margin-top:10px">
        <thead>
            <tr class="active">
                <th></th>
                <th>Title</th>
                <th>Duration</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items AS $i)
                <tr>
                    <td>
                        <a href="{{ route('restaurant-ads.edit', ['id' => $i->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        {!! Form::open(['url' => route('restaurant-ads.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}
                    </td>
                    <td>{{ $i->title }}</td>
                    <td>{{ date_create($i->start_date)->format('m/d/Y') }} - {{ date_create($i->end_date)->format('m/d/Y')  }}</td>
                    <td>{{ $i->restaurant->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No advertisements recorded</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection