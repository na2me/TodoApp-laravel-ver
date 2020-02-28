<?php /** @noinspection PhpUndefinedNamespaceInspection */


namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use App\TodoService;
use App\Http\Requests\TodoRequest;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $todos = User::find($userId)->todos;
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
        $userId = Auth::user()->id;
        (new Todo)->createTodo($sentTodoAttributes["name"],$sentTodoAttributes["end_date"],$userId);

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
        User::create(['name'=>$request['name'],'email'=>$request['email'],'password'=>$request['password']]);

        (new TodoService)->loginUser($request['email'],$request['password']);

        return redirect('todo');
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        (new TodoService)->loginUser($request['email'],$request['password']);

        return redirect('todo');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('todo');
    }

}
