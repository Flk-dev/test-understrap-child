<?php

add_action( 'wp_enqueue_scripts', 'rs_enqueue_scripts' );
function rs_enqueue_scripts() {
	wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css' );
}