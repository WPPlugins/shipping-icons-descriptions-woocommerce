<?php
/**
 * Shipping Icons and Descriptions for WooCommerce - Core Class
 *
 * @version 1.1.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Shipping_Icons_Descs_Core' ) ) :

class Alg_WC_Shipping_Icons_Descs_Core {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		if ( 'yes' === get_option( 'alg_wc_shipping_icons_descs_enabled', 'yes' ) ) {
			// Shipping Icons
			if ( 'yes' === get_option( 'alg_wc_shipping_icons_enabled', 'no' ) ) {
				add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'shipping_icon' ), PHP_INT_MAX, 2 );
			}
			// Shipping Descriptions
			if ( 'yes' === get_option( 'alg_wc_shipping_descriptions_enabled', 'no' ) ) {
				add_filter( 'woocommerce_cart_shipping_method_full_label', array( $this, 'shipping_description' ), PHP_INT_MAX, 2 );
			}
		}
	}

	/**
	 * is_visible.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function is_visible( $visibility_option ) {
		return ! ( ( 'checkout_only' === $visibility_option && is_cart() ) || ( 'cart_only' === $visibility_option && is_checkout() ) );
	}

	/**
	 * shipping_icon.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function shipping_icon( $label, $method ) {
		if ( ! $this->is_visible( apply_filters( 'alg_wc_shipping_icons_descs', 'both', 'value_icons_visibility' ) ) ) {
			return $label;
		}
		if ( '' != ( $icon_url = get_option( 'alg_wc_shipping_icon_' . $method->method_id, '' ) ) ) {
			$style_html = ( '' != ( $style = get_option( 'alg_wc_shipping_icons_style', 'display:inline;' ) ) ) ?  'style="' . $style . '" ' : '';
			$img = '<img ' . $style_html . 'class="alg_wc_shipping_icon" id="alg_wc_shipping_icon_' . $method->method_id . '" src="' . $icon_url . '">';
			$label = ( 'before' === get_option( 'alg_wc_shipping_icons_position', 'after' ) ) ? $img . ' ' . $label : $label . ' ' . $img;
		}
		return $label;
	}

	/**
	 * shipping_description.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function shipping_description( $label, $method ) {
		if ( ! $this->is_visible( apply_filters( 'alg_wc_shipping_icons_descs', 'both', 'value_descriptions_visibility' ) ) ) {
			return $label;
		}
		if ( '' != ( $desc = get_option( 'alg_wc_shipping_description_' . $method->method_id, '' ) ) ) {
			$label .= $desc;
		}
		return $label;
	}
}

endif;

return new Alg_WC_Shipping_Icons_Descs_Core();
