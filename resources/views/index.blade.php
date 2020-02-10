@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Todo List</h1>
    </div>

    {!! Form::open(["method"=>"GET", "action"=>"TodoController@show", "files"=>true]) !!}
    <div class="container" id="formgroup">
        {!! Form::label("name", "Name : ") !!}
        {!! Form::text("name", $searchedName) !!}

        {!! Form::submit("Search") !!}
    </div>
    {!! Form::close() !!}
    <br>
    <div class="container">
        @foreach($todos as $todo)
            <p>Name : {{$todo->name}}</p>
            <p>Start Date : {{$todo->start_date}}</p>
            <p>End Date : {{$todo->end_date}}</p>
            {!! Form::open(["method"=>"PATCH","action"=>"TodoController@toggle", "files"=>true]) !!}
            @if($todo->is_finished == 0)
                {!! Form::submit("Status : Going") !!}
            @else
                {!! Form::submit("Status : Done") !!}
            @endif
            {!! Form::close() !!}
            <br>
            <a href="{{ route('todo.edit', $todo->id) }}">Edit</a>
            <br>
            <br>
            <br>
        @endforeach
    </div>


@endsection
