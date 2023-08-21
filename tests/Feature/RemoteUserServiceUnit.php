<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use AmnaJahanzaib\RemoteUserService\DTOs\UserDTO;
use AmnaJahanzaib\RemoteUserService\RemoteUserService;
use Mockery;

class RemoteUserServiceUnit extends TestCase
{
    private $userService;

    public function setUp(): void
    {
        parent::setUp();

        // Create an instance of the UserService class
        $this->userService = new RemoteUserService();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testGetUserById()
    {

        $user = $this->userService->getUserById(1);

        $this->assertInstanceOf(UserDTO::class, $user);
        $this->assertEquals(1, $user->getId());
        $this->assertEquals('George', $user->getFirstName());
        $this->assertEquals('Bluth', $user->getLastName());
    }


    public function testCreateUser()
    {

        $userService = new RemoteUserService();
        // Arrange
        $name = 'John Doe';
        $job = 'Developer';

        // Create a mock Http facade response for a successful request
        $response = Mockery::mock('overload:' . Http::class);
        $response->shouldReceive('post')->andReturnSelf();
        $response->shouldReceive('json')->andReturn(['id' => 123]);

        // Act
        $result = $this->userService->createUser($name, $job);

        // Assert
        $this->assertEquals(['id' => true], $result->getData(true));
        $this->assertEquals(201, $result->status());
    }
    public function testCreateUserFailure()
    {
        // Arrange
        $name = '';
        $job = '';

        // Create a mock Http facade response for a failed request
        $response = Mockery::mock('overload:' . Http::class);
        $response->shouldReceive('post')->andReturnSelf();
        $response->shouldReceive('json')->andReturn([]);
        $response->shouldReceive('successful')->andReturn(false);
        $response->shouldReceive('status')->andReturn(400);

        // Act
        $result = $this->userService->createUser($name, $job);

        // Assert
        $this->assertEquals(['error' => 'User creation failed'], $result->getData('error'));
    }

    public function testGetPaginatedUsersSuccess()
    {
        // Arrange
        $page = 1;

        // Create a mock Http facade response for a successful request
        $response = Mockery::mock('overload:' . Http::class);
        $response->shouldReceive('get')->andReturnSelf();
        $response->shouldReceive('json')->andReturn([
            'data' => [
                UserDTO::fromArray(['id' => 1, 'first_name' => 'George', 'last_name' => 'Bluth']),
                UserDTO::fromArray(['id' => 2, 'first_name' => 'Janet', 'last_name' => 'Weaver']),
                UserDTO::fromArray(['id' => 3, 'first_name' => 'Emma', 'last_name' => 'Wong']),
                UserDTO::fromArray(['id' => 4, 'first_name' => 'Eve', 'last_name' => 'Holt']),
                UserDTO::fromArray(['id' => 5, 'first_name' => 'Charles', 'last_name' => 'Morris']),
                UserDTO::fromArray(['id' => 6, 'first_name' => 'Tracey', 'last_name' => 'Ramos']),
            ],
            'total' => 12,
            'page' => $page,
            'per_page' => 6,
            'total_pages' => 2,
        ]);

        // Act
        $result = $this->userService->getPaginatedUsers($page);

        // Assert
        $expectedResponse = [
            'current_page' => $page,
            'last_page' => 2,
            'per_page' => 6,
            'total' => 12,
            'data' => [
                ['id' => 1, 'first_name' => 'George', 'last_name' => 'Bluth'],
                ['id' => 2, 'first_name' => 'Janet', 'last_name' => 'Weaver'],
                ['id' => 3, 'first_name' => 'Emma', 'last_name' => 'Wong'],
                ['id' => 4, 'first_name' => 'Eve', 'last_name' => 'Holt'],
                ['id' => 5, 'first_name' => 'Charles', 'last_name' => 'Morris'],
                ['id' => 6, 'first_name' => 'Tracey', 'last_name' => 'Ramos'],
            ],
        ];
        $this->assertEquals($expectedResponse, $result->getData(true));
        $this->assertEquals(200, $result->status());
    }
}
