<?php

class CalendarController extends BaseController {

    /**
     * Initializer.
     *
     * @return \CalendarController
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get User Google Calendar
     *
     */
    public function postSetEvent()
    {
		$data         = Input::all();
		$user_id      = $data['user_id'];
		$summary      = $data['summary'];
		$start_time   = Carbon::createFromFormat( 'YmdHis', $data['start_time'] );
		$end_time     = Carbon::createFromFormat( 'YmdHis', $data['end_time'] );
		$restaurant_id = $data['restaurant_id'];
        
        $start_time_google = date( "Y-m-d\TH:i:s.000+08:00",strtotime( $start_time ) );
        $end_time_google   = date( "Y-m-d\TH:i:s.000+08:00",strtotime( $end_time ) );


        $gAuth       = UserAuth::where('service', 'google')->where('user_id', $user_id)->first();
        $extraParams = json_decode($gAuth->extraParams);

        $getToken = array( 
                'access_token' => $gAuth->accessToken,
                'token_type'   => $extraParams->token_type,
                'expires_in'   => '604800',
                'created'      => $gAuth->endOfLife - 604800
                );
        
        $save_event = new Events;
        $client = new Google_Client();

        $client->setAccessToken(json_encode($getToken));

        $event = new Google_Service_Calendar_Event();
        $event->setSummary($summary);
        $save_event->summary = $summary;
        
        if( isset($data['location']) ) {
        	$event->setLocation($data['location']);
        	$save_event->location = $data['location'];
        }
            
        $start = new Google_Service_Calendar_EventDateTime();

        $start->setDateTime($start_time_google);
        $event->setStart($start);
        $save_event->start_time = $start_time;

        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($end_time_google);
        $event->setEnd($end);
        $save_event->end_time = $end_time;

        $event_attendee = new Google_Service_Calendar_EventAttendee();
        $event_attendee->setEmail( User::find($user_id)->email );

        if( isset($data['attendees']) ) { 

            foreach (json_decode($data['attendees']) as $attendee) {
                $event_attendee->setEmail( $attendee );                
            }

            $event->attendees = array($event_attendee);
            $save_event->attendees = $data['attendees'];
        }

        $calendarService = new Google_Service_Calendar($client);
        $recurringEvent = $calendarService->events->insert('primary', $event);

		$event_id                    = $recurringEvent->getId();
		$save_event->google_event_id = $event_id;
		$save_event->user_id         = $user_id;
		$save_event->restaurant_id   = $restaurant_id;
        
        $save_event->save();

        
        echo 'create event and save successfully!';


    }


}