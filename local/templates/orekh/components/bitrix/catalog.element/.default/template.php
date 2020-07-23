<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList,
	'ITEM' => array(
		'ID' => $arResult['ID'],
		'IBLOCK_ID' => $arResult['IBLOCK_ID'],
		'OFFERS_SELECTED' => $arResult['OFFERS_SELECTED'],
		'JS_OFFERS' => $arResult['JS_OFFERS']
	)
);
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

$haveOffers = !empty($arResult['OFFERS']);
if ($haveOffers)
{
	$actualItem = isset($arResult['OFFERS'][$arResult['OFFERS_SELECTED']])
		? $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]
		: reset($arResult['OFFERS']);
	$showSliderControls = false;

	foreach ($arResult['OFFERS'] as $offer)
	{
		if ($offer['MORE_PHOTO_COUNT'] > 1)
		{
			$showSliderControls = true;
			break;
		}
	}
}
else
{
	$actualItem = $arResult;
	$showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

$showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');
$arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE');
$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}
?>

<!--PRODUCT-->
<section class="product">
    <div class='container'>

        <div class="row no-gutters" id="<?=$itemIds['ID']?>" itemscope itemtype="http://schema.org/Product">

            <div class="col-lg-5 col-md-6">
                <div class="wrap">
                    <div class="product__item">

                        <!--Labels-->
                        <?php if ($arResult['LABEL']): ?>
                            <div class="sticker" id="<?=$itemIds['STICKER_ID']?>">

                                <? if (!empty($arResult['LABEL_ARRAY_VALUE'])) :?>
                                    <?php foreach ($arResult['LABEL_ARRAY_VALUE'] as $code => $value) :?>

                                        <?php $LABELS = explode('/', $value) ;?>
                                        <?php foreach ($LABELS as $INDEX => $LABEL) :?>
                                            <i class="nut-icon <?= isset($arResult['PROPERTIES']['ATT_HIT']['VALUE_XML_ID'][$INDEX]) ?
                                                'icons-'.$arResult['PROPERTIES']['ATT_HIT']['VALUE_XML_ID'][$INDEX] : '' ?>"></i>
                                            <p><?=$LABEL?></p>
                                            <?php break; ?>
                                        <?php endforeach; ?>

                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                        <? endif; ?>
                        <!--/Labels-->

                        <!--Slider-->
                        <?php if (!empty($actualItem['MORE_PHOTO'])) :?>
                        <div class="products-container swiper-container" data-entity="images-slider-block" id="<?=$itemIds['BIG_SLIDER_ID']?>">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper" data-entity="images-container">

                                <?php foreach ($actualItem['MORE_PHOTO'] as $key => $photo) :?>
                                    <!-- Slides -->
                                    <div class="swiper-slide" data-entity="image">
                                        <a href="javascript:void(0);">
                                            <img src="<?=$photo['SRC']?>" alt="<?=$alt?>" title="<?=$title?>" <?=($key == 0 ? ' itemprop="image"' : '')?>/>
                                        </a>
                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                            <img class="zoom" src="<?=SITE_TEMPLATE_PATH?>/img/zoom.svg" alt="alt">
                        </div>
                        <script>
                            //initialize swiper when document ready
                            var swiper = new Swiper('.products-container', {
                                slidesPerView: 1,
                                spaceBetween: 30,
                                loop: <?= count($actualItem['MORE_PHOTO']) > 1 ? 'true' : 'false' ?>,
                                speed: 400,
                                // pagination: {
                                //   el: '.swiper-pagination',
                                //   type: 'fraction',
                                // },
                                navigation: {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                },
                                autoplay: 10000000,
                                zoom: true,
                                // autoplayDisableOnInteraction: false,
                                // noSwiping: true,
                                noSwiping: false,
                                breakpoints: {
                                    1024: {
                                        slidesPerView: 1,
                                        spaceBetween: 30,
                                    },
                                    920: {
                                        slidesPerView: 1,
                                        spaceBetween: 30,
                                    },
                                    578: {
                                        slidesPerView: 1,
                                        spaceBetween: 10,
                                    }
                                }
                            });

                            <?php if (count($actualItem['MORE_PHOTO']) > 1) :?>
                                $(".swiper-container").hover(function() {
                                    (this).swiper.autoplay.stop();
                                }, function() {
                                    (this).swiper.autoplay.start();
                                });
                            <?php endif; ?>

                        </script>
                        <?php endif; ?>
                        <!--/Slider-->

                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="product__content">
                    <div class="row">

                        <!--Name-->
                        <?php if ($arParams['DISPLAY_NAME'] === 'Y') :?>
                            <div class="col-md-6">
                                <div class="product__content_name">
                                    Грецкий орех
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--/Name-->

                        <!--Article-->
                        <?php if (isset($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) && $arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']) :?>
                            <div class="col-md-6">
                                <div class="product__content_art">
                                    <?=Loc::getMessage('CT_BCE_CATALOG_ARTICLE_TITLE')?>:<span> <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--/Article-->

                        <!--FullName-->
                        <?php if (isset($arResult['PROPERTIES']['ATT_FULL_NAME']['VALUE']) && $arResult['PROPERTIES']['ATT_FULL_NAME']['VALUE']) :?>
                            <div class="col-lg-9">
                                <h1><?=$arResult['PROPERTIES']['ATT_FULL_NAME']['VALUE']?></h1>
                            </div>
                        <?php endif; ?>
                        <!--/FullName-->

                        <div class="col-lg-3"></div>

                        <!--Properties-->
                        <?php if (!empty($arResult['DISPLAY_PROPERTIES'])) :?>
                            <div class="col-12">
                                <div class="product__content_descr">
                                    <ul>

                                        <?php foreach ($arResult['DISPLAY_PROPERTIES'] as $property) :?>
                                            <?php if (isset($arParams['MAIN_BLOCK_PROPERTY_CODE'][$property['CODE']])):?>

                                                <li>
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <strong><?=$property['NAME']?>:</strong>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <span>
                                                                <?=(is_array($property['DISPLAY_VALUE'])
                                                                    ? implode(' / ', $property['DISPLAY_VALUE'])
                                                                    : $property['DISPLAY_VALUE'])?>
                                                                <?=$property['DESCRIPTION']?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </li>

                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php unset($property); ?>

                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--/Properties-->

                        <!--StorageCondition-->
                        <?php if (isset($arResult['PROPERTIES']['ATT_STORAGE_CONDITION']['VALUE']) && $arResult['PROPERTIES']['ATT_STORAGE_CONDITION']['VALUE']['TEXT']) :?>
                            <div class="col-12">
                                <div class="warning">
                                    <i class="nut-icon icons-warning-sigh"></i>
                                    <p><?=$arResult['PROPERTIES']['ATT_STORAGE_CONDITION']['VALUE']['TEXT']?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--/StorageCondition-->

                        <!--PayContainer-->
                        <div class="col-12">
                            <div class="product__content_sum">
                                <div class="sum_item">
                                    <div class="sum_item_title">
                                        <p><?=Loc::getMessage('CT_BCE_CATALOG_PRICE_TITLE')?>: </p>
                                    </div>
                                    <div class="sum_item_new" id="<?=$itemIds['PRICE_ID']?>">
                                        <p><?=$price['PRINT_RATIO_PRICE']?></p>
                                    </div>
                                    <?php if ($arParams['SHOW_OLD_PRICE'] === 'Y') :?>
                                        <div class="sum_item_old" id="<?=$itemIds['OLD_PRICE_ID']?>" style="display: <?=($showDiscount ? '' : 'none')?>;">
                                            <p><?=($showDiscount ? $price['PRINT_RATIO_BASE_PRICE'] : '')?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div data-entity="main-button-container" class="sum_item" id="<?=$itemIds['BASKET_ACTIONS_ID']?>"
                                     style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">

                                    <?php if ($showAddBtn) :?>
                                        <div class="sum_item_button">
                                            <a class="button" id="<?=$itemIds['ADD_BASKET_LINK']?>" href="javascript:void(0);">
                                                <?=$arParams['MESS_BTN_ADD_TO_BASKET']?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($showBuyBtn) :?>
                                        <div class="sum_item_button">
                                            <a class="button" id="<?=$itemIds['BUY_LINK']?>" href="javascript:void(0);">
                                                <?=$arParams['MESS_BTN_BUY']?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($showSubscribe) :?>
                                        <div class="product-item-detail-info-container">
                                            <?
                                            $APPLICATION->IncludeComponent(
                                                'bitrix:catalog.product.subscribe',
                                                '',
                                                array(
                                                    'CUSTOM_SITE_ID' => isset($arParams['CUSTOM_SITE_ID']) ? $arParams['CUSTOM_SITE_ID'] : null,
                                                    'PRODUCT_ID' => $arResult['ID'],
                                                    'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                                    'BUTTON_CLASS' => 'btn btn-default product-item-detail-buy-button',
                                                    'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
                                                    'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                                ),
                                                $component,
                                                array('HIDE_ICONS' => 'Y')
                                            );
                                            ?>
                                        </div>
                                    <?php endif;?>

                                    <a class="button" id="<?=$itemIds['NOT_AVAILABLE_MESS']?>"
                                       href="javascript:void(0)"
                                       rel="nofollow" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
                                        <?=$arParams['MESS_NOT_AVAILABLE']?>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <!--/PayContainer-->

                    </div>
                </div>
            </div>

            <!--METADATA-->
            <meta itemprop="name" content="<?=$name?>" />
            <meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
            <?
            if ($haveOffers)
            {
                foreach ($arResult['JS_OFFERS'] as $offer)
                {
                    $currentOffersList = array();

                    if (!empty($offer['TREE']) && is_array($offer['TREE']))
                    {
                        foreach ($offer['TREE'] as $propName => $skuId)
                        {
                            $propId = (int)substr($propName, 5);

                            foreach ($skuProps as $prop)
                            {
                                if ($prop['ID'] == $propId)
                                {
                                    foreach ($prop['VALUES'] as $propId => $propValue)
                                    {
                                        if ($propId == $skuId)
                                        {
                                            $currentOffersList[] = $propValue['NAME'];
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
                    ?>
                    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
                        <meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
                        <meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
                        <link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
                    </span>
                    <?
                }

                unset($offerPrice, $currentOffersList);
            }
            else
            {
                ?>
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
                    <meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
                    <link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
                </span>
                <?
            }
            ?>
            <!--/METADATA-->

        </div>

    </div>
</section>
<!--/PRODUCT-->

<!--TABS-->
<section class="payment payment__product">
    <div class="tabs">

        <div class="tabs__wrap">
            <div class="container">
                <div class="row" id="<?=$itemIds['TABS_ID']?>">
                    <ul class="tabs__caption">
                        <li class="active"><span><?=Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION')?></span></li>
                        <li><span><?=Loc::getMessage('CT_BCE_CATALOG_PACKAGING')?></span></li>
                        <li><span><?=Loc::getMessage('CT_BCE_CATALOG_PAYMENT')?></span></li>
                        <li><span><?=Loc::getMessage('CT_BCE_CATALOG_DELIVERY')?></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" id="<?=$itemIds['TAB_CONTAINERS_ID']?>">
                <div class="col-12">

                    <!--DESCRIPTION-->
                    <div class="tabs__content active" data-entity="tab-container" data-value="description" itemprop="description">
                        <div class="row">

                            <?
                            if (
                                $arResult['PREVIEW_TEXT'] != ''
                                && (
                                    $arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                                    || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
                                )
                            ) {
                                echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
                            }

                            if ($arResult['DETAIL_TEXT'] != '') {
                                echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
                            }
                            ?>

                        </div>
                    </div>
                    <!--/DESCRIPTION-->

                    <!--PACKAGING-->
                    <div class="tabs__content">
                        <?php if (isset($arResult['PROPERTIES']['ATT_BLOCK_PACKAGING']['VALUE']['TEXT']) && $arResult['PROPERTIES']['ATT_BLOCK_PACKAGING']['VALUE']['TEXT']) :?>
                            <?=$arResult['PROPERTIES']['ATT_BLOCK_PACKAGING']['VALUE']['TEXT']?>
                        <?php else: ?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/catalog/element/packaging.php"
                                )
                            );?>
                        <?php endif; ?>
                    </div>
                    <!--/PACKAGING-->

                    <!--PAYMENT-->
                    <div class="tabs__content">
                        <?php if (isset($arResult['PROPERTIES']['ATT_BLOCK_PAYMENT']['VALUE']['TEXT']) && $arResult['PROPERTIES']['ATT_BLOCK_PAYMENT']['VALUE']['TEXT']) :?>
                            <?=$arResult['PROPERTIES']['ATT_BLOCK_PAYMENT']['VALUE']['TEXT']?>
                        <?php else: ?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/catalog/element/payment.php"
                                )
                            );?>
                        <?php endif; ?>
                    </div>
                    <!--/PAYMENT-->

                    <!--DELIVERY-->
                    <div class="tabs__content">
                        <?php if (isset($arResult['PROPERTIES']['ATT_BLOCK_DELIVERY']['VALUE']['TEXT']) && $arResult['PROPERTIES']['ATT_BLOCK_DELIVERY']['VALUE']['TEXT']) :?>
                            <?=$arResult['PROPERTIES']['ATT_BLOCK_DELIVERY']['VALUE']['TEXT']?>
                        <?php else: ?>
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/catalog/element/delivery.php"
                                )
                            );?>
                        <?php endif; ?>
                    </div>
                    <!--/DELIVERY-->

                </div>
            </div>
        </div>
    </div>
</section>
<!--/TABS-->

<?
if ($haveOffers)
{
	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
	{
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($jsOffer['DISPLAY_PROPERTIES']))
			{
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
				{
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
					{
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
		{
			$strPriceRangesRatio = '('.Loc::getMessage(
					'CT_BCE_CATALOG_RATIO_PRICE',
					array('#RATIO#' => ($useRatio
							? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
							: '1'
						).' '.$measureName)
				).')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
			{
				if ($range['HASH'] !== 'ZERO-INF')
				{
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
					{
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
						{
							break;
						}
					}

					if ($itemPrice)
					{
						$strPriceRanges .= '<dt>'.Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_FROM',
								array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
							).' ';

						if (is_infinite($range['SORT_TO']))
						{
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						}
						else
						{
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'].' '.$measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
	{
		?>
		<div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
			<?
			if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
			{
				foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
				{
					?>
					<input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
					<?
					unset($arResult['PRODUCT_PROPERTIES'][$propId]);
				}
			}

			$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
			if (!$emptyProductProperties)
			{
				?>
				<table>
					<?
					foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
					{
						?>
						<tr>
							<td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
							<td>
								<?
								if (
									$arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
									&& $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
								)
								{
									foreach ($propInfo['VALUES'] as $valueId => $value)
									{
										?>
										<label>
											<input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
												value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"checked"' : '')?>>
											<?=$value?>
										</label>
										<br>
										<?
									}
								}
								else
								{
									?>
									<select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
										<?
										foreach ($propInfo['VALUES'] as $valueId => $value)
										{
											?>
											<option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? '"selected"' : '')?>>
												<?=$value?>
											</option>
											<?
										}
										?>
									</select>
									<?
								}
								?>
							</td>
						</tr>
						<?
					}
					?>
				</table>
				<?
			}
			?>
		</div>
		<?
	}

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'VISUAL' => $itemIds,
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'PICT' => reset($arResult['MORE_PHOTO']),
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
			'ITEM_PRICES' => $arResult['ITEM_PRICES'],
			'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
			'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
			'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
			'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
			'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
			'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
			'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
	$jsParams['COMPARE'] = array(
		'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
		'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
		'COMPARE_PATH' => $arParams['COMPARE_PATH']
	);
}
?>
<script>
	BX.message({
		ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
		TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
		TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
		BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
		BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
		BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
		BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
		BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
		TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
		COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
		COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
		COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
		BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
		PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
		PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
		RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
		RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
		SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
	});

	var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?
unset($actualItem, $itemIds, $jsParams);
