<?
use Bitrix\Main\Page\Asset;
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;
?>

<!DOCTYPE html>
<html lang="ru">

    <head>
        <title><?$APPLICATION->ShowTitle();?></title>

        <!-- Responsive -->
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <meta name="theme-color" content="#337D5A">

        <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/icon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="128x128" href="<?=SITE_TEMPLATE_PATH?>/img/apple.png">

        <!-- Touch -->
        <meta name="format-detection" content="telephone=no">
        <meta name="format-detection" content="address=no">

        <?php
        $APPLICATION->ShowHead();

        //CSS
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/main.min.css");
        ?>
    </head>

    <body class="home <?$APPLICATION->ShowProperty("body_class")?>">

        <?$APPLICATION->ShowPanel();?>

        <div class="mobile-menu d-lg-none">
            <div class="row">
                <div class="col-12">
                    <a href="<?=SITE_DIR?>" class="logo">
                        <img src="<?= CFile::GetPath(\COption::GetOptionString( "askaron.settings", "UF_SITE_LOGO"));?>" alt="Site logo">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/header/logo-text.php"
                            )
                        );?>
                    </a>
                    <i class="nut-icon icons-close-button"></i>
                </div>
            </div>
        </div>

        <header class="top-header">
            <div class="top-header__line">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12 d-lg-block d-none">

                            <ul class="line_social">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:menu",
                                    "social_links",
                                    Array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "1",
                                        "MENU_CACHE_GET_VARS" => array(""),
                                        "MENU_CACHE_TIME" => "3600",
                                        "MENU_CACHE_TYPE" => "A",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "subsocial",
                                        "USE_EXT" => "N"
                                    )
                                );?>
                            </ul>

                        </div>
                        <div class="col-lg-4 col-12 d-lg-flex d-none justify-content-center">
                            <? $APPLICATION->IncludeComponent(
                                "dv:user.discount.group",
                                ".default",
                                Array(),
                                false
                            );?>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="wrap">

                                <?if(!$USER->IsAuthorized()):?>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "EDIT_TEMPLATE" => "",
                                            "PATH" => "/include/header/unauthorized-user-link.php"
                                        )
                                    );?>
                                <?else:?>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        Array(
                                            "AREA_FILE_SHOW" => "file",
                                            "AREA_FILE_SUFFIX" => "inc",
                                            "EDIT_TEMPLATE" => "",
                                            "PATH" => "/include/header/authorized-user-link.php"
                                        )
                                    );?>
                                <?endif;?>

                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.site.selector",
                                    "default",
                                    Array(
                                        "CACHE_TIME" => "3600",
                                        "CACHE_TYPE" => "A",
                                        "SITE_LIST" => array()
                                    )
                                );?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-header__logo">
                <div class="container">
                    <div class="row">
                        <div class="col-2 d-lg-none">
                            <div class="mobile-menu-button d-lg-none d-block"><img src="<?=SITE_TEMPLATE_PATH?>/img/menu.svg" alt="alt"></div>
                        </div>
                        <div class="col-xl-4 col-lg-3 col-8 align-self-center">

                            <a href="<?=SITE_DIR?>" class="logo">
                                <img src="<?= CFile::GetPath(\COption::GetOptionString( "askaron.settings", "UF_SITE_LOGO"));?>" alt="Site logo">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/header/logo-text.php"
                                    )
                                );?>
                            </a>

                        </div>
                        <div class="col-xl-8 col-lg-9 col-2 align-self-center">
                            <div class="row">
                                <div class="col-lg-6 col-12 align-self-center d-lg-block d-none">
                                    <div class="wrap">

                                        <ul class="logo_social">
                                            <?$APPLICATION->IncludeComponent(
                                            "bitrix:menu",
                                            "social_links",
                                                Array(
                                                    "ALLOW_MULTI_SELECT" => "N",
                                                    "CHILD_MENU_TYPE" => "",
                                                    "DELAY" => "N",
                                                    "MAX_LEVEL" => "1",
                                                    "MENU_CACHE_GET_VARS" => array(""),
                                                    "MENU_CACHE_TIME" => "3600",
                                                    "MENU_CACHE_TYPE" => "A",
                                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                                    "ROOT_MENU_TYPE" => "social",
                                                    "USE_EXT" => "N"
                                                )
                                            );?>
                                        </ul>

                                        <?php $PHONES = \COption::GetOptionString( "askaron.settings", "UF_SITE_TELEPHONES_LIST"); ?>
                                        <?php if (isset($PHONES) && is_array($PHONES) && count($PHONES)) :?>
                                            <ul class="logo_tel">
                                                <?php foreach ($PHONES as $PHONE) :?>
                                                    <li>
                                                        <a href="tel:<?=str_replace([' ', '(', ')', '-'], '', strip_tags($PHONE))?>"><?=$PHONE?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 align-self-center">
                                    <div class="wraper">

                                        <?php if ($PHONE_FOR_MOBILE = \COption::GetOptionString( "askaron.settings", "UF_SITE_TELEPHONE_FOR_MOBILE")) :?>
                                            <ul class="logo_tel_mobile d-lg-none d-flex">
                                                <li>
                                                    <a href="tel:<?=str_replace([' ', '(', ')', '-'], '', strip_tags($PHONE_FOR_MOBILE))?>"><?=$PHONE_FOR_MOBILE?></a>
                                                </li>
                                            </ul>
                                        <?php endif; ?>

                                        <ul class="logo_button_mobile d-lg-none d-flex">
                                            <?$APPLICATION->IncludeComponent(
                                                "bitrix:main.include",
                                                "",
                                                Array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "AREA_FILE_SUFFIX" => "inc",
                                                    "EDIT_TEMPLATE" => "",
                                                    "PATH" => "/include/header/request-call-button.php"
                                                )
                                            );?>
                                        </ul>

                                        <ul class="logo_button d-lg-flex d-none">

                                            <?$APPLICATION->IncludeComponent(
                                                "bitrix:main.include",
                                                "",
                                                Array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "AREA_FILE_SUFFIX" => "inc",
                                                    "EDIT_TEMPLATE" => "",
                                                    "PATH" => "/include/header/request-call-button.php"
                                                )
                                            );?>

                                            <?$APPLICATION->IncludeComponent(
                                                "bitrix:main.include",
                                                "",
                                                Array(
                                                    "AREA_FILE_SHOW" => "file",
                                                    "AREA_FILE_SUFFIX" => "inc",
                                                    "EDIT_TEMPLATE" => "",
                                                    "PATH" => "/include/header/request-call-button-desc.php"
                                                )
                                            );?>

                                        </ul>

                                        <?$APPLICATION->IncludeComponent(
                                            "bitrix:sale.basket.basket.line",
                                            "default",
                                            Array(
                                                "HIDE_ON_BASKET_PAGES" => "Y",
                                                "PATH_TO_AUTHORIZE" => "",
                                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                                "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                                "PATH_TO_REGISTER" => SITE_DIR."login/",
                                                "POSITION_FIXED" => "N",
                                                "SHOW_AUTHOR" => "N",
                                                "SHOW_EMPTY_VALUES" => "N",
                                                "SHOW_NUM_PRODUCTS" => "Y",
                                                "SHOW_PERSONAL_LINK" => "N",
                                                "SHOW_PRODUCTS" => "Y",
                                                "SHOW_REGISTRATION" => "N",
                                                "SHOW_TOTAL_PRICE" => "Y"
                                            )
                                        );?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="top-header__discount d-lg-none d-flex">
                <? $APPLICATION->IncludeComponent(
                    "dv:user.discount.group",
                    ".default",
                    Array(),
                    false
                );?>
            </div>

            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "top_menu",
                Array(
                    "ALLOW_MULTI_SELECT" => "N",
                    "CHILD_MENU_TYPE" => "",
                    "DELAY" => "N",
                    "MAX_LEVEL" => "1",
                    "MENU_CACHE_GET_VARS" => array(""),
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "ROOT_MENU_TYPE" => "top",
                    "USE_EXT" => "N"
                )
            );?>

        </header>

        <div id="basket_line_root" class="container pr"></div>
