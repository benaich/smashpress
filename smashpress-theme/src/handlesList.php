<?php

// list used js/css
add_action('wp_print_footer_scripts', 'list_assets', 900000);
function list_assets()
{
    global $wp_scripts;
    global $wp_styles;

    $jsHandles = getHandles($wp_scripts);
    $cssHandles = getHandles($wp_styles);

    echo "<!-- \n";
    echo "jsHandles=( " . join(" ", $jsHandles) . " )\n";
    echo "cssHandles=( " . join(" ", $cssHandles) . " )\n";
    echo "-->";
}

function getHandles($wp_asset)
{
    $filtered = array_filter($wp_asset->queue, function ($item) use ($wp_asset) {
        return is_object($wp_asset->registered[$item]);
    });

    return array_map(function ($item) use ($wp_asset) {
        $asset = $wp_asset->registered[$item];
        return $asset->handle;
    }, $filtered);
}
