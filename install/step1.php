<?if(!check_bitrix_sessid()) return;?>
<?IncludeModuleLangFile(__FILE__);?>

<form action="<?echo $APPLICATION->GetCurPage()?>" name="form1">
	<?=bitrix_sessid_post()?>
	<input type="hidden" name="lang" value="<?echo LANG?>">
	<input type="hidden" name="id" value="testmodule">
	<input type="hidden" name="install" value="Y">
	<input type="hidden" name="step" value="2">
	<table cellpadding="3" cellspacing="0" border="0" width="0%">
		<tr>
			<td>&nbsp;</td>
			<td>
				<table cellpadding="3" cellspacing="0" border="0">
				<tr>
					<td>&nbsp;</td>
					<td><p><?echo GetMessage("IBLOCK_FOR_MODULE")?>:&nbsp;<select name="testmodule_iblock_id" id="testmodule_iblock_id">
						<option value=""><?echo GetMessage("IBLOCK_FOR_MODULE_CREATE")?></option>
						<?
					$resIBFM = CIBlock::GetList(Array(), Array('SITE_ID'=>"s1"));
					while($arrIBFM = $resIBFM->Fetch()){?>
						<option value="<?=$arrIBFM["ID"];?>"><?=$arrIBFM["NAME"];?></option>
					<?}?>
					</select></p></td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
	<input type="submit" name="inst" value="<?echo GetMessage("MOD_INSTALL")?>">
</form>
