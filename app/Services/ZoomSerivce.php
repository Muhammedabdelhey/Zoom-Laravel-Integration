<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class ZoomSerivce
{
    public function __construct(private Client $client)
    {
    }
    public function createAccessToken()
    {
        try {
            // Set the request parameters
            $url = 'https://zoom.us/oauth/token';
            $credentials = base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET'));
            $headers = [
                'Authorization' => 'Basic ' . $credentials,
            ];
            $params = [
                'grant_type' => 'account_credentials',
                'account_id' => env('ZOOM_ACCOUNT_ID'),
            ];
            // Send the POST request
            $response = $this->client->post($url, [
                'headers' => $headers,
                'form_params' => $params,
            ]);
            // Get the response body
            $body = $response->getBody();
            // Parse the JSON response
            $data = json_decode($body, true);
            // Get the access token
            $accessToken = $data['access_token'];
            return $accessToken;
        } catch (Exception $e) {
            return response(["Exception" => $e->getMessage(), 'message' => 'when try create token An error occurred'], 500);
        }
    }
    public function getAccessToken()
    {
        $token = session()->get('zoomtoken');
        if (!$token || now()->gt($token['expiry'])) {
            // Token is still valid
            $accessToken = $this->createAccessToken();
            session()->put('zoomtoken', [
                'value' => $accessToken,
                'expiry' => now()->addHour() // Set the expiry for the new token
            ]);
        }
        $accessToken = session()->get('zoomtoken')['value'];
        return $accessToken;
    }
    public function makeMeeting(array $meetingData, array $meetingSettings = null)
    {
        try {
            $accessToken = $this->getAccessToken();
            $data = $meetingData;
            if ($meetingSettings != null) {
                $data = array_merge($meetingData, ['settings' => $meetingSettings]);
            }
            // dd($data);
            $response = $this->client->post('https://api.zoom.us/v2/users/me/meetings', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);
            $meeting = json_decode($response->getBody(), true);
            return $meeting;
        } catch (Exception $e) {
            return response(["Exception" => $e->getMessage(), 'message' => 'An error occurred Create'], 500);
        }
    }
    public function getMeeting($meetingId)
    {
        try {
            $accessToken = $this->getAccessToken();
            // Make a GET request to retrieve the meeting data
            $response = $this->client->get("https://api.zoom.us/v2/meetings/{$meetingId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);
            return $meetingData = json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return response(["Exception" => $e->getMessage(), 'message' => 'An error occurred'], 500);
        }
    }

    public function deleteMeeting($meetingId)
    {
        try {
            $accessToken = $this->getAccessToken();
            $response = $this->client->delete("https://api.zoom.us/v2/meetings/{$meetingId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
            ]);
            return response(['message' => 'Meeting Deleted '], 200);
        } catch (Exception $e) {
            return response(["Exception" => $e->getMessage(), 'message' => 'An error occurred'], 500);
        }
    }
    public function updateMeeting($meetingID, array $meetingData, array $meetingSettings = null)
    {
        try {
            $accessToken = $this->getAccessToken();
            $data = $meetingData;
            if ($meetingSettings != null) {
                $data = array_merge($meetingData, ['settings' => $meetingSettings]);
            }
            // dd($data);
            $response = $this->client->patch("https://api.zoom.us/v2/meetings/{$meetingID}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => $data
            ]);
            return $this->getMeeting($meetingID);
        } catch (Exception $e) {
            return response(["Exception" => $e->getMessage(), 'message' => 'An error occurred'], 500);
        }
    }
}
