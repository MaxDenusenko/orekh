<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}
?>

<?php if (isset($arResult['rows']) && is_array($arResult['rows']) && count($arResult['rows'])) :?>

    <?php $arResult['rows'] = array_chunk($arResult['rows'], 3) ?>
    <section class="benefit">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/main_page/nuts_list/title.php"
                        )
                    );?>

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/main_page/nuts_list/text.php"
                        )
                    );?>

                </div>
            </div>

            <? foreach ($arResult['rows'] as $row): ?>
                <div class="row justify-content-center">

                    <? foreach ($row as $item): ?>
                        <?php preg_match('/<img.*?src=["\'](.*?)["\'].*?>/i', $item['UF_FILE'], $matches);?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="wrap">
                                <div class="benefit__item overlay" style="background-image: url(<?=$matches[1]?>)">
                                    <?php if ($item['UF_NUT_ICON']): ?>
                                        <i class="<?=strip_tags($item['UF_NUT_ICON'])?>"></i>
                                    <?php endif; ?>
                                    <h3><?=$item['UF_NAME']?></h3>
                                </div>
                                <div class="benefit__item item_hover overlay_green">
                                    <?php if ($item['UF_NUT_ICON']): ?>
                                        <i class="<?=strip_tags($item['UF_NUT_ICON'])?>"></i>
                                    <?php endif; ?>
                                    <h3><?=$item['UF_NAME']?></h3>
                                    <?=html_entity_decode(htmlspecialchars_decode($item['UF_DESCRIPTION']))?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </section>

<?php endif; ?>
