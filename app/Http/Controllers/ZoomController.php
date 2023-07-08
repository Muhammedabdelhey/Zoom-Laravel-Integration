<?php

namespace App\Http\Controllers;

use App\Services\ZoomSerivce;

class ZoomController extends Controller
{
    public function __construct(private ZoomSerivce $zoom)
    {
    }
    public function getMeeting($meetingId)
    {
        return $this->zoom->getMeeting($meetingId);
    }
    public function makeMeeting()
    {
        $meetingData = [
            'topic' => 'Sample Meeting',
            'type' => 2,
            'start_time' => '2023-07-06T20:00:00Z',
            'duration' => 60,
            'timezone' => 'Africa/Cairo',
        ];
        $meetingSettings = [
            'join_before_host' => true,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'audio' => 'both',
            'auto_recording' => "local",
            'alternative_hosts' => '',
            'waiting_room' => false,
            // 'host_email' => 'ex@gmail.com', account should be Licensed to change host
        ];
        return $this->zoom->makeMeeting($meetingData, $meetingSettings);
    }

    public function deleteMeeting($meetingId)
    {

        return $this->zoom->deleteMeeting($meetingId);
    }
    public function updateMeeting($meetingId)
    {
        $meetingData = [
            'topic' => 'Update Meeting',
            'type' => 2,
            'start_time' => '2023-07-06T20:00:00Z',
            'duration' => 60,
            'timezone' => 'Africa/Cairo',
        ];
        $meetingSettings = [
            'join_before_host' => true,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'audio' => 'both',
            'auto_recording' => "local",
            'alternative_hosts' => '',
            'waiting_room' => false,
            // 'host_email' => 'ex@gmail.com', account should be Licensed to change host
        ];
        return $this->zoom->updateMeeting($meetingId, $meetingData, $meetingSettings);
    }
}
