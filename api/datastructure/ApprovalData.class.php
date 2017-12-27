<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class ApprovalDataList 
{
    public $count = null; // uint
    public $total = null; // uint
    public $next_spnum = null; // uint
    public $data = null; // ApprovalData array

    static public function ParseFromArray($arr)
    { 
        $info = new ApprovalDataList();

        $info->count = Utils::arrayGet($arr, "count"); 
        $info->total = Utils::arrayGet($arr, "total"); 
        $info->next_spnum = Utils::arrayGet($arr, "next_spnum"); 
        foreach($arr["data"] as $item) { 
            $info->data[] = ApprovalData::ParseFromArray($item);
        }

        return $info;
    }
}

class ApprovalData 
{
    public $spname = null; // string
    public $apply_name = null; // string
    public $apply_org = null; // string
    public $approval_name = null; // string array
    public $notify_name = null; // string array
    public $sp_status = null; // uint
    public $sp_num = null; // uint
    public $mediaids = null; // string array 
    public $apply_time = null; // uint
    public $apply_user_id = null; // string
    public $expense = null; // ExpenseEvent 
    public $comm = null; // CommApplyEvent 
    public $leave = null; // LeaveEvent 

    static public function ParseFromArray($arr)
    { 
        $info = new CheckinData();

        $info->spname = Utils::arrayGet($arr, "spname"); 
        $info->apply_name = Utils::arrayGet($arr, "apply_name"); 
        $info->apply_org = Utils::arrayGet($arr, "apply_org"); 
        $info->approval_name = Utils::arrayGet($arr, "approval_name"); 
        $info->notify_name = Utils::arrayGet($arr, "notify_name"); 
        $info->sp_status = Utils::arrayGet($arr, "sp_status"); 
        $info->sp_num = Utils::arrayGet($arr, "sp_num"); 
        $info->mediaids = Utils::arrayGet($arr, "mediaids"); 
        $info->apply_time = Utils::arrayGet($arr, "apply_time"); 
        $info->apply_user_id = Utils::arrayGet($arr, "apply_user_id"); 

        if (array_key_exists("expense", $arr)) { 
            $info->expense = ExpenseEvent::ParseFromArray($arr["expense"]);
        }

        if (array_key_exists("comm", $arr)) { 
            $info->comm = CommApplyEvent::ParseFromArray($arr["comm"]);
        }

        if (array_key_exists("leave", $arr)) { 
            $info->leave = LeaveEvent::ParseFromArray($arr["leave"]);
        }

        return $info;
    }
}

class CommApplyEvent { 
    public $apply_data = null; // string TODO, 文档太烂，看不懂, 无法解析！！待相关人员更新

    static public function ParseFromArray($arr)
    { 
        $info = new CommApplyEvent();

        $info->apply_data = Utils::arrayGet($arr, "apply_data"); 

        return $info;
    }
}

class ExpenseEvent { 
    public $expense_type = null; // int 
    public $reason = null; // string 
    public $item = null; // ExpenseItem array

    static public function ParseFromArray($arr)
    { 
        $info = new ExpenseEvent();

        $info->expense_type = Utils::arrayGet($arr, "expense_type"); 
        $info->reason = Utils::arrayGet($arr, "reason"); 
        foreach($arr["item"] as $item) {
            $info->item[] = ExpenseItem::ParseFromArray($item);
        }

        return $info;
    }
}

class ExpenseItem { 
    public $expenseitem_type = null; // int 
    public $time = null; // int 
    public $sums = null; // int 
    public $reason = null; // string 

    static public function ParseFromArray($arr)
    { 
        $info = new ExpenseItem();

        $info->expenseitem_type = Utils::arrayGet($arr, "expenseitem_type"); 
        $info->time = Utils::arrayGet($arr, "time"); 
        $info->sums = Utils::arrayGet($arr, "sums"); 
        $info->reason = Utils::arrayGet($arr, "reason"); 

        return $info;
    }
}

class LeaveEvent { 
    public $timeunit = null; // int 
    public $leave_type = null; // int 
    public $start_time = null; // int 
    public $end_time = null; // int 
    public $duration = null; // int 
    public $reason = null; // string 

    static public function ParseFromArray($arr)
    { 
        $info = new LeaveEvent();

        $info->timeunit = Utils::arrayGet($arr, "timeunit"); 
        $info->leave_type = Utils::arrayGet($arr, "leave_type"); 
        $info->start_time = Utils::arrayGet($arr, "leave_type"); 
        $info->end_time = Utils::arrayGet($arr, "end_time"); 
        $info->duration = Utils::arrayGet($arr, "duration"); 
        $info->reason = Utils::arrayGet($arr, "reason"); 

        return $info;
    }
}
