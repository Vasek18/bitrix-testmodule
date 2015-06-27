<?
IncludeModuleLangFile(__FILE__);

if (class_exists("testmodule")) return;

Class testmodule extends CModule{
	var $MODULE_ID = "testmodule";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_GROUP_RIGHTS = "Y";
	var $PARTNER_NAME;
	var $PARTNER_URI;
	
	// конструктор
	function testmodule(){
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");
		
		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)){
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		
		$this->MODULE_NAME = GetMessage("V_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("V_MODULE_DESCRIPTION");
		$this->PARTNER_NAME = GetMessage("V_MODULE_PARTNER_NAME");
		$this->PARTNER_URI = "http://site.ru";
	}

	function InstallDB(){
		RegisterModule($this->MODULE_ID);

		// региструем код, который будет выполняться OnProlog
		RegisterModuleDependences("main", "OnProlog", $this->MODULE_ID, "TestModuleOnPageLoad", "testModuleMainHandler");

		return true;
	}

	function UnInstallDB(){
		// именно в таком порядке
		UnRegisterModuleDependences("main", "OnProlog", $this->MODULE_ID, "TestModuleOnPageLoad", "testModuleMainHandler");
		
		UnRegisterModule($this->MODULE_ID);
		
		return true;
	}
	
	// функция копирования служебных файлов
	function InstallFiles($arParams = array()){
		// CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);
		// CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/js", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js", true, true);

		return true;
	}
	// функция удаления служебных файлов
	function UnInstallFiles(){
		// DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");
		// DeleteDirFilesEx("/bitrix/js/testmodule/");

		return true;
	}
	
	// функция установки компонента
	function InstallComponent($arParams = array()){
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/components",
					 $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		return true;
	}
	// функция удаления компонента
	function UnInstallComponent(){
		DeleteDirFilesEx("/bitrix/components/".$this->MODULE_ID."/");
		return true;
	}

	// функция установки модуля
	function DoInstall(){
		// проверка запуска, а также модуль иблоков определённо нужен
		if (!check_bitrix_sessid() || !IsModuleInstalled("iblock"))
			return false;
		
		global $DOCUMENT_ROOT, $APPLICATION, $step;
		
		$step = IntVal($step);
		
		if($step<2){
			$APPLICATION->IncludeAdminFile(GetMessage("V_MODULE_INSTALL").$this->MODULE_ID, $DOCUMENT_ROOT."/bitrix/modules/".$this->MODULE_ID."/install/step1.php");
			
		}elseif($step==2){
			// echo "<pre>";
			// print_r($_REQUEST);
			// echo "</pre>";
			// die();
			$this->InstallComponent(); // установка компонента
			$this->InstallFiles(); // копирование файлов
			
			$this->InstallDB();
			
			$APPLICATION->IncludeAdminFile(GetMessage("V_MODULE_INSTALL").$this->MODULE_ID, $DOCUMENT_ROOT."/bitrix/modules/".$this->MODULE_ID."/install/step2.php");
			
			LocalRedirect("module_admin.php?lang=".LANGUAGE_ID);
		}
		return true;
	}

	// функция удаления модуля
	function DoUninstall(){
		if (!check_bitrix_sessid())
			return false;

		global $APPLICATION, $step, $obModule;
		$step = IntVal($step);
		
		if($step<2)
			$APPLICATION->IncludeAdminFile(GetMessage("V_MODULE_UNINSTALL"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/unstep1.php");
		
		elseif($step==2){
			// echo "<pre>";
			// print_r($_REQUEST);
			// echo "</pre>";
			// die();
			$this->UnInstallComponent(); // удаление компонента
			$this->UnInstallFiles(); // удаление файлов
			
			$this->UnInstallDB();
			
			$GLOBALS["CACHE_MANAGER"]->CleanAll();
			$GLOBALS["stackCacheManager"]->CleanAll();
			
			$APPLICATION->IncludeAdminFile(GetMessage("V_MODULE_UNINSTALL"), $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/unstep2.php");
		}
	}
}