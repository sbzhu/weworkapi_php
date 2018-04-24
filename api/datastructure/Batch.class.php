<?php
include_once(__DIR__."/../../utils/Utils.class.php");

class CallBack { 
    public $url = null; // string
    public $token = null; // string
    public $encodingaeskey = null; // string
} // class CallBack

class BatchJobArgs { 
    public $media_id = null; // string 
    public $to_invite = null; // bool, 是否邀请新建的成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日）
    public $callback = null; // CallBack 
} // class BatchJobRequest

class BatchJobResult
{
	const STATUS_PENDING = 1;
	const STATUS_STARTED = 2;
	const STATUS_FINISHED = 3;

	public $status = null; // uint, 任务状态，整型，1表示任务开始，2表示任务进行中，3表示任务已完成
	public $type = null; // string, 操作类型，目前分别有：sync_user(增量更新成员) replace_user(全量覆盖成员) replace_party(全量覆盖部门)
	public $total = null; // uint, 任务运行总条数
	public $percentage = null; // uint, 目前运行百分比，当任务完成时为100
	public $result = null; // 参考文档
} // BatchJobResult

class Batch { 

    static public function CheckBatchJobArgs($batchJobArgs)
    {
        Utils::checkNotEmptyStr($batchJobArgs->media_id, "media_id");
    } 

    static public function Array2BatchJobResult($arr)
    {
        $batchJobResult = new BatchJobResult(); 

        $batchJobResult->status = utils::arrayGet($arr, "status");
        $batchJobResult->type = utils::arrayGet($arr, "type");
        $batchJobResult->total = utils::arrayGet($arr, "total");
        $batchJobResult->percentage = utils::arrayGet($arr, "percentage");
        $batchJobResult->result = utils::arrayGet($arr, "result");

        return $batchJobResult;
    }

	static public function IsJobFinished($batchJobResult)
	{
		return !is_null($batchJobResult->status) && $batchJobResult->status == BatchJobResult::STATUS_FINISHED;
	}
} // class Batch
