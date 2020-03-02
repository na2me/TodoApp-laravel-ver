<?php

namespace Tests\Feature;

use App\Repository\TodoRepository;
use App\Repository\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $this->assertTrue((new TodoRepository)->findTodoById(1)->is_finished == 1);

        $response = $this->from('todo')->patch('todo/toggle',[
            'id'=>1
        ]);
        $this->assertTrue((new TodoRepository)->findTodoById(1)->is_finished == 0);


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

    public function testAuthMiddleware()
    {
        $response = $this->get('todo');
        $response->assertStatus(302)->assertRedirect('todo/login');

        $this->loginExampleUser();
        $response2 = $this->get('todo');
        $response2->assertStatus(200);
    }

    public function test404Handling()
    {
        $invalidUrl = '/todo/crate/INVALID';
        $response = $this->get($invalidUrl);
        $response->assertStatus(404);
        $response->assertSeeText('Sorry, no page found for the URL');
    }

    public function test405Handling()
    {
        $urlForPost = 'todo/store/user';
        $response = $this->get($urlForPost);
        $response->assertStatus(405);
        $response->assertSeeText('Sorry, the URL is invalid');
    }

    public function testQueryExceptionHandling()
    {
        //trying to create the exact same user to let QueryException occur
        $this->createExampleUser();
        $response = $this->createExampleUser();
        $response->assertStatus(500);
        $response->assertSeeText('The same user is already created before. Please check');
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
        return $this->from('/todo/register')->post('/todo/store/user',[
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

	$user = (new UserRepository)->findUserByEmailAndPassword('test@test.com',1234);

        return $response = $this->from('/login')
            ->post('/todo/login',[
                'email'=>$user->email,
                'password'=>$user->password,
            ]);
    }
}
