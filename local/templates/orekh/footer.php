<?
use Bitrix\Main\Page\Asset;
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>

        <footer class="footer__bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-12">
                        <div class="wrap">
                            <h2>Контакты</h2>
                            <div class="bottom_social">
                                <div class="bottom_social_tel">
                                    <i class="nut-icon icons-phone"></i>
                                    <?php $PHONES = \COption::GetOptionString( "askaron.settings", "UF_SITE_TELEPHONES_LIST"); ?>
                                    <?php if (isset($PHONES) && is_array($PHONES) && count($PHONES)) :?>
                                        <ul>
                                            <?php foreach ($PHONES as $PHONE) :?>
                                                <li>
                                                    <a href="tel:<?=str_replace([' ', '(', ')', '-'], '', strip_tags($PHONE))?>"><?=$PHONE?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>

                                <div class="bottom_social_links">
                                    <ul>
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
                                </div>

                            </div>

                            <?php if ($SITE_EMAIL = \COption::GetOptionString( "askaron.settings", "UF_SITE_EMAIL")) :?>
                                <div class="bottom_mail">
                                    <a href="mailto:nuts@nbsc.com.ua"><i class="nut-icon icons-post"></i> <?=$SITE_EMAIL?></a>
                                </div>
                            <?php endif; ?>

                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/footer/bottom-address.php"
                                )
                            );?>

                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/footer/map.php"
                            )
                        );?>
                    </div>
                </div>
                <div class="bottom_menu">
                    <div class="row align-items-center ">
                        <div class="col-lg-2">
                            <div class="wraper">
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
                        </div>

                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bottom_menu",
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

                    </div>
                </div>
            </div>
            <div class="copy">
                <div class="container">
                    <div class="row align-items-center ">

                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/footer/developers.php"
                            )
                        );?>

                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/footer/copy.php"
                            )
                        );?>

                        <div class="col-md-4 col-12">
                            <ul class="copy__social">
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

                    </div>
                </div>
            </div>
        </footer>

        <?php
        //JS
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/scripts.js");
        Asset::getInstance()->addString('<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVofcK1JyIWtVb3kaEbvHi9WqHCteWpxI&amp;callback=initMap"></script>');
        ?>

    </body>
</html>
