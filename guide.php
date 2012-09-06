<?php
    include "html.class.php";
	$html = new classHtml();
	$html->printHeader("Ведрулька — Главная","main.css");
	$html->printLogo();
	$html->printMainMenu();
	$html->printHtmlContent();
	$html->printFooter();
?>