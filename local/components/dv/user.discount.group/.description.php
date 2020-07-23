<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("Персональная скидка"),
    "DESCRIPTION" => GetMessage("Выводим персональную скидку для пользователя"),
    "PATH" => array(
        "ID" => "dv_components",
        "CHILD" => array(
            "ID" => "user.discount.group",
            "NAME" => "Персональная скидка"
        )
    ),
);
