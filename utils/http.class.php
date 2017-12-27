<?php

class HttpUtils
{
	// 
	// public:
	// 

	/**
	 * http get
	 * @param string $url
	 * @return http response body
	 */
	static public function httpGet($url)
	{
        $ch = curl_init();

		HttpUtils::_setSSLOpts($ch, $url);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        return HttpUtils::_exec($ch);
	}

	/**
	 * http post
	 * @param string $url
	 * @param string or dict $postData
	 * @return http response body
	 */
	static public function httpPost($url, $postData)
	{
		$ch = curl_init();

		HttpUtils::_setSSLOpts($ch, $url);
		
		if (is_string($param) || $post_file) {
			$strPOST = $param;
		} else {
			$aPOST = array();
			foreach($param as $key=>$val){
				$aPOST[] = $key."=".urlencode($val);
			}
			$strPOST =  join("&", $aPOST);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		if(PHP_VERSION_ID >= 50500){
			curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, FALSE);
		}
		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}

	// 
	// private:
	// 

	static private function _setSSLOpts($ch, $url)
	{
		if (stripos($url,"https://") !== false) {
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
	    }
	}

	static private function _exec($url)
	{
		$output = curl_exec($ch);

		$status = curl_getinfo($ch);
	    if(intval($status["http_code"]) != 200) {
			$output = false;
	    }

        curl_close($ch);

		return $output;
	}

	static private function _postData2String($postData)
	{
		if (is_string($postData))
			return $postData;
		elseif (is_array($postData)) {
			$fields = array();
			foreach ($postData as $key => $val) {
				$fields[] = $key . "=" . urlencode($val);
			}
			return join("&", $fields);
		}

		throw 
	}
}
