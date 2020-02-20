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
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function testStore(){

        $this->assertTrue(true);
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
