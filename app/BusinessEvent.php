<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BusinessEvent extends Model
{
  public function business(){
    return $this->belongsTo(Business::class);
  }

  public function formattedStart(){
    if($this->type === "event"){
      return Carbon::parse($this->start)->toDayDateTimeString();
    } else{
      return Carbon::parse($this->start)->toFormattedDateString();
    }
  }

  public function formattedEnd(){
    if($this->type === "event"){
      return Carbon::parse($this->end)->toDayDateTimeString();
    } else{
      return Carbon::parse($this->end)->toFormattedDateString();
    }
  }

  public function outputCalendarFile(){
    $event = array(
      'id' => $this->id,
      'title' => $this->name,
      'description' => $this->description,
      'datestart' => $this->start,
      'dateend' => $this->end,
      'address' => "{$this->business->address} {$this->business->address2} {$this->business->city}, {$this->business->state} {$this->business->zip}"
    );

    // Build the ics file
    $ical = 'BEGIN:VCALENDAR
    VERSION:2.0
    PRODID:-//hacksw/handcal//NONSGML v1.0//EN
    CALSCALE:GREGORIAN
    BEGIN:VEVENT
    DTEND:' . date('Ymd\This', strtotime($event['dateend'])) . '
    UID:' . md5($event['title']) . '
    DTSTAMP:' . date('Ymd\This', time()) . '
    LOCATION:' . addslashes($event['address']) . '
    DESCRIPTION:' . addslashes($event['description']) . '
    URL;VALUE=URI: '. env('APP_URL') . '/business/' . $this->business->slug . '
    SUMMARY:' . addslashes($event['title']) . '
    DTSTART:' . date('Ymd\This', strtotime($event['datestart'])) . '
    END:VEVENT
    END:VCALENDAR';

    $ical = preg_replace('/^ {4}(?! )/m', '', $ical);
    return preg_replace('~(*BSR_ANYCRLF)\R~', "\r\n", $ical);
  }
}
