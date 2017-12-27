<?php

include_once(__DIR__."/error.inc.php");

class Utils { 

    static public function notEmptyStr($var)
    {
        return is_string($var) && ($var != "");
    }

    static public function checkNotEmptyStr($var, $name)
    {
        if (!self::notEmptyStr($var))
            throw new ParameterError($name . " can not be empty string");
    }

    static public function checkIsUInt($var, $name)
    {
        if (!(is_int($var) && $var >= 0))
            throw new ParameterError($name . " need unsigned int");
    }

    static public function checkNotEmptyArray($var, $name)
    {
        if (!is_array($var) || count($var) == 0) {
            throw new ParameterError($name . " can not be empty array");
        }
    }

    static public function setIfNotNull($var, $name, &$args)
    {
        if (!is_null($var)) {
            $args[$name] = $var;
        }
    }

    static public function arrayGet($array, $key, $default=null)
    {
        if (array_key_exists($key, $array))
            return $array[$key];
        return $default;
    } 

	/**
	 * 数组 转 对象
	 *
	 * @param array $arr 数组
	 * @return object
	 */
	function Array2Object($arr) {
		if (gettype($arr) != 'array') {
			return;
		}
		foreach ($arr as $k => $v) {
			if (gettype($v) == 'array' || getType($v) == 'object') {
				$arr[$k] = (object)self::Array2Object($v);
			}
		}

		return (object)$arr;
	}

	/**
	 * 对象 转 数组
	 *
	 * @param object $obj 对象
	 * @return array
	 */
	function Object2Array($object) { 
		if (is_object($object) || is_array($object)) {
            $array = array();
			foreach ($object as $key => $value) {
                if ($value == null) continue;
				$array[$key] = self::Object2Array($value);
			}
            return $array;
		}
		else {
			return $object;
		}
	}
    //数组转XML
    function Array2Xml($rootName, $arr)
    {
        $xml = "<".$rootName.">";
        foreach ($arr as $key=>$val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                 $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</".$rootName.">";
        return $xml;
    }

    //将XML转为array
    function Xml2Array($xml)
    {    
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);        
        return $values;
    }

} // class Utils
