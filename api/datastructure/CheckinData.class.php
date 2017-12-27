<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class CheckinDataList
{
    public $checkindata = null; // CheckinData array

    static public function ParseFromArray($arr)
    { 
        $info = new CheckinDataList();

        foreach($arr["checkindata"] as $item) { 
            $info->info[] = CheckinData::ParseFromArray($item);
        }

        return $info;
    }
}

class CheckinData
{
    public $userid = null; // string
    public $groupname = null; // string
    public $checkin_type = null; // string
    public $exception_type = null; // string
    public $checkin_time = null; // uint 
    public $location_title = null; // string 
    public $location_detail = null; // string 
    public $wifiname = null; // string 
    public $notes = null; // string 
    public $wifimac = null; // string 
    public $mediaids = null; // string array

    static public function ParseFromArray($arr)
    { 
        $info = new CheckinData();

        $info->userid = Utils::arrayGet($arr, "userid"); 
        $info->groupname = Utils::arrayGet($arr, "groupname"); 
        $info->checkin_type = Utils::arrayGet($arr, "checkin_type"); 
        $info->exception_type = Utils::arrayGet($arr, "exception_type"); 
        $info->checkin_time = Utils::arrayGet($arr, "checkin_time"); 
        $info->location_title = Utils::arrayGet($arr, "location_title"); 
        $info->location_detail = Utils::arrayGet($arr, "location_detail"); 
        $info->wifiname = Utils::arrayGet($arr, "wifiname"); 
        $info->notes = Utils::arrayGet($arr, "notes"); 
        $info->wifimac = Utils::arrayGet($arr, "wifimac"); 
        $info->mediaids = Utils::arrayGet($arr, "mediaids"); 

        return $info;
    }
}
