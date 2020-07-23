<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

    <? foreach($arResult as $arItem):?>
        <li>
            <a title="<?=$arItem["TEXT"]?>" href="<?=$arItem["LINK"]?>"><i class="nut-icon <?=$arItem["PARAMS"]['icon']?>"></i></a>
        </li>
    <?endforeach?>

<?endif?>
