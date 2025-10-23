<?php
/*
Plugin Name: XShift
Description: API plugin to transfer your data to xshop
Version: 1.0
Author: xStack
*/

if (!defined('ABSPATH')) {
    exit; // Prevent direct access.
}

class XShift
{

    /**
     * Register REST routes.
     */
    public static function init()
    {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    /**
     * Register the two endpoints.
     */
    public static function register_routes()
    {
        // /wp-json/xshift/v1/categories
        register_rest_route(
            'xshift/v1',
            '/categories',
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [__CLASS__, 'get_categories'],
                'permission_callback' => '__return_true',
            ]
        );

        // /wp-json/xshift/v1/posts
        register_rest_route(
            'xshift/v1',
            '/posts',
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [__CLASS__, 'get_posts'],
                'permission_callback' => '__return_true',
            ]
        );
        register_rest_route(
            'xshift/v1',
            '/product-categories',
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [__CLASS__, 'get_woocommerce_categories'],
                'permission_callback' => '__return_true',
            ]
        );
        register_rest_route(
            'xshift/v1',
            '/products',
            [
                'methods' => WP_REST_Server::READABLE,
                'callback' => [__CLASS__, 'get_woocommerce_products'],
                'permission_callback' => '__return_true',
            ]
        );
    }

    /**
     * Return a complete list of categories.
     *
     * Fields: id, title, slug, parent_id, description
     *
     * @return WP_REST_Response
     */
    public static function get_categories()
    {
        $terms = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => false,
        ]);

        $data = [];

        foreach ($terms as $term) {
            $data[] = [
                'id' => $term->term_id,
                'title' => $term->name,
                'link' => get_term_link($term),
                'slug' => $term->slug,
                'parent_id' => $term->parent,
                'description' => $term->description,
            ];
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Return all published posts.
     *
     * Fields: id, title, slug, content, excerpt, featured_image, tags, categories
     *
     * @return WP_REST_Response
     */
    public static function get_posts()
    {
        $posts = get_posts([
            'post_type' => 'post',
            'post_status' => 'publish',
            'numberposts' => -1, // No pagination – fetch everything.
        ]);

        $data = [];

        foreach ($posts as $post) {
            // Featured image URL (fallback to null if none).
            $featured_image = get_the_post_thumbnail_url($post->ID, 'full');

            // Tags (array of tag names).
            $tag_terms = wp_get_post_terms($post->ID, 'post_tag', ['fields' => 'names']);

            // Categories (array of category IDs).
            $cat_terms = wp_get_post_terms($post->ID, 'category', ['fields' => 'ids']);

            $data[] = [
                'id' => $post->ID,
                'title' => get_the_title($post),
                'link' => get_permalink($post),
                'slug' => $post->post_name,
                'content' => apply_filters('the_content', $post->post_content),
                'excerpt' => get_the_excerpt($post),
                'featured_image' => $featured_image,
                'tags' => $tag_terms,
                'categories' => $cat_terms,
                'date' => get_the_date('Y-m-d H:i:s', $post),
            ];
        }

        return new WP_REST_Response($data, 200);
    }

    /**
     * Return WooCommerce product categories (if WooCommerce is active).
     *
     * Fields: id, title, slug, parent_id, description, thumbnail (high‑resolution URL)
     *
     * @return WP_REST_Response
     */
    public static function get_woocommerce_categories()
    {
        // Bail if WooCommerce is not active.
        if (!class_exists('WooCommerce')) {
            return new WP_REST_Response([], 200);
        }

        $terms = get_terms([
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ]);

        $data = [];

        foreach ($terms as $term) {
            // Get the thumbnail ID set for the product category.
            $thumb_id = get_term_meta($term->term_id, 'thumbnail_id', true);

            // Retrieve the full‑size image URL (fallback to null).
            $thumbnail_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, 'full') : null;

            $data[] = [
                'id' => $term->term_id,
                'title' => $term->name,
                'slug' => $term->slug,
                'parent_id' => $term->parent,
                'description' => $term->description,
                'thumbnail' => $thumbnail_url,
            ];
        }

        return new WP_REST_Response($data, 200);
    }


    /**
     * Return all WooCommerce products (if WooCommerce is active).
     *
     * Fields:
     *   id, name, short_description, description, slug, link, images,
     *   tags, product_category_ids, brands, additional_informations,
     *   stock, sku, price
     *
     * @return WP_REST_Response
     */
    public static function get_woocommerce_products()
    {
        // Exit if WooCommerce is not active.
        if (!class_exists('WooCommerce')) {
            return new WP_REST_Response([], 200);
        }


        $args = [
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1, // No pagination.
        ];

        $products = get_posts($args);
        $data = [];

        foreach ($products as $product_post) {
            $product = wc_get_product($product_post->ID);

            // Main image (full size) – fallback to null.
            $main_image_id = $product->get_image_id();
            $main_image = $main_image_id
                ? wp_get_attachment_image_url($main_image_id, 'full')
                : null;

            // Gallery images (full size), include main image as first item.
            $gallery_ids = $product->get_gallery_image_ids();
            $images = $main_image ? [$main_image] : [];
            foreach ($gallery_ids as $img_id) {
                $url = wp_get_attachment_image_url($img_id, 'full');
                if ($url) {
                    $images[] = $url;
                }
            }

            // Tags (array of tag names).
            $tag_terms = wp_get_post_terms($product->get_id(), 'product_tag', ['fields' => 'names']);

            // Category IDs.
            $cat_terms = wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'ids']);

//			// Brands – assumes a taxonomy named 'brand' (common in many setups).
//			$brand_terms = wp_get_post_terms( $product->get_id(), 'brand', [ 'fields' => 'all' ] );
//			$brands      = [];
//			foreach ( $brand_terms as $brand ) {
//				$brands[] = [
//					'id'   => $brand->term_id,
//					'slug' => $brand->slug,
//					'name' => $brand->name,
//				];
//			}


            // Additional informations – product attributes.
            $attributes = $product->get_attributes();
            $additional = [];
            foreach ($attributes as $attr) {
                $name = wc_attribute_label($attr->get_name());
                $values = [];

                if ($attr->is_taxonomy()) {
                    $terms = wp_get_post_terms($product->get_id(), $attr->get_name(), ['fields' => 'names']);
                    $values = $terms;
                } else {
                    $values = $attr->get_options(); // plain values.
                }

                $additional[] = [
                    'key' => $name,
                    'value' => $values,
                ];
            }

            $data[] = [
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'short_description' => $product->get_short_description(),
                'description' => $product->get_description(),
                'slug' => $product->get_slug(),
                'link' => $product->get_permalink(),
                'images' => $images,
                'tags' => $tag_terms,
                'product_category_ids' => $cat_terms,
//				'brands'                 => $brands,
                'additional_informations' => $additional,
                'stock' => $product->get_stock_status(),
                'count' => $product->get_stock_quantity(),
                'sku' => trim($product->get_sku()) == '' ? null : $product->get_sku(),
                'price' => $product->get_price(), // numeric string, no currency.
                'date' => $product->get_date_created('Y-m-d H:i:s')->date('Y-m-d H:i:s'),
            ];
        }

        return new WP_REST_Response($data, 200);
    }


}

// Initialise the plugin.
XShift::init();
