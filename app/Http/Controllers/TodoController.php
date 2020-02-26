<?php /** @noinspection PhpUndefinedNamespaceInspection */


namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use App\TodoService;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $todos = (new Todo)->findAllTodos();
        $searchedName = "";
        return view('index',compact("todos","searchedName"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TodoRequest $request)
    {
        $sentTodoAttributes= (new TodoService)->parseAttributes($request);
        (new Todo)->createTodo($sentTodoAttributes["name"],$sentTodoAttributes["end_date"]);

        return redirect('/todo');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return string
     */
    public function show(Request $request)
    {
        $searchedName = (new TodoService)->parseSearchedName($request);
        $todos = Todo::findTodosByContainsName($searchedName);

        return view("index", compact(["todos","searchedName"]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $todo = Todo::findTodoById($id);
        return view("edit")->with("todo",$todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TodoRequest $request, $id)
    {
        $todo = Todo::findTodoById($id);
        Todo::updateTodo($todo,$request);

        return redirect("/todo");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return string
     */
    public function destroy($id)
    {
        $todo = Todo::findTodoById($id);
        Todo::deleteTodo($todo);

        return redirect("/todo");
    }


    public function toggle(Request $request){
        $todo = Todo::findTodoById($request->all()["id"]);

        if ($todo->is_finished == 0){
            $todo->is_finished = 1;
        } else {
            $todo->is_finished = 0;
        }

        $todo->save();
        return redirect("/todo");
    }





    // User logic
    public function register()
    {
        return view ('register');
    }

    public function storeUser(UserRequest $request)
    {
        $sentAttributes = $request->all();

        User::create(['name'=>$sentAttributes['name'],'email'=>$sentAttributes['email'],'password'=>$sentAttributes['password']]);

        //login no logic to redirect to top
        return redirect('/todo');
    }

}
