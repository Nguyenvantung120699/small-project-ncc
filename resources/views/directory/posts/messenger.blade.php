@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($messages as $item)
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">

                        <a href="{{ url('/admin/users/index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/users/edit') }}" title="Edit post"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th>messages ID</th><td>{{ $item->id }}</td>
                                    </tr>
                                    <tr><th> receiver </th><td> {{ $item->Users->name }} </td></tr>
                                    <tr><th> body </th><td>"{{$item->body}}"</td></tr>
                                    <tr><th> Created at </th><td> {{date_format( $item->created_at, 'H:i:s | d/m/Y')}} </td></tr>
                                    </tbody>
                                </table>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection


