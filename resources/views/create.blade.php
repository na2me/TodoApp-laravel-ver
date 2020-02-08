@extends("layout/app")

@section("content")

    <div class="container">
        <h1>Create new Todo</h1>
    </div>


    <div class="container" id="formgroup">

    <form action="/todo" method="post">
        <div>
            <label for="name">Name : </label>
            <input type="text" id="name">
        </div>

        <div>
            <label for="end_date">End Date : </label>
            <input type="date" id="end_date">
        </div>

        <div>
            <input type="submit" value="Create">
        </div>


    </form>


    </div>




@endsection
