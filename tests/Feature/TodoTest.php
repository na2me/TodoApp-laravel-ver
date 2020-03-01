<?php

namespace Tests\Feature;

use App\Todo;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTopVisit()
    {
        $this->loginExampleUser();
        $response = $this->get('/todo');

        $response->assertStatus(200);
    }


    public function testCreate()
    {
        $this->loginExampleUser();
        $response = $this->createExampleTodo();
        $this->assertDatabaseHas('todos',['name'=>'TEST TODO']);
        $response->assertStatus(302)->assertRedirect('/todo');
    }


    public function testUpdate()
    {
        $this->loginExampleUser();
        $this->createExampleTodo();

        $response = $this->from('todo/1/edit')->put('todo/1',[
            'name'=>'TEST UPDATE LOGIC',
            'end_date'=>'2033-03-03',
            'id'=>1
            ]);
        $this->assertDatabaseHas('todos',['name'=>'TEST UPDATE LOGIC']);
        $response->assertStatus(302)->assertRedirect('/todo');
    }

    public function testDelete()
    {
        $this->loginExampleUser();
        $this->createExampleTodo();

        $response = $this->from('todo/1/edit')->delete('todo/1');
        $response->assertStatus(302)->assertRedirect('/todo');

    }


    public function testToggle()
    {
        $this->loginExampleUser();
        $this->createExampleTodo();

        $response = $this->from('todo')->patch('todo/toggle',[
            'id'=>1
        ]);
        $this->assertTrue(Todo::findTodoById(1)->is_finished == 1);

        $response = $this->from('todo')->patch('todo/toggle',[
            'id'=>1
        ]);
        $this->assertTrue(Todo::findTodoById(1)->is_finished == 0);


        $response->assertStatus(302)->assertRedirect('todo');
    }


    public function testSearch()
    {
        $this->loginExampleUser();
        $this->createExampleTodo();

        $response = $this->call('GET','/todo/search',[
           'name'=>'TEST'
        ]);
        $response->assertSee('TEST TODO');

        $response = $this->call('GET','/todo/search',[
            'name'=>'NOPE'
        ]);
        $response->assertDontSee('TEST TODO');

        $response->assertStatus(200);
    }


    public function testLogin()
    {
        $response = $this->loginExampleUser();
        $this->assertTrue(Auth::check());
        $response->assertStatus(302)->assertRedirect('todo');
    }

    public function testLogout()
    {
        $this->loginExampleUser();
        $this->assertTrue(Auth::check());
        $response = $this->get('/todo/logout');
        $response->assertStatus(302)->assertRedirect('/todo');

        $this->assertTrue(!Auth::check());
    }

    public function testMiddleware()
    {
        $response = $this->get('todo');
        $response->assertStatus(302)->assertRedirect('todo/login');

        $this->loginExampleUser();
        $response2 = $this->get('todo');
        $response2->assertStatus(200);
    }


    public function createExampleTodo()
    {
        return $this->from('todo/create')->post('/todo',[
            'name'=>'TEST TODO',
            'end_date'=>'2055-05-05'
        ]);
    }

    public function createExampleUser()
    {
        $this->from('/todo/register')->post('/todo/store/user',[
            'name'=>'test name',
            'email'=>'test@test.com',
            'password'=>1234,
        ]);
    }

    public function loginExampleUser()
    {
        $this->createExampleUser();
        $this->assertDatabaseHas('users',[
            'name'=>'test name',
            'email'=>'test@test.com',
            'password'=>1234,
        ]);
        $user = User::where('email','test@test.com')
            ->where('password',1234)->get()[0];

        return $response = $this->from('/login')
            ->post('/todo/login',[
                'email'=>$user->email,
                'password'=>$user->password,
            ]);
    }




}
