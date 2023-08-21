<?php

namespace AmnaJahanzaib\RemoteUserService;

use AmnaJahanzaib\RemoteUserService\DTOs\UserDTO;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class RemoteUserService
{
    protected $apiBaseUrl = 'https://reqres.in/api/';
    protected $getUserEndpoint = 'users/{id}';
    protected $getUsersEndpoint = 'users';
    protected $createUserEndpoint = 'users';


    public function getUserById($id)
    {
        $response = Http::get($this->apiBaseUrl . str_replace('{id}', $id, $this->getUserEndpoint));

        if ($response->successful()) {
            $userData = $response->json();
            $userDTO = UserDTO::fromArray($userData['data']);
            return $userDTO;
        } else {
            return response()->json(['error' => 'User not found', 'statusCode'=>$response->status()],$response->status());
        }
    }

    public function getPaginatedUsers($page = 1)
    {
        $response = Http::get($this->apiBaseUrl . $this->getUsersEndpoint, [
            'page' => $page,
           
        ]);
        if ($response->successful()) {
            $usersData = $response->json();

            $users = collect($usersData['data'])->map(function ($userData) {
                return UserDTO::fromArray($userData);
            });

         //   can be done with LengthAwarePaginator
            $totalUsers = $usersData['total'];
                $currentPage = $usersData['page'];
                $lastPage = $usersData['total_pages'];

                $paginatedResponse = [
                    'current_page' => $currentPage,
                    'last_page' => $lastPage,
                    'per_page' => $usersData['per_page'],
                    'total' => $totalUsers,
                    'data' => $users,
                ];
                return response()->json($paginatedResponse);

       
            // $paginator = new LengthAwarePaginator(
            //     $users,
            //     $usersData['total'],
            //     $usersData['per_page'],
            //     $usersData['page']
            // );

            // return $paginator;
        }
        else {
            return response()->json(['error' => 'Failed to retrieve users','statusCode'=> $response->status()],$response->status());
        }
    }

    public function createUser($name, $job)
    {
        if($name=='' || $job=='') {
            return response()->json(['error' => 'User creation failed']);
        }

        $response = Http::post($this->apiBaseUrl . $this->createUserEndpoint, [
            'name' => $name,
            'job' => $job,

        ]);

        if ($response->successful()) {
            $userData = $response->json();
            $userId = $userData['id'];
            
            return response()->json(['id' => $userId], $response->status());
        } else {
            return response()->json(['error' => 'User creation failed']);
        }
    }
}