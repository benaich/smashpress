<?php


/**
 * the current theme's name
 */
$themeName = "smashpress-theme";


/**
 * this associative array should contians the handle and the url of each javascript asset used by your website
 * it helps you redefine the url of each asset which is usefull when you need to ignore a file or use a cdn url instead
 */
$jsAssets = [
    // ignored jsfiles
    "ignoredJsFile" => "/wp-content/themes/$themeName/dist/silence.js",
	

    // files served by a cdn
    "jquery" => "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js",

    // main js files
    "$themeName-script" => "/wp-content/themes/$themeName/dist/bundle.js",
];


/**
 * has the same purpose as `$jsAssets` for css assets
 */
$cssAssets = [
    // ignored css files
    "ignoredCssFile" => "/wp-content/themes/$themeName/dist/silence.js",


    // files served by a cdn
    // "vc_font_awesome_5" => "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/fontawesome.min.css",

    // main css files
    "$themeName-style" => "/wp-content/themes/$themeName/dist/bundle.css",
];
