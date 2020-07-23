<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$this->IncludeLangFile('template.php');

$cartId = $arParams['cartId'];

require(realpath(dirname(__FILE__)).'/top_template.php');
?>

<?php ob_start(); ?>
    <?php if ($arParams["SHOW_PRODUCTS"] == "Y") :?>

        <div class="popup__cart" id="<?=$cartId?>products_container">
            <div class="wrap" id="<?=$cartId?>products">

                <?php if ($arResult['NUM_PRODUCTS'] > 0 || !empty($arResult['CATEGORIES']['DELAY'])) :?>

                    <?foreach ($arResult["CATEGORIES"] as $category => $items):
                        if (empty($items)) continue; ?>

                        <?foreach ($items as $v):?>

                            <div class="popup__cart_item">
                                <div class="row align-items-center no-gutters item_row">
                                    <div class="col-md-5 col-12">
                                        <div class="item_title">
                                            <p><?=$v["NAME"]?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-12">
                                        <div class="row align-items-center no-gutters">
                                            <div class="col-6">
                                                <div class="item_quantity">
                                                    <button type="button" class="quantity_minus" onclick="<?=$cartId?>.pickUpItemFromCart(<?=$v['ID']?>)">
                                                        <i class="nut-icon icons-qty-left"></i>
                                                    </button>
                                                    <input onchange="<?=$cartId?>.setCountItemForCart(<?=$v['ID']?>, this.value)" type="text" name="quantity" value="<?=$v["QUANTITY"]?>" class="quantity_input">
                                                    <button type="button" class="quantity_plus" onclick="<?=$cartId?>.appendItemToCart(<?=$v['ID']?>)">
                                                        <i class="nut-icon icons-qty-right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="item_sum">
                                                    <p><?=$v["SUM"]?></p>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="item_close bx-basket-item-list-item-remove" onclick="<?=$cartId?>.removeItemFromCart(<?=$v['ID']?>)" title="<?=GetMessage("TSB1_DELETE")?>">
                                                    <a href="#">
                                                        <i class="nut-icon icons-close-button"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?endforeach?>

                    <?endforeach?>

                    <div class="popup__cart_sum">
                        <div class="sum_item">
                            <div class="sum_item_title">
                                <p><?=GetMessage('TSB1_TOTAL_PRICE_2')?> </p>
                            </div>
                            <div class="sum_item_new">
                                <p><?=$arResult['TOTAL_PRICE']?></p>
                            </div>
                        </div>
                        <div class="sum_item">
                            <div class="sum_item_button">
                                <a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="button"><?= GetMessage('TSB1_TO_BASKET') ?></a>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Если корзина пуста -->
                    <div class="popup__cart_clean">
                        <p><?= GetMessage('TSB1_TO_BASKET_EMPTY') ?></p>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    <?php endif; ?>
<?php $basket_html = ob_get_contents(); ob_end_clean(); ?>

<script>
    BX.ready(function(){
        <?=$cartId?>.fixCart();
        BX('basket_line_root').innerHTML = "<?=CUtil::JSEscape ($basket_html)?>";

        // окно корзины
        $('.logo_number').click(function() {
            $('.popup__cart').stop().slideToggle('swing');
        });

    });
</script>
