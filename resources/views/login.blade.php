@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Login</h1>
    </div>

    @foreach($errors->all() as $error)
        <i>{{$error}}</i>
        <br>
    @endforeach


    {!! Form::open(['method'=>"POST", "action"=>"TodoController@authenticate", "files"=>true]) !!}
    <div class="container" id="formgroup">
        {!! Form::label('email', 'Email :') !!}
        {!! Form::email('email') !!}
        <br>
        {!! Form::label('password', "Password :") !!}
        {!! Form::password('password') !!}
        <br>
        {!! Form::submit('Login') !!}
    </div>
    {!! Form::close() !!}




@endsection
