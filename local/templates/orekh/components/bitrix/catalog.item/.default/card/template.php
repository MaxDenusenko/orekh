<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
?>

<!--Labels-->
<?php if ($item['LABEL']): ?>
    <div class="sticker" id="<?=$itemIds['STICKER_ID']?>">

        <? if (!empty($item['LABEL_ARRAY_VALUE'])) :?>
            <?php foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value) :?>

                <?php $LABELS = explode('/', $value) ;?>
                <?php foreach ($LABELS as $INDEX => $LABEL) :?>
                    <i class="nut-icon <?= isset($item['PROPERTIES']['ATT_HIT']['VALUE_XML_ID'][$INDEX]) ?
                        'icons-'.$item['PROPERTIES']['ATT_HIT']['VALUE_XML_ID'][$INDEX] : '' ?>"></i>
                    <p><?=$LABEL?></p>
                    <?php break; ?>
                <?php endforeach; ?>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>
<? endif; ?>
<!--/Labels-->

<!--Slider-->
<?php $cntPict = 1 + count($morePhoto) + ($item['SECOND_PICT'] ? 1 : 0) ?>
<div id="slider_for_product_<?=$item['ID']?>" class="products-container swiper-container product-item-image-wrapper" data-entity="image-wrapper">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper" id="<?=$itemIds['PICT_SLIDER']?>">
        <!-- Slides -->

        <div class="swiper-slide" id="<?=$itemIds['PICT']?>">
            <a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>">
                <img src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="<?=$imgTitle?>"/>
            </a>
        </div>

        <?php foreach ($morePhoto as $key => $photo) : ?>
            <div class="swiper-slide">
                <a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>">
                    <img src="<?=$photo['SRC']?>" alt="<?=$imgTitle?>"/>
                </a>
            </div>
        <?php endforeach; ?>

        <?
        if ($item['SECOND_PICT']) :
            $bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];
            ?>
            <div class="swiper-slide" id="<?=$itemIds['SECOND_PICT']?>">
                <a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$imgTitle?>">
                    <img src="<?=$bgImage?>" alt="<?=$imgTitle?>"/>
                </a>
            </div>
        <?php endif; ?>

    </div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <img class="zoom" src="<?=SITE_TEMPLATE_PATH?>/img/zoom.svg" alt="alt">
