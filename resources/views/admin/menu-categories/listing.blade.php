@extends('admin.layout')
@section('admin-title', 'Menu Categories')

@section('admin-content')
    <a href="{{ route('menu-categories.create') }}" class="btn btn-default pull-right" style="margin-bottom:10px"><i class="fa fa-plus"></i> Create new menu category</a>
    <table class="table table-bordered">
        <thead>
            <tr class="active">
                <th></th>
                <th>Name</th>
                <th>Description</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse($items AS $i)
                <tr>
                    <td>
                        <a href="{{ route('menu-categories.edit', ['id' => $i->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                        {!! Form::open(['url' => route('menu-categories.destroy', ['id' => $i->id]), 'onclick' => 'javascript:return confirm("Are you sure?")', 'method' => 'DELETE']) !!}

                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        {!! Form::close() !!}
                    </td>
                    <td>{{ $i->name }}</td>
                    <td>{{ $i->description }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No menu categories recorded</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection