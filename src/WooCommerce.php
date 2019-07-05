<?php
namespace SlimSEO;

class WooCommerce {
	public function __construct() {
		add_action( 'template_redirect', [ $this, 'process' ] );
	}

	public function process() {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}
		add_filter( 'slim_seo_meta_description', [ $this, 'no_description' ] );
	}

	public function no_description( $description ) {
		/*
		 * Strip all shortcodes for WooCommerce pages since they do some logic like setting errors in the session.
		 * Processing these shortcodes might break the WooCommerce (like clearing notices in the session).
		 *
		 * @see https://wordpress.org/support/topic/woocommerce-notices-are-not-showing-after-activating-your-plugin/
		 */
		return $this->is_disabled_page() ? strip_shortcodes( $description ) : $description;
	}

	private function is_disabled_page() {
		$pages = [ 'cart', 'checkout', 'myaccount' ];
		foreach ( $pages as $page ) {
			$page_id = wc_get_page_id( $page );
			if ( is_page( $page_id ) ) {
				return true;
			}
		}

		return false;
	}
}