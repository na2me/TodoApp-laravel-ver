@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Edit Todo</h1>
    </div>
<br>
    {!! Form::model($todo,["method"=>"PUT","action"=>["TodoController@update", $todo->id]]) !!}
    {{csrf_field()}}
    <div class="container" id="formgroup">
        {!! Form::label("name", "Name : ") !!}
        {!! Form::text("name", $todo->name) !!}
<br>
        {!! Form::label("endDate", "End Date : ") !!}
        {!! Form::date("date", $todo->end_date) !!}
<br>
        {!! Form::hidden("id", $todo->id) !!}
        {!! Form::submit("Update") !!}
    </div>
    {!! Form::close() !!}

@endsection
