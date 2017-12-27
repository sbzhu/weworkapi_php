<?php

include_once(__DIR__."/../../utils/Utils.class.php");
include_once(__DIR__."/../../utils/error.inc.php");

class Menu { 
    public $button = null; // xxxMenu array, 即各种子菜单array

	public function __construct($xxmenuArray=null)
	{
		$this->button = $xxmenuArray;
	}

    public static function CheckMenuCreateArgs($menu) { 

    }

    public static function Array2Menu($arr)
    {
        $menu = new Menu();

        foreach($arr["button"] as $item) { 
            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->button[] = $subButton;
        }

        return $menu;
    }

} // class

// ------------------------ 各种类型子菜单 ------------------------------------

class SubMenu {
    public $name = null; // string
    public $sub_button = null; // xxxMenu array

	public function __construct($name=null, $xxmenuArray=null)
	{
        $this->name = $name;
		$this->sub_button = $xxmenuArray;
	}

    public static function Array2Menu($arr)
    {
        $menu = new SubMenu();

        $menu->name = Utils::arrayGet($arr, "name");
        foreach($arr["sub_button"] as $item) { 

            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->sub_button[] = $subButton;
        }

        return $menu;
    }
} 
class ClickMenu {
    public $type = "click";
    public $name = null; // string
    public $key = null; // string

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
	}

    public static function Array2Menu($arr)
    {
        $menu = new ClickMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        return $menu;
    }
}
class viewMenu { 
    public $type = "view";
    public $name = null; // string
    public $url = null; // string

	public function __construct($name=null, $url= null)
	{
		$this->name = $name;
		$this->url = $url;
	}

    public static function Array2Menu($arr)
    {
        $menu = new viewMenu();

        $menu->type = "view";
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->url = Utils::arrayGet($arr, "url");

        return $menu;
    }
} 
class ScanCodePushMenu { 
    public $type = "scancode_push";
    public $name = null; // string
    public $key = null; // string
    public $sub_button = null; // xxxMenu array

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
		$this->sub_button = $xxmenuArray;
	}

    public static function Array2Menu($arr)
    {
        $menu = new ScanCodePushMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        foreach($arr["sub_button"] as $item) { 
            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->sub_button[] = $subButton;
        }

        return $menu;
    }
} 
class ScanCodeWaitMsgMenu { 
    public $type = "scancode_waitmsg";
    public $name = null; // string
    public $key = null; // string
    public $sub_button = null; // xxxMenu array

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
		$this->sub_button = $xxmenuArray;
	}

    public static function Array2Menu($arr)
    {
        $menu = new ScanCodeWaitMsgMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        foreach($arr["sub_button"] as $item) { 
            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->sub_button[] = $subButton;
        }

        return $menu;
    }
}
class PicSysPhotoMenu { 
    public $type = "pic_sysphoto";
    public $name = null; // string
    public $key = null; // string
    public $sub_button = null; // xxxMenu array

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
		$this->sub_button = $xxmenuArray;
	}

    public static function Array2Menu($arr)
    {
        $menu = new PicSysPhotoMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        foreach($arr["sub_button"] as $item) { 
            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->sub_button[] = $subButton;
        }

        return $menu;
    }
}
class PicPhotoOrAlbumMenu { 
    public $type = "pic_photo_or_album";
    public $name = null; // string
    public $key = null; // string
    public $sub_button = null; // xxxMenu array

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
		$this->sub_button = $xxmenuArray;
	}

    public static function Array2Menu($arr)
    {
        $menu = new PicPhotoOrAlbumMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        foreach($arr["sub_button"] as $item) { 
            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->sub_button[] = $subButton;
        }

        return $menu;
    }
}
class PicWeixinMenu { 
    public $type = "pic_weixin";
    public $name = null; // string
    public $key = null; // string
    public $sub_button = null; // xxxMenu array

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
		$this->sub_button = $xxmenuArray;
	}

    public static function Array2Menu($arr)
    {
        $menu = new PicWeixinMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        foreach($arr["sub_button"] as $item) { 
            $subButton = null;
            if ( ! array_key_exists("type", $item)) { 
                $subButton = SubMenu::Array2Menu($item);
            } else { 
                $type = $item["type"];
                if ($type == "click") $subButton = ClickMenu::Array2Menu($item);
                if ($type == "view") $subButton = viewMenu::Array2Menu($item);
                if ($type == "scancode_push") $subButton = ScanCodePushMenu::Array2Menu($item);
                if ($type == "scancode_waitmsg") $subButton = ScanCodeWaitMsgMenu::Array2Menu($item);
                if ($type == "pic_sysphoto") $subButton = PicSysPhotoMenu::Array2Menu($item);
                if ($type == "pic_photo_or_album") $subButton = PicPhotoOrAlbumMenu::Array2Menu($item);
                if ($type == "pic_weixin") $subButton = PicWeixinMenu::Array2Menu($item);
                if ($type == "location_select") $subButton = LocationSelectMenu::Array2Menu($item);
            }
            $menu->sub_button[] = $subButton;
        }

        return $menu;
    }
}
class LocationSelectMenu { 
    public $type = "location_select";
    public $name = null; // string
    public $key = null; // string

	public function __construct($name=null, $key=null, $xxmenuArray=null)
	{
        $this->name = $name;
        $this->key = $key;
	}

    public static function Array2Menu($arr)
    {
        $menu = new LocationSelectMenu();

        $menu->type = Utils::arrayGet($arr, "type");
        $menu->name = Utils::arrayGet($arr, "name");
        $menu->key = Utils::arrayGet($arr, "key");

        return $menu;
    }
}

