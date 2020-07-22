<?php
include_once "errorCode.php";

/**
 * JsonParse class
 *
 * 提供提取消息格式中的密文及生成回复消息格式的接口.
 */
class JsonParse
{

	/**
	 * 提取出json数据包中的加密消息
	 * @param string $jsontext 待提取的json字符串
	 * @return string 提取出的加密消息字符串
	 */
	public function extract($jsontext)
	{
		try {
			$encrypt = json_decode($jsontext, true)['Encrypt'];
			return array(0, $encrypt);
		} catch (Exception $e) {
			print $e . "\n";
			return array(ErrorCode::$ParseXmlError, null);
		}
	}

	/**
	 * 生成json消息
	 * @param string $encrypt 加密后的消息密文
	 * @param string $signature 安全签名
	 * @param string $timestamp 时间戳
	 * @param string $nonce 随机字符串
	 */
	public function generate($encrypt, $signature, $timestamp, $nonce)
	{
		$format = '{"encrypt": "%s", "msgsignature": "%s", "timestamp": "%s", "nonce": "%s"}';
		return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
	}

}

?>
