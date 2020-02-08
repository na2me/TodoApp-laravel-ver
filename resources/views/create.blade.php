@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Create new Todo</h1>
    </div>


    {!! Form::open(['method'=>"POST", "action"=>"TodoController@store", "files"=>true]) !!}
        <div class="container" id="formgroup">
        {!! Form::label('name', 'Name :') !!}
        {!! Form::text('name') !!}

        {!! Form::label('end_date', "End Date :") !!}
        {!! Form::date('end_date') !!}

        {!! Form::submit('Create') !!}
        </div>
    {!! Form::close() !!}




@endsection
