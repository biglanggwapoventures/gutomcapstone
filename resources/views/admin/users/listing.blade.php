@extends('admin.layout')
@section('admin-title', 'Users')

@section('admin-content')
   {!! Form::open(['url' => route('users.index'), 'method' => 'GET', 'class' => 'form-inline']) !!}
        {!! Form::bsSelect('account_type', 'Filter by account type', [''  => '** ALL ACCOUNT TYPES **', 'USER' => 'Regular User', 'OWNER' => 'Restaurant Owner'], request()->input('account_type')) !!}
        {!! Form::bsText('name_keyword', 'Filter by name', request()->input('name_keyword')) !!}
        <button type="submit" class="btn btn-default">Filter</button>
    {!! Form::close() !!}
    
    <table class="table table-bordered" style="margin-top:10px">
        <thead>
            <tr class="active">
                <th></th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Account Type</th>
                <th>Registered at</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items AS $i)
                <tr>
                    <td>
                        <a href="{{ route('users.edit', ['id' => $i->id] + request()->only(['account_type', 'name_keyword'])) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        {!! Form::open(['url' => route('users.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}
                    </td>
                    <td>{{ $i->fullname() }}</td>
                    <td>{{ $i->username }}</td>
                    <td>{{ $i->email }}</td>
                    <td>{{ $i->roleDescription() }}</td>
                    <td>{{ date_create($i->created_at)->format('m/d/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No users recorded</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $items->appends(request()->only(['account_type', 'name_keyword']))->links() }}
@endsection