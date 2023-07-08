 I've created a repository that provides a seamless integration between Zoom and Laravel using a server-to-server OAuth approach. The code can be found in the App\Services\ZoomService file.

Here's an overview of the six essential functions available in the ZoomService:

createAccessToken: Generates a fresh access token that will expire after one hour.

getAccessToken: Retrieves the access token from the session if it is still valid. If the token has expired, a new one is generated and stored in the session.

makeMeeting: Enables the creation of a Zoom meeting by providing the necessary meeting data and optional settings.

getMeeting: Retrieves information about a specific meeting using the meeting ID.

deleteMeeting: Allows you to remove a meeting by providing its corresponding ID.

updateMeeting: Updates an existing meeting with new data and optional settings, using the meeting ID.

you should add 

ZOOM_ACCOUNT_ID

ZOOM_CLIENT_ID

ZOOM_CLIENT_SECRET

on env file
