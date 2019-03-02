<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $table = 'calendar_events';

    protected $fillable = ['id', 'title', 'notes', 'event_date'];

    public function addNewEvent($request, $companyId)
    {
        $newEvent = new CalendarEvent();
    	$newEvent->company_id = $companyId;
    	$newEvent->title = $request->title;
    	$newEvent->notes = $request->notes;
    	$newEvent->event_date = date('Y-m-d', strtotime($request->date));
    	$newEvent->save();

    	if($newEvent) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
    }

    public function getCompanyEvent($companyId)
    {
        
        $getListOfEvent = CalendarEvent::select('title','notes','event_date as start')
                                        ->where('company_id', $companyId)
                                        ->get();

        if(count($getListOfEvent) > 0) {

            foreach ($getListOfEvent as $key => $value) {
                $dd=date('Y, m, d',strtotime($value['start']));
                $getListOfEventList[]=array('title'=>$value['title'],'start'=>$dd);
            }
                
            return $getListOfEventList;
        } else {
            return null;
        }
    }
}
