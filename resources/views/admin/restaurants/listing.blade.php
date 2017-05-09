@extends('admin.layout')
@section('admin-title', 'Restaurants')



@section('admin-content')
   {!! Form::open(['url' => route('restaurants.index'), 'method' => 'GET', 'class' => 'form-inline']) !!}
        {!! Form::bsSelect('status', 'Filter status', [''  => '** ALL STATUSES **', 'p' => 'Pending', 'a' => 'Approved'], request()->input('status')) !!}
        {!! Form::bsText('name_keyword', 'Filter by name', request()->input('name_keyword')) !!}
        <button type="submit" class="btn btn-default">Filter</button>
    {!! Form::close() !!}
    
    <table class="table table-bordered" style="margin-top:10px">
        <thead>
            <tr class="active">
                <th></th>
                <th>Name</th>
                <th>Owner</th>
                <th>Created at</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items AS $i)
                <tr>
                    <td>
                        <a target="_blank" href="{{ route('restaurant.overview', ['id' => $i->id]) }}" class="btn btn-warning btn-sm"><i class="fa fa-mail-forward"></i></a>
                        <a href="{{ route('restaurants.edit', ['id' => $i->id] + request()->only(['account_type', 'name_keyword'])) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        
                        {!! Form::open(['url' => route('users.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}
                    </td>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->owner->fullname() }}</td>
                    <td>{{ date_create($i->created_at)->format('m/d/Y') }}</td>
                    <td>
                        @if($i->isApproved())
                            <span class="label label-success"><i class="fa fa-check"></i> Approved</span>
                        @else
                            <span class="label label-warning"><i class="fa fa-hourglass"></i> Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No users recorded</td>
                </tr>
            @endforelse
        </tbody>
    </table>
   {{ $items->appends(request()->only(['status', 'name_keyword']))->links() }}
@endsection