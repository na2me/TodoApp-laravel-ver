<?php /** @noinspection PhpUndefinedNamespaceInspection */


namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Repository\TodoRepository;
use Illuminate\Http\Request;
use App\TodoService;
use App\Http\Requests\TodoRequest;
use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;

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
        $todos = (new UserRepository)->findUserById($userId)->todos;
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
        $userId = Auth::user()->id;
        (new TodoRepository)->createTodo($request['name'],$request["end_date"],$userId);

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
        $todos = (new TodoRepository)->findTodosByContainsName($searchedName);

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
        $todo = (new TodoRepository)->findTodoById($id);
        return view('edit',compact('todo'));
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
        $todo = (new TodoRepository)->findTodoById($id);
        (new TodoRepository)->updateTodo($todo,$request);

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
        $todo = (new TodoRepository)->findTodoById($id);
        (new TodoRepository)->deleteTodo($todo);

        return redirect("/todo");
    }


    public function toggle(Request $request){
        $todo = (new TodoRepository)->findTodoById($request->all()["id"]);

        $todo->is_finished = (new TodoService)->toggleStatus($todo->is_finished);

        (new TodoRepository)->saveTodo($todo);
        return redirect("/todo");
    }

    public function register()
    {
        $exception = null;
        return view ('register',compact('exception'));
    }

    public function storeUser(UserRequest $request)
    {
        (new UserRepository)->createUser($request['name'],$request['email'],$request['password']);

        (new TodoService)->loginUser($request['email'],$request['password']);

        return redirect('todo');
    }

    public function login()
    {
        return view('login');
    }

    public function authenticate(LoginRequest $request)
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
