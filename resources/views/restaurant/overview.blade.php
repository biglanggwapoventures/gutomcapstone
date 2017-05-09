@extends('restaurant.layout', compact('restaurant'))

@section('section')
<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <div class="box-content">
                <h1 class="tag-title">What are we...</h1>
                <hr />
                <p>{{ $restaurant->description }}</p>
            </div>
        </div>
        <div class="box">
            <div class="box-content">
                <h1 class="tag-title">Our policy</h1>
                <hr />
                <p>{{ $restaurant->policy }}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 ">
        <div class="box">
            <div class="box-content">
                <h1 class="tag-title">Operating Hours</h1>
                <hr />
                <dl class="dl-horizontal">
                    <dt>Address</dt>
                    <dd>{{ $restaurant->address }}</dd>
                    <dt>Contact Number</dt>
                    <dd>{{ $restaurant->contact_number }}</dd>
                    <dt>Restaurant Type</dt>
                    <dd>
                        @foreach($restaurant->categories AS $c)
                            <span class="label label-danger"><i class="fa fa-cutlery"></i> {{ $c->name }}</span>
                        @endforeach
                    </dd>
                </dl>
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
                                {{ $restaurant->opening($day) ? date_create_from_format('H:i:s', $restaurant->opening($day))->format('h:i A') : '-' }}
                            </td>
                            <td>
                                {{ $restaurant->closing($day) ? date_create_from_format('H:i:s', $restaurant->closing($day))->format('h:i A') : '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection