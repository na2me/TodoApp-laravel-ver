@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Register new User</h1>
    </div>

    @if($exception)
        <p>The same user is already created before. Please check...</p>
    @endif

    @foreach($errors->all() as $error)
        <i>{{$error}}</i>
        <br>
    @endforeach


    {!! Form::open(['method'=>"POST", "action"=>"TodoController@storeUser", "files"=>true]) !!}
    <div class="container" id="formgroup">
        {!! Form::label('name', 'Name :') !!}
        {!! Form::text('name') !!}
        <br>
        {!! Form::label('email', "E-mail :") !!}
        {!! Form::email('email') !!}
        <br>
        {!! Form::label('password', "Password :") !!}
        {!! Form::password('password') !!}
        <br>
        {!! Form::submit('Register') !!}
        <br>
    </div>
    {!! Form::close() !!}




@endsection
