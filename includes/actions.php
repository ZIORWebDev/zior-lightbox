<?php
/**
 * Enqueue JS and CSS assets
 */
function zior_lightbox_frontend_scripts() {
	wp_enqueue_style( 'zior-lightbox', ZR_LIGHTBOX_PLUGIN_URL . 'build/zr-lightbox.min.css' );
	wp_enqueue_script( 'zior-lightbox', ZR_LIGHTBOX_PLUGIN_URL . 'build/zr-lightbox.min.js', [ 'jquery' ], ZR_LIGHTBOX_VERSION, true );

	$zrl_disable_on_href = get_option( 'zrl_disable_on_href', true );
	$zrl_allowed_classes = get_option( 'zrl_allowed_classes' );
	$zrl_allowed_parent_classes = get_option( 'zrl_allowed_parent_classes' );
	$zrl_disabled_classes = get_option( 'zrl_disabled_classes' );
	$zrl_disabled_parent_classes = get_option( 'zrl_disabled_parent_classes' );

	$args = [
		'disable_on_href'         => $zrl_disable_on_href,
		'allowed_classes'         => ! empty( $zrl_allowed_classes ) ? explode( ',', $zrl_allowed_classes ) : [],
		'allowed_parent_classes'  => ! empty( $zrl_allowed_parent_classes ) ? explode( ',', $zrl_allowed_parent_classes ) : [],
		'disabled_classes'        => ! empty( $zrl_disabled_classes ) ? explode( ',', $zrl_disabled_classes ) : [],
		'disabled_parent_classes' => ! empty( $zrl_disabled_parent_classes ) ? explode( ',', $zrl_disabled_parent_classes ) : [],
	];

	wp_localize_script( 'zior-lightbox', 'ziorLB', $args );
}
add_action( 'wp_enqueue_scripts', 'zior_lightbox_frontend_scripts', 10 );