<?php
/**
 * Plugin Name: WP REST API Yoast SEO
 * Description: Adds Yoast fields to page and post metadata to WP REST API responses
 * Author: Charlie Francis
 * Author URI: https://github.com/ChazUK
 * Version: 1.2.0
 * Plugin URI: https://github.com/ChazUK/wp-api-yoast-seo
 */
class WPAPIYoastMeta {
    function __construct() {
        add_action('rest_api_init', array($this, 'add_yoast_data'));
    }
    function add_yoast_data() {
        // Posts
        register_rest_field( 'post',
            'yoast',
            array(
                'get_callback'    => array( $this, 'wp_api_encode_yoast' ),
                'update_callback' => null,
                'schema'          => null,
            )
        );
        // Pages
        register_rest_field( 'page',
            'yoast',
            array(
                'get_callback'    => array( $this, 'wp_api_encode_yoast' ),
                'update_callback' => null,
                'schema'          => null,
            )
        );
        // Public custom post types
        $types = get_post_types(array(
            'public' => true,
            '_builtin' => false
        ));
        foreach($types as $key => $type) {
            register_rest_field( $type,
                'yoast',
                array(
                    'get_callback'    => array( $this, 'wp_api_encode_yoast' ),
                    'update_callback' => null,
                    'schema'          => null,
                )
            );
        }
    }

    function wp_api_encode_yoast($post, $field_name, $request) {

        $yoastMeta = array(
            'test' => $post['id'],
            'focuskw' => get_post_meta($post['id'],'_yoast_wpseo_focuskw', true),
            'title' => get_post_meta($post['id'], '_yoast_wpseo_title', true),
            'metadesc' => get_post_meta($post['id'], '_yoast_wpseo_metadesc', true),
            'linkdex' => get_post_meta($post['id'], '_yoast_wpseo_linkdex', true),
            'metakeywords' => get_post_meta($post['id'], '_yoast_wpseo_metakeywords', true),
            'meta_robots_noindex' => get_post_meta($post['id'], '_yoast_wpseo_meta-robots-noindex', true),
            'meta_robots_nofollow' => get_post_meta($post['id'], '_yoast_wpseo_meta_robots-nofollow', true),
            'meta_robots_adv' => get_post_meta($post['id'], '_yoast_wpseo_meta-robots-adv', true),
            'canonical' => get_post_meta($post['id'], '_yoast_wpseo_canonical', true),
            'redirect' => get_post_meta($post['id'], '_yoast_wpseo_redirect', true),
            'opengraph_title' => get_post_meta($post['id'], '_yoast_wpseo_opengraph-title', true),
            'opengraph_description' => get_post_meta($post['id'], '_yoast_wpseo_opengraph-description', true),
            'opengraph_image' => get_post_meta($post['id'], '_yoast_wpseo_opengraph-image', true),
            'twitter_title' => get_post_meta($post['id'], '_yoast_wpseo_twitter-title', true),
            'twitter_description' => get_post_meta($post['id'], '_yoast_wpseo_twitter-description', true),
            'twitter_image' => get_post_meta($post['id'], '_yoast_wpseo_twitter-image', true)
        );
        return (array) $yoastMeta;
    }
}
$WPAPIYoastMeta = new WPAPIYoastMeta();