<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php

$ITEMS      = [];
$CUR_SITE   = false;

foreach ($arResult["SITES"] as $key => $arSite) {
    if ($arSite["CURRENT"] == "Y") {
        $CUR_SITE = $arSite;
    } else {
        array_push($ITEMS, $arSite);
    }
}
?>
<div id="lang-menu" class="lang-menu">
    <?php if ($CUR_SITE) :?>
        <span class="title"><?=$CUR_SITE["NAME"]?></span>
    <?php endif; ?>
    <?php if (count($ITEMS)) :?>
        <ul>
            <?foreach ($ITEMS as $key => $arSite):?>
                <li>
                    <a href="<?if(is_array($arSite['DOMAINS']) && strlen($arSite['DOMAINS'][0]) > 0 || strlen($arSite['DOMAINS']) > 0):?>http://<?endif?><?=(is_array($arSite["DOMAINS"]) ? $arSite["DOMAINS"][0] : $arSite["DOMAINS"])?><?=$arSite["DIR"]?>" title="<?=$arSite["NAME"]?>"><?=$arSite["NAME"]?></a>
                </li>
            <?endforeach;?>
        </ul>
    <?php endif; ?>
</div>