</div>
<script>
    //initialize swiper when document ready
    var swiper = new Swiper('#slider_for_product_<?=$item["ID"]?>', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: <?= $cntPict > 1 ? 'true' : 'false' ?>,
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

    <?php if ($cntPict > 1) :?>
    $('#slider_for_product_<?=$item["ID"]?>').hover(function() {
        (this).swiper.autoplay.stop();
    }, function() {
        (this).swiper.autoplay.start();
    });
    <?php endif; ?>

</script>
<!--/Slider-->

<!--Product-->
<div class="wrap">

    <!--Titile-->
    <div class="production__item_title"><?=$productTitle?></div>
    <!--/Titile-->

    <!--Article-->
    <?php if (
            isset($item['PROPERTIES']['CML2_ARTICLE']['VALUE']) &&
            $CML2_ARTICLE = $item['PROPERTIES']['CML2_ARTICLE']['VALUE']
    ) :?>
        <div class="production__item_art"><span><?=Loc::getMessage('CT_BCI_TPL_MESS_ARTICLE');?>:</span> <?=$CML2_ARTICLE?></div>
    <?php endif; ?>
    <!--/Article-->

    <!--FullName-->
    <?php if (isset($item['PROPERTIES']['ATT_FULL_NAME']['VALUE'])) :?>
        <div class="production__item_descr"><?=$item['PROPERTIES']['ATT_FULL_NAME']['VALUE']?></div>
    <?php endif; ?>
    <!--/FullName-->

    <?
    if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
    {
        foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
        {
            switch ($blockName)
            {
                case 'price': ?>

                    <div class="production__item_sum" data-entity="price-block">

                        <div class="sum_item">
                            <div class="sum_item_title">
                                <p><?=Loc::getMessage('CT_BCI_TPL_MESS_PRICE');?>: </p>
                            </div>
                            <div class="sum_item_new" id="<?=$itemIds['PRICE']?>">
                                <p><?=$price['PRINT_RATIO_PRICE']?></p>
                            </div>
                            <?php if ($arParams['SHOW_OLD_PRICE'] === 'Y') :?>
                                <div <?=($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '')?>
                                        class="sum_item_old" id="<?=$itemIds['PRICE_OLD']?>">
                                    <p><?=$price['PRINT_RATIO_BASE_PRICE']?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                    <?
                    break;

                case 'quantityLimit':
                    if ($arParams['SHOW_MAX_QUANTITY'] !== 'N')
                    {
                        if ($haveOffers)
                        {
                            if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
                            {
                                ?>
                                <div class="product-item-info-container product-item-hiddenn" id="<?=$itemIds['QUANTITY_LIMIT']?>"
                                     style="display: none;" data-entity="quantity-limit-block">
                                    <div class="product-item-info-container-title">
                                        <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                                        <span class="product-item-quantity" data-entity="quantity-limit-value"></span>
                                    </div>
                                </div>
                                <?
                            }
                        }
                        else
                        {
                            if (
                                $measureRatio
                                && (float)$actualItem['CATALOG_QUANTITY'] > 0
                                && $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
                                && $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
                            )
                            {
                                ?>
                                <div class="product-item-info-container product-item-hiddenn" id="<?=$itemIds['QUANTITY_LIMIT']?>">
                                    <div class="product-item-info-container-title">
                                        <?=$arParams['MESS_SHOW_MAX_QUANTITY']?>:
                                        <span class="product-item-quantity">
                                        <?
                                        if ($arParams['SHOW_MAX_QUANTITY'] === 'M')
                                        {
                                            if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR'])
                                            {
                                                echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
                                            }
                                            else
                                            {
                                                echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
                                            }
                                        }
                                        else
                                        {
                                            echo $actualItem['CATALOG_QUANTITY'].' '.$actualItem['ITEM_MEASURE']['TITLE'];
                                        }
                                        ?>
                                    </span>
                                    </div>
                                </div>
                                <?
                            }
                        }
                    }

                    break;

                case 'quantity':
                    if (!$haveOffers)
                    {
                        if ($actualItem['CAN_BUY'] && $arParams['USE_PRODUCT_QUANTITY'])
                        {
                            ?>
                            <div class="product-item-info-container product-item-hiddenn" data-entity="quantity-block">
                                <div class="product-item-amount">
                                    <div class="product-item-amount-field-container">
                                        <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
                                        <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="number"
                                               name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
                                               value="<?=$measureRatio?>">
                                        <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>
                                        <span class="product-item-amount-description-container">
                                        <span id="<?=$itemIds['QUANTITY_MEASURE']?>">
                                            <?=$actualItem['ITEM_MEASURE']['TITLE']?>
                                        </span>
                                        <span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                    }
                    elseif ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
                    {
                        if ($arParams['USE_PRODUCT_QUANTITY'])
                        {
                            ?>
                            <div class="product-item-info-container product-item-hiddenn" data-entity="quantity-block">
                                <div class="product-item-amount">
                                    <div class="product-item-amount-field-container">
                                        <span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>"></span>
                                        <input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="number"
                                               name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>"
                                               value="<?=$measureRatio?>">
                                        <span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>"></span>
                                        <span class="product-item-amount-description-container">
                                        <span id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$actualItem['ITEM_MEASURE']['TITLE']?></span>
                                        <span id="<?=$itemIds['PRICE_TOTAL']?>"></span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <?
                        }
                    }

                    break;

                case 'buttons':
                    ?>

                        <div class="sum_item" data-entity="buttons-block">
                            <?php if ($actualItem['CAN_BUY']) : ?>
                                <div class="sum_item_button" id="<?=$itemIds['BASKET_ACTIONS']?>">
                                    <a href="javascript:void(0)" rel="nofollow" class="button" id="<?=$itemIds['BUY_LINK']?>">
                                        <?=($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET'])?>
                                    </a>
                                </div>
                            <?php else: ?>
                                <?
                                if ($showSubscribe)
                                {
                                    $APPLICATION->IncludeComponent(
                                        'bitrix:catalog.product.subscribe',
                                        '',
                                        array(
                                            'PRODUCT_ID' => $actualItem['ID'],
                                            'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
                                            'BUTTON_CLASS' => 'btn btn-default '.$buttonSizeClass,
                                            'DEFAULT_DISPLAY' => true,
                                            'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                                        ),
                                        $component,
                                        array('HIDE_ICONS' => 'Y')
                                    );
                                }
                                ?>
                                <div class="sum_item_button">
                                    <a class="btn btn-link <?=$buttonSizeClass?>"
                                       id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" href="javascript:void(0)" rel="nofollow">
                                        <?=$arParams['MESS_NOT_AVAILABLE']?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>

                    <?
                    break;

                case 'props':
                    if (!$haveOffers)
                    {
                        if (!empty($item['DISPLAY_PROPERTIES']))
                        {
                            ?>
                            <?php
                            $ATT_WEIGHT     = isset($item['DISPLAY_PROPERTIES']['ATT_WEIGHT']) ? $item['DISPLAY_PROPERTIES']['ATT_WEIGHT'] : false;
                            $ATT_PACKAGING  = isset($item['DISPLAY_PROPERTIES']['ATT_PACKAGING']) ? $item['DISPLAY_PROPERTIES']['ATT_PACKAGING'] : false;

                            if ($ATT_WEIGHT || $ATT_PACKAGING) :?>
                                <div class="production__item_weight" data-entity="props-block">

                                    <?php if ($ATT_WEIGHT && $ATT_WEIGHT['VALUE']) :?>
                                        <div class="weight_item">
                                            <div class="weight_item_icon">
                                                <i class="nut-icon icons-food-scale-tool"></i>
                                            </div>
                                            <div class="weight_item_descr">
                                                <p><?=Loc::getMessage('CT_BCI_TPL_MESS_WEIGHT');?></p>
                                                <p><span><?=$ATT_WEIGHT['VALUE']?><i><?=$ATT_WEIGHT['DESCRIPTION']?></i></span></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($ATT_PACKAGING && $ATT_PACKAGING['VALUE_ENUM']) :?>
                                        <div class="weight_item">
                                            <div class="weight_item_icon">
                                                <i class="nut-icon icons-group"></i>
                                            </div>
                                            <div class="weight_item_descr">
                                                <p><?=Loc::getMessage('CT_BCI_TPL_MESS_PACKAGING');?></p>
                                                <p><span><?=$ATT_PACKAGING['VALUE_ENUM']?></span></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>

                            <?
                        }

                        if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !empty($item['PRODUCT_PROPERTIES']))
                        {
                            ?>
                            <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
                                <?
                                if (!empty($item['PRODUCT_PROPERTIES_FILL']))
                                {
                                    foreach ($item['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
                                    {
                                        ?>
                                        <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]"
                                               value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
                                        <?
                                        unset($item['PRODUCT_PROPERTIES'][$propID]);
                                    }
                                }

                                if (!empty($item['PRODUCT_PROPERTIES']))
                                {
                                    ?>
                                    <table>
                                        <?
                                        foreach ($item['PRODUCT_PROPERTIES'] as $propID => $propInfo)
                                        {
                                            ?>
                                            <tr>
                                                <td><?=$item['PROPERTIES'][$propID]['NAME']?></td>
                                                <td>
                                                    <?
                                                    if (
                                                        $item['PROPERTIES'][$propID]['PROPERTY_TYPE'] === 'L'
                                                        && $item['PROPERTIES'][$propID]['LIST_TYPE'] === 'C'
                                                    )
                                                    {
                                                        foreach ($propInfo['VALUES'] as $valueID => $value)
                                                        {
                                                            ?>
                                                            <label>
                                                                <? $checked = $valueID === $propInfo['SELECTED'] ? 'checked' : ''; ?>
                                                                <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]"
                                                                       value="<?=$valueID?>" <?=$checked?>>
                                                                <?=$value?>
                                                            </label>
                                                            <br />
                                                            <?
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]">
                                                            <?
                                                            foreach ($propInfo['VALUES'] as $valueID => $value)
                                                            {
                                                                $selected = $valueID === $propInfo['SELECTED'] ? 'selected' : '';
                                                                ?>
                                                                <option value="<?=$valueID?>" <?=$selected?>>
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
                    }
                    else
                    {
                        $showProductProps = !empty($item['DISPLAY_PROPERTIES']);
                        $showOfferProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];

                        if ($showProductProps || $showOfferProps)
                        {
                            ?>
                            <div class="product-item-info-container product-item-hiddenn" data-entity="props-block">
                                <dl class="product-item-properties">
                                    <?
                                    if ($showProductProps)
                                    {
                                        foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty)
                                        {
                                            ?>
                                            <dt<?=(!isset($item['PROPERTY_CODE_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
                                                <?=$displayProperty['NAME']?>
                                            </dt>
                                            <dd<?=(!isset($item['PROPERTY_CODE_MOBILE'][$code]) ? ' class="hidden-xs"' : '')?>>
                                                <?=(is_array($displayProperty['DISPLAY_VALUE'])
                                                    ? implode(' / ', $displayProperty['DISPLAY_VALUE'])
                                                    : $displayProperty['DISPLAY_VALUE'])?>
                                            </dd>
                                            <?
                                        }
                                    }

                                    if ($showOfferProps)
                                    {
                                        ?>
                                        <span id="<?=$itemIds['DISPLAY_PROP_DIV']?>" style="display: none;"></span>
                                        <?
                                    }
                                    ?>
                                </dl>
                            </div>
                            <?
                        }
                    }

                    break;

                case 'sku':
                    if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP']))
                    {
                        ?>
                        <div id="<?=$itemIds['PROP_DIV']?>">
                            <?
                            foreach ($arParams['SKU_PROPS'] as $skuProperty)
                            {
                                $propertyId = $skuProperty['ID'];
                                $skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
                                if (!isset($item['SKU_TREE_VALUES'][$propertyId]))
                                    continue;
                                ?>
                                <div class="product-item-info-container product-item-hiddenn" data-entity="sku-block">
                                    <div class="product-item-scu-container" data-entity="sku-line-block">
                                        <?=$skuProperty['NAME']?>
                                        <div class="product-item-scu-block">
                                            <div class="product-item-scu-list">
                                                <ul class="product-item-scu-item-list">
                                                    <?
                                                    foreach ($skuProperty['VALUES'] as $value)
                                                    {
                                                        if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))
                                                            continue;

                                                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);

                                                        if ($skuProperty['SHOW_MODE'] === 'PICT')
                                                        {
                                                            ?>
                                                            <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
                                                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                                                <div class="product-item-scu-item-color-block">
                                                                    <div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
                                                                         style="background-image: url('<?=$value['PICT']['SRC']?>');">
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                                                <div class="product-item-scu-item-text-block">
                                                                    <div class="product-item-scu-item-text"><?=$value['NAME']?></div>
                                                                </div>
                                                            </li>
                                                            <?
                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                                <div style="clear: both;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?
                            }
                            ?>
                        </div>
                        <?
                        foreach ($arParams['SKU_PROPS'] as $skuProperty)
                        {
                            if (!isset($item['OFFERS_PROP'][$skuProperty['CODE']]))
                                continue;

                            $skuProps[] = array(
                                'ID' => $skuProperty['ID'],
                                'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                'VALUES' => $skuProperty['VALUES'],
                                'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                            );
                        }

                        unset($skuProperty, $value);

                        if ($item['OFFERS_PROPS_DISPLAY'])
                        {
                            foreach ($item['JS_OFFERS'] as $keyOffer => $jsOffer)
                            {
                                $strProps = '';

                                if (!empty($jsOffer['DISPLAY_PROPERTIES']))
                                {
                                    foreach ($jsOffer['DISPLAY_PROPERTIES'] as $displayProperty)
                                    {
                                        $strProps .= '<dt>'.$displayProperty['NAME'].'</dt><dd>'
                                            .(is_array($displayProperty['VALUE'])
                                                ? implode(' / ', $displayProperty['VALUE'])
                                                : $displayProperty['VALUE'])
                                            .'</dd>';
                                    }
                                }

                                $item['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
                            }
                            unset($jsOffer, $strProps);
                        }
                    }

                    break;
            }
        }
    }

    if (
        $arParams['DISPLAY_COMPARE']
        && (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
    )
    {
        ?>
        <div class="product-item-compare-container">
            <div class="product-item-compare">
                <div class="checkbox">
                    <label id="<?=$itemIds['COMPARE_LINK']?>">
                        <input type="checkbox" data-entity="compare-checkbox">
                        <span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
                    </label>
                </div>
            </div>
        </div>
        <?
    }
    ?>

</div>
<!--/Product-->
