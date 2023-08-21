<?php

namespace Tests\Feature;

use AmnaJahanzaib\RemoteUserService\RemoteUserService ;
use AmnaJahanzaib\UsersManagement\DTOs\UserDTO;
use Http\Mock\Client;
use Tests\TestCase;


class RemoteUserServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGetExistingUserApi()
    {
        $response = $this->getJson('/api/users/1');
        $response->assertStatus(200);
        $response->assertJson(['id' => 1,'first_name'=>'George','last_name'=>'Bluth']);
    }

    public function testGetNonExistingUserApi()
    {
    
        $response = $this->getJson('/api/users/456');

        $response->assertStatus(404);
        $response->assertJson(['error' => 'User not found']);
    }
    
    public function testCreateUserApi()
    {
        $response = $this->postJson('/api/users', ['name' => 'John', 'job' => 'Developer']);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id']);
    }

    public function testCreateUserWithoutDataApi()
    {
        $response = $this->postJson('/api/users', ['name' => '', 'job' => '']);

        $response->assertStatus(422);
    }

    public function testAllUsersApi()
    {
        $response = $this->getJson('/api/users');
        $response->assertStatus(200);
        $response->assertJson([
            'current_page' => 1,
        ]);
    }
    
    public function testAllUsersByPageApi()
    {
        $response = $this->getJson('/api/users/?page=2');
        $response->assertStatus(200);
        $response->assertJson([
            'current_page' => 2,
        ]);
    }
    

}
