<?php

use Bitrix\Main\Localization;

Localization\Loc::loadMessages(__FILE__);

class TestModuleOnPageLoad{

	static $MODULE_ID = "testmodule";

	public static function testModuleMainHandler(){
		global $APPLICATION;
		CModule::IncludeModule("iblock");
		
		
		// ���������� js-����
		// $APPLICATION->AddHeadScript("/bitrix/js/testmodule/script.js");
	}
}
?>