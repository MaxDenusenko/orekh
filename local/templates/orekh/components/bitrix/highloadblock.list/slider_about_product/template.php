<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}
?>

<?php if (isset($arResult['rows']) && is_array($arResult['rows']) && count($arResult['rows'])) :?>
    <div class="col-md-7">
        <!-- Swiper -->
        <div class="manufacturer-container swiper-container">
            <div class="swiper-wrapper">

                <? foreach ($arResult['rows'] as $row): ?>
                    <div class="swiper-slide">
                        <div class="manufacturer__item manufacturer__item_video">
                            <?= $row['UF_FILE'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <!-- Add Arrows -->
            <div class="wrap">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
<?php endif; ?>
