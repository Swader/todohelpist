<?php

namespace Todohelpist\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use Todohelpist\User;

class Todoist
{
    /** @var string */
    protected $baseUrl;

    /** @var Client */
    protected $client;

    public function __construct($test = "http://todoist.com/API")
    {
        $this->baseUrl = $test;
        $this->client = new Client();
    }

    public function getUser(array $params, $endPoint = 'login')
    {
        if (!array_has($params, 'email')) {
            abort(500, "The email is missing in the API request - cannot proceed!");
        }
        $response = $this->client->get($this->baseUrl . '/' . $endPoint, [
            'query' => $params
        ]);

        $token = $this->checkForToken($response);

        $user = User::where('todoist_token', '=', $token)->where('email', '=', $params['email'])->first();

        if (!$user) {
            $user = new User();
            $user->todoist_token = $token;
            $user->email = $params['email'];
            $user->projects = serialize($this->getProjects($token));
            $user->save();
        }

        return $user;
    }

    public function getProjects($token)
    {
        $response = $this->client->get($this->baseUrl . '/' . 'getProjects', [
            'query' => ['token' => $token]
        ]);
        return $response->json();
    }

    protected function checkForToken(Response $response)
    {
        $json = $response->json();
        $exceptions = [
            'LOGIN_ERROR' => 'Invalid credentials',
            'INTERNAL_ERROR' => 'Todoist was unable to verify your identity - the problem is on their end. Try later',
            'EMAIL_MISMATCH' => 'Invalid credentials',
            'ACCOUNT_NOT_CONNECTED_WITH_GOOGLE' => 'This account is not connected with Todoist via Google'
        ];
        if (is_string($json) && isset($exceptions[$json])) {
            throw new \Exception($exceptions[$json]);
        } else {
            if (!isset($json['token'])) {
                throw new \Exception('Token not returned by Todoist API.');
            }
        }
        return $json['token'];

    }

}
