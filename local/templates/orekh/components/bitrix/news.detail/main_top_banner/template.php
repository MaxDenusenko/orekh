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

<section class="first-section overlay" style="background-image: url(<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>)">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <a href="<?=$arResult["DISPLAY_PROPERTIES"]['ATT_LINK']['VALUE']?>">
                <?= $arResult["PREVIEW_TEXT"];?>
            </a>
        </div>
    </div>
</section>
