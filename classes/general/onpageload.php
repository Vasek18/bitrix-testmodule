<?php

use Bitrix\Main\Localization;

Localization\Loc::loadMessages(__FILE__);

class TestModuleOnPageLoad{

	static $MODULE_ID = "testmodule";

	public static function testModuleMainHandler(){
		global $APPLICATION;
		CModule::IncludeModule("iblock");
		
		
		// подключаем js-ники
		// $APPLICATION->AddHeadScript("/bitrix/js/testmodule/script.js");
	}
}
?>