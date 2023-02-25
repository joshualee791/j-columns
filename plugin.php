<?php
/**
 * Plugin Name: J-Columns
 * Plugin URI: https://mysocialpractice.com
 * Description: Adds Advanced Custom Fields data as a sortable column in the pages admin screen.
 * Version: 1.0.0
 * Author: Joshua L. Garza
 * Author URI: https://mysocialpractice.com
 * License: GPL2
 */

 function acf_page_column_head( $columns ) {
    $columns['acf_data'] = 'Specialist Content';
    return $columns;
}
add_filter( 'manage_pages_columns', 'acf_page_column_head' );

function acf_page_column_content( $column_name, $post_id ) {
    if ( $column_name == 'acf_data' ) {
        $acf_data = get_field( 'specialist_content_category', $post_id );
        echo $acf_data;
    }
}
add_action( 'manage_pages_custom_column', 'acf_page_column_content', 10, 2 );

function acf_page_column_sortable( $columns ) {
    $columns['acf_data'] = 'specialist_content_category';
    return $columns;
}
add_filter( 'manage_edit-page_sortable_columns', 'acf_page_column_sortable' );

function acf_page_column_orderby( $query ) {
    if ( ! is_admin() ) {
        return;
    }
    $orderby = $query->get( 'orderby' );
    if ( 'specialist_content_category' == $orderby ) {
        $query->set( 'meta_key', 'specialist_content_category' );
        $query->set( 'orderby', 'meta_value' );
    }
}
add_action( 'pre_get_posts', 'acf_page_column_orderby' );
