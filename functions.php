<?php
function child_theme_assets() {
  wp_enqueue_style('child-theme-style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'child_theme_assets');
?>
