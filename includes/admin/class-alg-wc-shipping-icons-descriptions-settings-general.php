<?php
/**
 * Shipping Icons and Descriptions for WooCommerce - General Section Settings
 *
 * @version 1.1.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Alg_WC_Shipping_Icons_Descs_Settings_General' ) ) :

class Alg_WC_Shipping_Icons_Descs_Settings_General extends Alg_WC_Shipping_Icons_Descs_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', 'shipping-icons-descriptions-woocommerce' );
		parent::__construct();
		add_action( 'woocommerce_admin_field_' . 'alg_wc_sid__custom_textarea', array( $this, 'output_custom_textarea' ) );
		add_filter( 'woocommerce_admin_settings_sanitize_option',               array( $this, 'unclean_custom_textarea' ), PHP_INT_MAX, 3 );
	}

	/**
	 * unclean_custom_textarea.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function unclean_custom_textarea( $value, $option, $raw_value ) {
		return ( 'alg_wc_sid__custom_textarea' === $option['type'] ) ? $raw_value : $value;
	}

	/**
	 * output_custom_textarea.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function output_custom_textarea( $value ) {
		$option_value      = get_option( $value['id'], $value['default'] );
		$custom_attributes = ( isset( $value['custom_attributes'] ) && is_array( $value['custom_attributes'] ) ) ? $value['custom_attributes'] : array();
		$description       = ' <p class="description">' . $value['desc'] . '</p>';
		$tooltip_html      = ( isset( $value['desc_tip'] ) && '' != $value['desc_tip'] ) ? '<span class="woocommerce-help-tip" data-tip="' . $value['desc_tip'] . '"></span>' : '';
		// Output
		?><tr valign="top">
			<th scope="row" class="titledesc">
				<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
				<?php echo $tooltip_html; ?>
			</th>
			<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
				<?php echo $description; ?>

				<textarea
					name="<?php echo esc_attr( $value['id'] ); ?>"
					id="<?php echo esc_attr( $value['id'] ); ?>"
					style="<?php echo esc_attr( $value['css'] ); ?>"
					class="<?php echo esc_attr( $value['class'] ); ?>"
					placeholder="<?php echo esc_attr( $value['placeholder'] ); ?>"
					<?php echo implode( ' ', $custom_attributes ); ?>
					><?php echo esc_textarea( $option_value );  ?></textarea>
			</td>
		</tr><?php
	}

	/**
	 * get_section_settings.
	 *
	 * @version 1.1.0
	 * @since   1.0.0
	 * @todo    if ( function_exists( 'WC' ) ) { } else { ? }
	 * @todo    (Booster) add icons and descriptions visibility options
	 * @todo    (maybe) separate settings sections for icons and descriptions
	 */
	function get_section_settings() {
		$settings = array(
			array(
				'title'    => __( 'Shipping Icons and Descriptions Options', 'shipping-icons-descriptions-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_shipping_icons_descs_options',
			),
			array(
				'title'    => __( 'Shipping Icons and Descriptions', 'shipping-icons-descriptions-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable', 'shipping-icons-descriptions-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'WooCommerce Shipping Icons and Descriptions.', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_icons_descs_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_shipping_icons_descs_options',
			),
			array(
				'title'    => __( 'Shipping Icons', 'shipping-icons-descriptions-woocommerce' ),
				'type'     => 'title',
				'id'       => 'alg_wc_shipping_icons_options',
				'desc'     => __( 'Here you can add icons for shipping methods on cart and checkout pages.', 'shipping-icons-descriptions-woocommerce' ),
			),
			array(
				'title'    => __( 'Shipping Icons', 'shipping-icons-descriptions-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable Section', 'shipping-icons-descriptions-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'WooCommerce Shipping Icons.', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_icons_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Icon Position', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_icons_position',
				'default'  => 'after',
				'type'     => 'select',
				'options'  => array(
					'after'  => __( 'After label', 'shipping-icons-descriptions-woocommerce' ),
					'before' => __( 'Before label', 'shipping-icons-descriptions-woocommerce' ),
				),
			),
			array(
				'title'    => __( 'Icon Visibility', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_icons_visibility',
				'default'  => 'both',
				'type'     => 'select',
				'options'  => array(
					'both'          => __( 'On both cart and checkout pages', 'shipping-icons-descriptions-woocommerce' ),
					'cart_only'     => __( 'Only on cart page', 'shipping-icons-descriptions-woocommerce' ),
					'checkout_only' => __( 'Only on checkout page', 'shipping-icons-descriptions-woocommerce' ),
				),
				'desc_tip' => __( 'Possible values: on both cart and checkout pages; only on cart page; only on checkout page', 'shipping-icons-descriptions-woocommerce' ),
				'desc'     => apply_filters( 'alg_wc_shipping_icons_descs', sprintf( __( 'You will need <a target="_blank" href="%s">Shipping Icons and Descriptions for WooCommerce Pro plugin</a> to change icons visibility on pages.', 'shipping-icons-descriptions-woocommerce' ), 'https://wpcodefactory.com/item/shipping-icons-descriptions-woocommerce/' ), 'settings' ),
				'custom_attributes' => apply_filters( 'alg_wc_shipping_icons_descs', array( 'disabled' => 'disabled' ), 'settings' ),
			),
			array(
				'title'    => __( 'Icon Style', 'shipping-icons-descriptions-woocommerce' ),
				'desc_tip' => __( 'You can also style icons with CSS class "alg_wc_shipping_icon", or ID "alg_wc_shipping_icon_method_id"', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_icons_style',
				'default'  => 'display:inline;',
				'type'     => 'text',
				'css'      => 'width:20%;min-width:300px;',
			),
		);
		if ( function_exists( 'WC' ) ) {
			foreach ( WC()->shipping()->get_shipping_methods() as $method ) {
				$settings = array_merge( $settings, array(
					array(
						'title'    => $method->method_title,
						'desc_tip' => __( 'Image URL', 'shipping-icons-descriptions-woocommerce' ),
						'id'       => 'alg_wc_shipping_icon_' . $method->id,
						'default'  => '',
						'type'     => 'text',
						'css'      => 'width:30%;min-width:300px;',
					),
				) );
			}
		}
		$settings = array_merge( $settings, array(
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_shipping_icons_options',
			),
		) );
		$settings = array_merge( $settings, array(
			array(
				'title'    => __( 'Shipping Descriptions', 'shipping-icons-descriptions-woocommerce' ),
				'type'     => 'title',
				'desc'     => sprintf( __( 'Here you can add any text (i.e. description) for shipping methods on cart and checkout pages. You can add HTML tags here, e.g. try %s', 'shipping-icons-descriptions-woocommerce' ), '<code>' . esc_html( '<br><small>Your shipping description.</small>' ) . '</code>' ),
				'id'       => 'alg_wc_shipping_descriptions_options',
			),
			array(
				'title'    => __( 'Shipping Descriptions', 'shipping-icons-descriptions-woocommerce' ),
				'desc'     => '<strong>' . __( 'Enable Section', 'shipping-icons-descriptions-woocommerce' ) . '</strong>',
				'desc_tip' => __( 'WooCommerce Shipping Descriptions.', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_descriptions_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
			),
			array(
				'title'    => __( 'Description Visibility', 'shipping-icons-descriptions-woocommerce' ),
				'id'       => 'alg_wc_shipping_descriptions_visibility',
				'default'  => 'both',
				'type'     => 'select',
				'options'  => array(
					'both'          => __( 'On both cart and checkout pages', 'shipping-icons-descriptions-woocommerce' ),
					'cart_only'     => __( 'Only on cart page', 'shipping-icons-descriptions-woocommerce' ),
					'checkout_only' => __( 'Only on checkout page', 'shipping-icons-descriptions-woocommerce' ),
				),
				'desc_tip' => __( 'Possible values: on both cart and checkout pages; only on cart page; only on checkout page', 'shipping-icons-descriptions-woocommerce' ),
				'desc'     => apply_filters( 'alg_wc_shipping_icons_descs', sprintf( __( 'You will need <a target="_blank" href="%s">Shipping Icons and Descriptions for WooCommerce Pro plugin</a> to change icons visibility on pages.', 'shipping-icons-descriptions-woocommerce' ), 'https://wpcodefactory.com/item/shipping-icons-descriptions-woocommerce/' ), 'settings' ),
				'custom_attributes' => apply_filters( 'alg_wc_shipping_icons_descs', array( 'disabled' => 'disabled' ), 'settings' ),
			),
		) );
		if ( function_exists( 'WC' ) ) {
			foreach ( WC()->shipping->get_shipping_methods() as $method ) {
				$settings = array_merge( $settings, array(
					array(
						'title'    => $method->method_title,
						'id'       => 'alg_wc_shipping_description_' . $method->id,
						'default'  => '',
						'type'     => 'alg_wc_sid__custom_textarea',
						'css'      => 'width:30%;min-width:300px;',
					),
				) );
			}
		}
		$settings = array_merge( $settings, array(
			array(
				'type'     => 'sectionend',
				'id'       => 'alg_wc_shipping_descriptions_options',
			),
		) );
		return $settings;
	}

}

endif;

return new Alg_WC_Shipping_Icons_Descs_Settings_General();
