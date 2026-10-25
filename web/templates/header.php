<!doctype html>
<html class="no-js" lang="<?= $_SESSION["LANGUAGE"] ?>">

<head>
<?php
require $_SERVER["HESTIA"] . "/web/templates/includes/title.php";
require $_SERVER["HESTIA"] . "/web/templates/includes/css.php";
require $_SERVER["HESTIA"] . "/web/templates/includes/js.php";
?>
</head>

<body class="min-h-screen bg-slate-50 font-sans text-sm leading-6 text-slate-700 [color-scheme:light] [&_svg]:size-5 [&_svg]:shrink-0 [&_svg]:fill-none [&_svg]:stroke-current [&_svg]:[stroke-width:1.75] [&_.u-hidden]:hidden! [&_[x-cloak]]:hidden! [&_[hidden]]:hidden! [&_:focus-visible]:outline-2 [&_:focus-visible]:outline-offset-2 [&_:focus-visible]:outline-blue-600 [&_h1]:text-xl [&_h1]:font-semibold [&_h2]:text-lg [&_h2]:font-semibold [&_h3]:font-semibold [&_a]:transition-colors [&_button]:cursor-pointer [&_input[type=checkbox]]:accent-blue-600 [&_.w3vj-sidebar_.container]:px-2 [--chart-label-color:#475569] [--chart-grid-color:#e2e8f0] [--chart-line-1-color:#2563eb] [--chart-line-2-color:#be185d] [--chart-line-3-color:#15803d] md:[&:has(.w3vj-sidebar)_.app]:pl-60 md:[&:has(.w3vj-sidebar)_.top-bar]:left-60 md:[&.w3vj-sidebar-collapsed_.app]:pl-[68px] md:[&.w3vj-sidebar-collapsed_.top-bar]:left-[68px] md:[&.w3vj-sidebar-collapsed_.w3vj-sidebar]:w-[68px] md:[&.w3vj-sidebar-collapsed_.w3vj-sidebar-heading]:flex-col md:[&.w3vj-sidebar-collapsed_.w3vj-nav-label]:sr-only md:[&.w3vj-sidebar-collapsed_.w3vj-nav-count]:sr-only md:[&.w3vj-sidebar-collapsed_.main-menu-stats]:sr-only max-md:[&.w3vj-sidebar-ready_.w3vj-sidebar]:-translate-x-full max-md:[&.w3vj-sidebar-open_.w3vj-sidebar]:translate-x-0 max-md:[&.w3vj-sidebar-open]:overflow-hidden max-md:[&:not(.w3vj-sidebar-ready)_.w3vj-sidebar]:static max-md:[&:not(.w3vj-sidebar-ready)_.w3vj-sidebar]:w-full page-<?= strtolower($TAB) ?> lang-<?= $_SESSION["language"] ?>">
	<div class="app min-h-screen flex flex-col">
