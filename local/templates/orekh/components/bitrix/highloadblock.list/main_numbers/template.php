<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}
?>

<?php if (isset($arResult['rows']) && is_array($arResult['rows']) && count($arResult['rows'])) :?>

    <?php $arResult['rows'] = array_chunk($arResult['rows'], 4) ?>
    <section class="timer">
        <div class="container">
            <? foreach ($arResult['rows'] as $row): ?>
                <div class="row">

                    <? foreach ($row as $item): ?>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="wrap">
                                <?php
                                $data_attr = 'data-from="'.strip_tags($item['UF_NUMBER_FROM']).'" ';
                                $data_attr .= 'data-to="'.strip_tags($item['UF_NUMBER_TO']).'" ';
                                $data_attr .= 'data-speed="'.strip_tags($item['UF_SPEED']).'" ';
                                if ($item['UF_REFRESH_INTERVAL'] && strip_tags($item['UF_REFRESH_INTERVAL']) > 0) {
                                    $data_attr .= 'data-refresh-interval="'.strip_tags($item['UF_REFRESH_INTERVAL']).'" ';
                                }
                                ?>
                                <span class="timer__single" <?=$data_attr?> ></span>
                                <sup><?=$item['UF_DESCRIPTION']?></sup>
                                <div class="timer__descr"><?=$item['UF_FULL_DESCRIPTION']?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

<?php endif; ?>
