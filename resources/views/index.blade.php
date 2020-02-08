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
            <p>{{$todo->name}}</p>
            <p>{{$todo->start_date}}</p>
            <p>{{$todo->end_date}}</p>
            @if($todo->is_finished == 0)
                <p>Going</p>
            @else
                <p>Done</p>
            @endif
        @endforeach
    </div>


@endsection
