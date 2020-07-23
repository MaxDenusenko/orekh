<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?php if (count($arResult["ITEMS"])) :?>

    <section class="news gray_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-12">

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/main_page/news_list/title.php"
                        )
                    );?>

                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/main_page/news_list/text.php"
                        )
                    );?>

                </div>
                <div class="col-md-6 col-12 d-flex justify-content-end">
                    <div class="wrap">
                        <div class="navigation"></div>
                    </div>
                </div>
                <div class="col-12">
                    <!-- Swiper -->
                    <div class="news-container swiper-container">
                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-wrapper">

                            <?foreach($arResult["ITEMS"] as $arItem):?>

                                <?
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                ?>

                                <div class="swiper-slide">
                                    <div class="news__item news__item_video">
                                        <?php if ($arItem["PREVIEW_PICTURE"]["SRC"]) :?>
                                            <span class="video_wrap">
                                                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>">
                                            </span>
                                        <?php endif; ?>
                                        <div class="wraper" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                            <div class="item_data">
                                                <?=$arItem["DISPLAY_ACTIVE_FROM"]?>
                                            </div>
                                            <h3><?=$arItem["NAME"]?></h3>
                                            <p><?=$arItem["PREVIEW_TEXT"]?></p>
                                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">Читать <i class="nut-icon icons-read-more"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($arItem['LIST_PAGE_URL']) && $arItem['LIST_PAGE_URL']) :?>
                <div class="row">
                    <div class="wrapper">
                        <a href="<?=$arItem['LIST_PAGE_URL']?>" class="button button_transparent">Смотреть все новости</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?php endif; ?>
