<?php

class Debug_Bar_Cache_Lookup extends Debug_Bar_Panel {

	function init() {
		$this->title( __( 'Cache Lookup', 'dbcl' ) );
	}

	function prerender() {
		global $wp_object_cache;
		$this->set_visible( is_object( $wp_object_cache ) && method_exists( $wp_object_cache, 'stats' ) );
	}

	function render() {
		include DBCL_PATH . 'views/searchform.php';
	}
	

}
