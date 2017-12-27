<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class CheckinOption 
{
    public $info = null; // CheckinInfo array

    static public function ParseFromArray($arr)
    { 
        $info = new CheckinOption();

        foreach($arr["info"] as $item) { 
            $info->info[] = CheckinInfo::ParseFromArray($item);
        }

        return $info;
    }
}

// ---------------------------------------------------------------------------

class CheckinInfo
{ 
    public $userid = null; // string
    public $group = null; // CheckinGroup

    static public function ParseFromArray($arr)
    { 
        $info = new CheckinInfo();

        $info->userid = Utils::arrayGet($arr, "userid"); 
        $info->group = CheckinGroup::ParseFromArray($arr["group"]);

        return $info;
    }
}

class CheckinGroup { 
    public $grouptype = null; // uint,  1 固定  2自定义  3自由签到
    public $groupid = null; // uint,  
    public $checkindate = null; // CheckinDate array 
    public $spe_workdays = null; // SpeWorkDays array 
    public $spe_offdays = null; // SpeOffDays array 
    public $sync_holidays = null; // bool, default true
    public $groupname = null; // string
    public $need_photo = null; // bool 
    public $wifimac_infos = null; // WifiMacInfo array
    public $note_can_use_local_pic = null; // bool
    public $allow_checkin_offworkday = null; // bool
    public $allow_apply_offworkday = null; // bool
    public $loc_infos = null; // LocInfo  array

    public static function ParseFromArray($arr)
    {
        $info = new CheckinGroup();

        $info->grouptype = Utils::arrayGet($arr, "grouptype"); 
        $info->groupid = Utils::arrayGet($arr, "groupid"); 
        foreach($arr["checkindate"] as $item) { 
            $info->checkindate[] = CheckinDate::ParseFromArray($item);
        }
        foreach($arr["spe_workdays"] as $item) { 
            $info->spe_workdays[] = SpeWorkDays::ParseFromArray($item);
        }
        foreach($arr["spe_offdays"] as $item) { 
            $info->spe_offdays[] = SpeOffDays::ParseFromArray($item);
        }
        $info->sync_holidays = Utils::arrayGet($arr, "sync_holidays"); 
        $info->groupname = Utils::arrayGet($arr, "groupname"); 
        $info->need_photo = Utils::arrayGet($arr, "need_photo"); 
        foreach($arr["wifimac_infos"] as $item) { 
            $info->wifimac_infos[] = WifiMacInfo::ParseFromArray($item);
        }
        $info->note_can_use_local_pic = Utils::arrayGet($arr, "note_can_use_local_pic"); 
        $info->allow_checkin_offworkday = Utils::arrayGet($arr, "allow_checkin_offworkday"); 
        $info->allow_apply_offworkday = Utils::arrayGet($arr, "allow_apply_offworkday"); 
        foreach($arr["loc_infos"] as $item) { 
            $info->loc_infos[] = LocInfo::ParseFromArray($item);
        }

        return $info;
    }
}

class CheckinTime { 
    public $work_sec = null; // int 
    public $off_work_sec = null; // int 
    public $remind_work_sec = null; // int 
    public $remind_off_work_sec = null; // int 

    public static function ParseFromArray($arr)
    {
        $info = new CheckinTime();

        $info->work_sec = Utils::arrayGet($arr, "work_sec");
        $info->off_work_sec = Utils::arrayGet($arr, "off_work_sec");
        $info->remind_work_sec = Utils::arrayGet($arr, "remind_work_sec");
        $info->remind_off_work_sec = Utils::arrayGet($arr, "remind_off_work_sec");

        return $info;
    }
}

class CheckinDate { 
    public $workdays = null; // int array
    public $checkintime = null; // CheckinTime array
    public $flex_time = null; // int
    public $noneed_offwork = null; // bool 
    public $limit_aheadtime = null; // uint 

    public static function ParseFromArray($arr)
    {
        $info = new CheckinDate();

        $info->workdays = Utils::arrayGet($arr, "workdays"); 
        foreach($arr["checkintime"] as $item) { 
            $info->checkintime[] = CheckinTime::ParseFromArray($item);
        }
        $info->flex_time = Utils::arrayGet($arr, "flex_time"); 
        $info->noneed_offwork = Utils::arrayGet($arr, "noneed_offwork"); 
        $info->limit_aheadtime = Utils::arrayGet($arr, "limit_aheadtime"); 

        return $info;
    }
}

class SpeWorkDays { 
    public $timestamp = null; // uint 
    public $notes = null; // string
    public $checkintime = null; // CheckinTime array 

    public static function ParseFromArray($arr)
    {
        $info = new SpeWorkDays();

        $info->timestamp = Utils::arrayGet($arr, "timestamp");
        $info->notes = Utils::arrayGet($arr, "notes");

        foreach($arr["checkintime"] as $item) { 
            $info->checkintime[] = CheckinTime::ParseFromArray($item);
        }

        return $info;
    }
}

class SpeOffDays { 
    public $timestamp = null; // uint 
    public $notes = null; // string
    public $checkintime = null; // CheckinTime array 

    public static function ParseFromArray($arr)
    {
        $info = new SpeOffDays();

        $info->timestamp = Utils::arrayGet($arr, "timestamp");
        $info->notes = Utils::arrayGet($arr, "notes");

        foreach($arr["checkintime"] as $item) { 
            $info->checkintime[] = CheckinTime::ParseFromArray($item);
        }

        return $info;
    }
}

class WifiMacInfo { 
    public $wifiname = null; // string
    public $wifimac = null; // string

    public static function ParseFromArray($arr)
    {
        $info = new WifiMacInfo();

        $info->wifiname = Utils::arrayGet($arr, "wifiname");
        $info->wifimac = Utils::arrayGet($arr, "wifimac");

        return $info;
    }
}

class LocInfo { 
    public $lat = null; // uint
    public $lng = null; // uint
    public $loc_title = null; // string
    public $loc_detail = null; // string
    public $distance = null; // uint

    public static function ParseFromArray($arr)
    {
        $info = new LocInfo(); 

        $info->lat = Utils::arrayGet($arr, "lat");
        $info->lng = Utils::arrayGet($arr, "lng");
        $info->loc_title = Utils::arrayGet($arr, "loc_title");
        $info->loc_detail = Utils::arrayGet($arr, "loc_detail");
        $info->distance = Utils::arrayGet($arr, "distance");

        return $info;
    }
}
