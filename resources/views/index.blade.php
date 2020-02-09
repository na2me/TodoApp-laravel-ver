@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Todo List</h1>
    </div>

    <div class="container" id="formgroup">
        <form action="/todo" method="post">
            <div>
                <label for="name">Name : </label>
                <input  type="text" id="name">
            </div>

            <div>
                <label for="start">Start : </label>
                <input type="date" id="start">
            </div>

            <div>
                <label for="end"> End : </label>
                <input type="date" id="end">
            </div>

            <input type="submit" value="Search">
        </form>

    </div>

    <br>

    <div class="container">
        @foreach($todos as $todo)
            <p>Name : {{$todo->name}}</p>
            <p>Start Date : {{$todo->start_date}}</p>
            <p>End Date : {{$todo->end_date}}</p>
            @if($todo->is_finished == 0)
                <p>Status : Going</p>
            @else
                <p>Status : Done</p>
            @endif
            <a href="{{ route('todo.edit', $todo->id) }}">Edit</a>
            <br>
            <br>
            <br>
        @endforeach
    </div>


@endsection
