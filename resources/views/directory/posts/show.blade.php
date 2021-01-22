@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">User {{ $user->name }}</div>
                    <div class="card-body">

                        <a href="{{ url('/admin/users/index') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Edit post"><button class="btn btn-secondary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        <button type="button" id="user_id" data-id="{{$user->id}}" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalMessagesUsers">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Sent messages</button>
                        <button type="button" id="user_id_to" data-cid="{{$user->id}}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalMessagesUsers2">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Messages received</button>
                        <form method="POST" action="{{ url('/admin/users/delete' . '/' . $user->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete post" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $user->id }}</td>
                                    </tr>
                                    <tr><th> Name </th><td> {{ $user->name }} </td></tr><tr><th> Email </th><td> {{ $user->email }} </td></tr>
                                    <tr><th> Avatar </th><td><img src="{{ asset("$user->avatar") }}" style="width:100px"></td></tr>
                                    <tr><th> Password </th><td> {{ $user->password }} </td></tr><tr><th> Roles </th><td> <b style="color: dodgerblue">{{ $user->roles }}</b> </td></tr>
                                    <tr><th> Active status </th><td> @if($user->active_status == "unlock")
                                                <b style="color: lawngreen">{{ $user->active_status }}</b>
                                                @else
                                                <b style="color: orangered">{{ $user->active_status }}</b>
                                                @endif
                                                </td></tr>
                                    <tr><th> Created at </th><td> {{date_format( $user->created_at, 'H:i:s | d/m/Y')}} </td></tr><tr><th> Update at </th><td> {{date_format( $user->updated_at, 'H:i:s | d/m/Y')}} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('.directory.posts.modal_messages')
@endsection
