@extends('temp_layouts.form')

@section('title')
    User @parent
@stop

@section('form-heading')
    User Edit @parent
@stop

@section('form-body')
    {!! Form::model($model, ['route' => ['user.update', $model], 'method' => 'PUT']) !!}
        <div class="form-group">
            {!! Form::label('username', 'Username') !!}
            {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Enter Username']) !!}
            @if (\Session::has('error'))
                <span style="font-size:13px; color:red;">{{ \Session::get('error')->first('username') }}</span>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email']) !!}
            @if (\Session::has('error'))
                <span style="font-size:13px; color:red;">{{ \Session::get('error')->first('email') }}</span>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) !!}
            @if (\Session::has('error'))
                <span style="font-size:13px; color:red;">{{ \Session::get('error')->first('name') }}</span>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Password') !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password']) !!}
            @if (\Session::has('error'))
                <span style="font-size:13px; color:red;">{{ \Session::get('error')->first('password') }}</span>
            @endif
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', 'Password Confirmation') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Enter Password Confirmation']) !!}
            @if (\Session::has('error'))
                <span style="font-size:13px; color:red;">{{ \Session::get('error')->first('password_confirmation') }}</span>
            @endif
        </div>
        <div class="form-group">
            {!! Form::checkbox('is_admin', true) !!}
            {!! Form::label('is_admin', 'Admin') !!}
        </div>
        <div class="form-group">
            {!! Form::checkbox('is_active', true, true) !!}
            {!! Form::label('is_active', 'Active') !!}
        </div>
        <button type="submit" class="btn btn-default">Submit Button</button>
        <button type="reset" class="btn btn-default">Reset Button</button>
        <a href="{{ route('user.index') }}" class="btn btn-default">Back</a>
    {!! Form::close() !!}
@stop