<?php
function ak_add_scripts() {
	wp_enqueue_style('ak-main-style', plugins_url() . '/ak-github-repo/css/ak-style.css', array(), '1.3');
}
add_action('wp_enqueue_scripts', 'ak_add_scripts');

