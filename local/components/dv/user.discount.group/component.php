<? use Bitrix\Main\GroupTable;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;
$arResult['DISCOUNT_GROUP'] = false;
$arParams['CACHE_TIME']     = 3600;

if ($this->StartResultCache(false, $USER->GetGroups() . $USER->GetID()))
{
    $arCurUserGroups = CUser::GetUserGroup($USER->GetID());

    if (is_array($arCurUserGroups) && count($arCurUserGroups)) {

        $result = GroupTable::getList(array(
            'select'    => array('DESCRIPTION', 'STRING_ID'),
            'filter'    => array('ID' => $arCurUserGroups, 'STRING_ID' => 'discount'),
            'order'     => array('C_SORT' => 'ASC'),
        ));

        $arResult['DISCOUNT_GROUP'] = $result->fetch();
    }

    $this->IncludeComponentTemplate();
}
