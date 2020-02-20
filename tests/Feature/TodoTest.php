<?php

namespace Tests\Feature;

use App\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $response = $this->get('/todo');

        $response->assertStatus(200);
    }


    public function testCreate()
    {
        $response = $this->createExampleTodo();
        $this->assertDatabaseHas('todos',['name'=>'TEST TODO']);
        $response->assertStatus(302)->assertRedirect('/todo');
    }


    public function testUpdate()
    {
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
        $this->createExampleTodo();

        $response = $this->from('todo/1/edit')->delete('todo/1');
        $response->assertStatus(302)->assertRedirect('/todo');

    }


    public function testToggle()
    {
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



    public function createExampleTodo(){
        return $this->from('todo/create')->post('/todo',[
            'name'=>'TEST TODO',
            'end_date'=>'2055-05-05'
        ]);
    }

}

//class TopTest extends TestCase
//{
//    use RefreshDatabase;
//    /**
//     * A basic feature test example.
//     *
//     * @return void
//     */
//    public function testTopVisit()
//    {
//        $response = $this->get('/signup');
//        $response->assertStatus(200);
//    }
//
//
//    public function testPost()
//    {
//        $response = $this->from('/signup')->post('/profile',
//            ['name'=>'テスト','email'=>'test@test.com','password'=>'test','area'=>'横須賀']);
//        $this->assertDatabaseHas('users',['email'=>'test@test.com']);
//        $response->assertStatus(200);
//    }
//}
