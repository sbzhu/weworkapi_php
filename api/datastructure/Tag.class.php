<?php

include_once(__DIR__."/../../utils/Utils.class.php");

class TagUser { 
    public $userid = null;
    public $name = null;
}

class Tag {
    public $tagname = null; // string
    public $tagid = null; // uint 
    public $userlist = null; // TagUser array
    public $partylist = null; // uint array

    static public function Tag2Array($tag)
    { 
		$args = array();

		Utils::setIfNotNull($tag->tagname, "tagname", $args);
		Utils::setIfNotNull($tag->tagid, "tagid", $args);

        return $args;
    }

    static public function Array2Tag($arr)
    {
		$tag = new Tag();

        $tag->tagname = Utils::arrayGet($arr, "tagname");
        $tag->tagid = Utils::arrayGet($arr, "tagid");

        $userListArr = Utils::arrayGet($arr, "userlist"); 
        if ( ! is_null($userListArr)) { 
            foreach($userListArr as $userArr) { 
                $user = new TagUser();
                $user->userid = Utils::arrayGet($userArr, "userid");
                $user->name = Utils::arrayGet($userArr, "name");

                $tag->userlist[] = $user;
            }
        }

        $partyListArr = Utils::arrayGet($arr, "partylist");
        if ( ! is_null($partyListArr)) { 
            foreach($partyListArr as $partyid)
            {
                $tag->partylist[] = $partyid;
            }
        }

        return $tag;
    }

    static  public function Array2TagList($arr)
    { 
        $tagList = array();

        $tagListArr = $arr["taglist"];
        foreach($tagListArr as $item) { 
            $tag = self::Array2Tag($item); 
            $tagList[] = $tag;
        }

        return $tagList;
    }

    static public function CheckTagCreateArgs($tag)
    {
        Utils::checkNotEmptyStr($tag->tagname, "tagname");
    }

    static public function CheckTagUpdateArgs($tag)
    {
        Utils::checkIsUInt($tag->tagid, "tagid");
        Utils::checkNotEmptyStr($tag->tagname, "tagname");
    }

    static public function CheckTagAddUserArgs($tagId, $userIdList, $partyIdList)
    {
        Utils::checkIsUInt($tagId, "tagid");

        if (0 == count($userIdList) && 0 == count($partyIdList)) { 
            throw new QyApiError("userIdList and partyIdList should not be both empty");
        }
    }

    static public function ToTagAddUserArray($tagId, $userIdList, $partyIdList)
    {
        $args = array();

		Utils::setIfNotNull($tagId, "tagid", $args);
		Utils::setIfNotNull($userIdList, "userlist", $args);
		Utils::setIfNotNull($partyIdList, "partylist", $args);

        return $args;
    }

} // class
