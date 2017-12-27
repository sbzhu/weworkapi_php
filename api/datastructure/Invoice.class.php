<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class InvoiceInfo
{
    public $card_id = null; // string
    public $begin_time = null; // string
    public $end_time = null; // string
    public $openid = null; // string
    public $type = null; // string
    public $payee = null; // string
    public $detail = null; // string
    public $user_info = null; // InvoiceUserInfo 
}

class InvoiceUserInfo
{ 
    public $fee = null; // string
    public $title = null; // string
    public $billing_time = null; // string
    public $billing_no = null; // string
    public $billing_code = null; // string
    public $info = null; // BillingInfo array
    public $fee_without_tax = null; // string
    public $tax = null; // string
    public $detail = null; // string
    public $pdf_url = null; // string
    public $reimburse_status = null; // string
    public $order_id = null; // string
    public $check_code = null; // string
    public $buyer_number = null; // string
}

class BillingInfo
{ 
    public $name = null; // string
    public $num = null; // string
    public $unit = null; // string
    public $fee = null; // string
    public $price = null; // string
}


class BatchUpdateInvoiceStatusReq
{ 
    public $openid = null; // string
    public $reimburse_status = null; // string
    public $invoice_list = null; // InvoiceItem array 
}
class InvoiceItem
{ 
    public $card_id = null; // string
    public $encrypt_code = null; // string
}

class BatchGetInvoiceInfoReq
{ 
    public $item_list = null; // InvoiceItem array 
}
class BatchGetInvoiceInfoRsp
{ 
    public $item_list = null; // InvoiceInfo array 
}

