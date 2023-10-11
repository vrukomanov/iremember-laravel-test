<?php

namespace Tests\Feature\Http\Controllers;

use App\Enum\TaskStatus;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    private ?string $token;
    public function setUp(): void
    {
        parent::setUp();
         $this->seed();

        $this->token = $this->getToken();
    }
    public function testGetTasksList(): void
    {
        $url = "/api/v1/tasks";

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('get', $url, []);

        $response->assertStatus(200);

        $tasks = $response->json();

        $this->assertCount(5, $tasks['data']['tasks']['data']);
    }

    public function testCreateNewTask(): void
    {
        $url = "/api/v1/tasks";
        $taskName = "Test task " . time();
        $params = [
            'description' => $taskName,
            'status' => TaskStatus::UNDONE->value
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('post', $url, $params);

        $response->assertStatus(200);

        $responseDuplicate = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('post', $url, $params);

        $responseDuplicate->assertStatus(400);
    }

    public function testShowSpecificTask(): void
    {
        $token = $this->getToken();
        $requesterTaskId = 1;
        $url = "/api/v1/tasks/" . $requesterTaskId;

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('get', $url);

        $response->assertStatus(200);

        $task = $response->json();

        $this->assertEquals($requesterTaskId, $task['data']['task']['id']);
    }

    public function testCheckTaskUpdate(): void
    {
        $requesterTaskId = 1;
        $url = "/api/v1/tasks/" . $requesterTaskId;

        $params = [
            'description' => "New task description",
            'status' => TaskStatus::DONE->value
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('put', $url, $params);

        $response->assertStatus(200);

        $responseGet = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('get', $url);

        $responseGet->assertStatus(200);

        $task = $responseGet->json();

        $this->assertEquals(
            $params['description'],
            $task['data']['task']['description']
        );

        //

        $paramsPartial = [
            'status' => TaskStatus::UNDONE->value
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('put', $url, $paramsPartial);

        $response->assertStatus(200);

        $responseGet = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('get', $url);

        $responseGet->assertStatus(200);

        $task = $responseGet->json();

        $this->assertEquals(
            $paramsPartial['status'],
            $task['data']['task']['status']
        );
    }

    public function testDeleteTask(): void
    {
        $requesterTaskId = 1;
        $url = "/api/v1/tasks";
        $deleteUrl = $url . "/" . $requesterTaskId;
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('delete', $deleteUrl);

        $response->assertStatus(200);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->json('get', $url);

        $response->assertStatus(200);

        $tasks = $response->json();

        $this->assertCount(4, $tasks['data']['tasks']['data']);
    }


    public function getToken(): string
    {
        $url = "/api/v1/login";
        $params = [
            'email' => 'test.email@noserver.com',
            'password' => "123456"
        ];

        $response = $this->post($url, $params, [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);

        $user = $response->json();

        return $user['data']['token'];
    }
}
