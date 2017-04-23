@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><small><i class="fa fa-plus"></i></small> Adding New User
        </h3>
    </div>
</div>

<div class="row">
<div class="col-md-9">
    {{ Form::open() }}

    <div class="form-group">
        <label for="username">Username</label>
        {{ Form::text('username','',array('class'=>'form-control','placeholder'=>'Choose unique username')) }}
    </div>

    <div class="form-group">
        <label for="username">Fullname</label>
        {{ Form::text('fullname','',array('class'=>'form-control','placeholder'=>'New user fullname')) }}
    </div>

    <div class="form-group">
        <label for="username">Email</label>
        {{ Form::text('email','',array('class'=>'form-control','placeholder'=>'New user email')) }}
    </div>

    <div class="form-group">
        <label for="username">Password</label>
        {{ Form::password('password',array('class'=>'form-control','placeholder'=>'New user password')) }}
    </div>


    <div class="form-group">
        {{ Form::submit('Add User',array('class'=>'btn btn-success')) }}
    </div>


    {{ Form::close() }}
</div>
</div>
@stop
