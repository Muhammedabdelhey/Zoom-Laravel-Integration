this repo for anyone try integrate zoom with laravel by server to server OAuth
go to App\Services\ZoomSerivce you will find 6 faunctions 
1- "createAccessToken" that will expire after hour
2- "getAccessToken" from session if not expire if expire will create new and store it
3-"makeMeeting' that take meeting data and meeting settings (optional)
4-"getMeeting" take meeting id
5-"deleteMeeting" take meeting id
6-"updateMeeting" take meeting id,meeting data and meeting settings (optional)
