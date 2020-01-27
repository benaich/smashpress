<?php

/**
 * Redefine js urls
 */
add_action('init', function () {
    foreach ($GLOBALS['jsAssets'] as $handle => $path) {
        wp_deregister_script($handle);
        wp_register_script($handle, $path, false, null, true);
        wp_enqueue_script($handle);
    }
});

/**
 * Redefine css urls
 */
add_action('init', function () {
    foreach ($GLOBALS['cssAssets'] as $handle => $path) {
        wp_deregister_style($handle);
        wp_register_style($handle, $path, [], false);
        wp_enqueue_style($handle);
    }
});

/**
 * Remove Query String from Static Resources
 */
function remove_css_js_version($src) {
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);
    return $src;
}
add_filter('style_loader_src', 'remove_css_js_version', 10, 2);
add_filter('script_loader_src', 'remove_css_js_version', 10, 2);

/**
 * Remove Emojis
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

/**
 * Remove Shortlink
 */
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * Disable Embed
 */
function disable_embed() {
    wp_dequeue_script('wp-embed');
}
add_action('wp_footer', 'disable_embed');

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove RSD Link
 */
remove_action('wp_head', 'rsd_link');

/**
 * Hide Version
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove WLManifest Link
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Disable Self Pingback
 */
function disable_pingback(&$links) {
    foreach ($links as $l => $link)
        if (0 === strpos($link, get_option('home')))
            unset($links[$l]);
}

add_action('pre_ping', 'disable_pingback');

/**
 * Disable Heartbeat
 */
add_action('init', 'stop_heartbeat', 1);
function stop_heartbeat() {
    wp_deregister_script('heartbeat');
}


/**
 * Defer Pasing JavaScript for entire website, including Plugins, but without jQuery.js
 */
function defer_parsing_of_js($url) {
    if (false === strpos($url, '.js')) {
        return $url;
    }
    return "$url' async='async";
}
add_filter('clean_url', 'defer_parsing_of_js', 11, 1);
