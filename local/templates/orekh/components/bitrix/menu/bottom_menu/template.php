<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

    <div class="col-lg-10">
        <ul class="menu_main_ul">

            <? foreach($arResult as $arItem):
                if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                    continue;
            ?>
                <li>
                    <?if($arItem["SELECTED"]):?>
                        <a href="<?=$arItem["LINK"]?>" class="selected"><?=$arItem["TEXT"]?></a>
                    <?else:?>
                        <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                    <?endif?>
                </li>
            <?endforeach?>

        </ul>
    </div>

<?endif?>
