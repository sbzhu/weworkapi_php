<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class SendWorkWxRedpackReq
{ 
    public $nonce_str = null; // string
    public $sign = null; // string
    public $mch_billno = null; // string
    public $mch_id = null; // string
    public $wxappid = null; // string
    public $sender_name = null; // string
    public $agentid = null; // uint 
    public $sender_header_media_id = null; // string
    public $re_openid = null; // string
    public $total_amount = null; // int 
    public $wishing = null; // string
    public $act_name = null; // string
    public $remark = null; // string
    public $scene_id = null; // string
    public $workwx_sign = null; // string
}
class SendWorkWxRedpackRsp
{ 
    public $return_code = null; // string
    public $return_msg = null; // string
    public $sign = null; // string
    public $result_code = null; // string
    public $mch_billno = null; // string
    public $mch_id = null; // string
    public $wxappid = null; // string
    public $re_openid = null; // string
    public $total_amount = null; // int 
    public $send_listid = null; // string
    public $sender_name = null; // string
    public $sender_header_media_id = null; // string
}

class QueryWorkWxRedpackReq
{ 
    public $nonce_str = null; // string
    public $sign = null; // string
    public $mch_billno = null; // string
    public $mch_id = null; // string
    public $appid = null; // string
}
class QueryWorkWxRedpackRsp
{ 
    public $return_code = null; // string
    public $return_msg = null; // string
    public $sign = null; // string
    public $result_code = null; // string
    public $mch_billno = null; // string
    public $mch_id = null; // string
    public $detail_id = null; // string
    public $status = null; // string
    public $send_type = null; // string
    public $total_amount = null; // int 
    public $reason = null; // string
    public $send_time = null; // string
    public $wishing = null; // string
    public $remark = null; // string
    public $act_name = null; // string
    public $openid = null; // string
    public $amount = null; // int 
    public $rcv_time = null; // string
    public $sender_name = null; // string
    public $sender_header_media_id = null; // string
}

class PayWwSptrans2PocketReq
{ 
    public $appid = null; // string
    public $mch_id = null; // string
    public $device_info = null; // string
    public $nonce_str = null; // string
    public $sign = null; // string
    public $partner_trade_no = null; // string
    public $openid = null; // string
    public $check_name = null; // string
    public $re_user_name = null; // string
    public $amount = null; // int 
    public $desc = null; // string
    public $spbill_create_ip = null; // string
    public $workwx_sign = null; // string
    public $ww_msg_type = null; // string
    public $act_name = null; // string
}
class PayWwSptrans2PocketRsp
{ 
    public $return_code = null; // string
    public $return_msg = null; // string
    public $appid = null; // string
    public $mch_id = null; // string
    public $device_info = null; // string
    public $nonce_str = null; // string
    public $result_code = null; // string
    public $partner_trade_no = null; // string
    public $payment_no = null; // string
    public $payment_time = null; // string
}
