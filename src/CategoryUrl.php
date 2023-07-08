<?php
namespace SlimSEO;

class CategoryUrl {
	public function setup() {
		add_action( 'init', [ $this, 'change_permastruct' ] );
	}

	public function change_permastruct() {
		global $wp_rewrite;
		$wp_rewrite->extra_permastructs['category'][0] = '%category%';
	}
}