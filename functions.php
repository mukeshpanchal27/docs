<?php

// Define paths
define( 'DOCS_URI', get_stylesheet_directory_uri() . '/_docpress' );
define( 'DOCS_PATH', dirname(__FILE__) . '/_docpress' );

// Require theme functions
require_once( 'functions/enqueue-styles.php' );
require_once( 'functions/enqueue-scripts.php' );

// Helpers
require_once( 'functions/get-current-url.php' );

// Docpress
require_once( 'functions/docpress-get-dirs.php' );
require_once( 'functions/docpress-get-file-path.php' );
require_once( 'functions/docpress-make-absolute-urls.php' );

define( 'DOCS_FILE_PATH', docpress_get_file_path() );

// Block 301 redirect.
add_filter( 'redirect_canonical', function( $redirect_url, $requested_url ) {
    if ( strpos( $requested_url, 'api/tide/v1' ) === false ) {
        return '';
    }
}, 10, 2 );

/**
 * Filter to override a 404.
 *
 * The links are actually 404 errors, the pages don't exist really. We're faking status 200
 * We just use the routes to pass in info on what file we want to include within index.php.
 */
add_filter( 'template_redirect', function() {
	global $wp_query;

	if ( file_exists( DOCS_FILE_PATH ) ) {
		status_header( 200 );
		$wp_query->is_404=false;
	}
} );
