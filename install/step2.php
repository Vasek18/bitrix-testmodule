<?IncludeModuleLangFile(__FILE__);?>
<?if(!check_bitrix_sessid()) return;?>
<?
echo CAdminMessage::ShowNote(GetMessage("MODULE")." ".GetMessage("MODULE_NAME")." ".GetMessage("MODULE_CREATED"));

if ($_REQUEST["vregions_final_iblock_id"]){
	if ($_REQUEST["vregions_final_iblock_id"] == "exist"){
		echo CAdminMessage::ShowMessage(GetMessage("CODE_OCCUPIED").", ".GetMessage("SET_IBLOCK_MANUALLY"));
	}
	else{
		echo CAdminMessage::ShowNote(GetMessage("IBLOCK_SET").$_REQUEST["vregions_final_iblock_id"]);
	}
}
else{
	echo CAdminMessage::ShowMessage(GetMessage("IBLOCK_CREATING_ERROR").", ".GetMessage("SET_IBLOCK_MANUALLY"));
}

?>