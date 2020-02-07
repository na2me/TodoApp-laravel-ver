@extends("layout/app")

@section("content")

    <h1>Todo List</h1>

    <div class="container" id="formgroup">
        <p>
            <label for="name">Name : </label>
            <input  type="text" id="name">
        </p>

        <p>
            <label for="start">Start : </label>
            <input type="date" id="start">
        </p>

        <p>
            <label for="end"> End : </label>
            <input type="date" id="end">
        </p>
    </div>

    @foreach($todo as $t)
        <p>{{$t->name}}</p>
        <p>{{$t->start_date}}</p>
        <p>{{$t->end_date}}</p>
        @if($t->is_finished == 0)
            <p>Going</p>
        @else
            <p>Done</p>
        @endif
    @endforeach




@endsection
