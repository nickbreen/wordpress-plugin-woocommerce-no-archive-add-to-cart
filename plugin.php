<?php
/*
Plugin Name: No Archive Add To Cart
Version: 1.0
Description: Alters how the Add To Cart button works on product archive pages.
Author: Nick Breen
Author URI: http://www.foobar.net.nz
Plugin URI: https://github.com/nickbreen/wordpress-plugin-woocommerce-no-add-to-cart
*/

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Alter the button behavior.
    switch (get_option('no_add_to_cart')) {
        case 'permalink':
            /*
            * Fix up the classes on the button.
            */
            add_filter('woocommerce_loop_add_to_cart_args', function ($args, $product) {
                $classes = explode(' ', $args['class']);
                $classes = array_diff($classes, ['ajax_add_to_cart', 'add_to_cart_button']);
                $classes = array_merge($classes, ['no-add-to-cart']);
                $args['class'] = implode(' ', $classes);

                return $args;
            }, 10, 2);
            /*
            * Change the URL to the permalink.
            */
            add_filter('woocommerce_product_add_to_cart_url', function ($url, $product) {
                return get_permalink($product->id);
            }, 10, 2);
            break;
        case 'hide':
            add_action('init', function () {
                remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            }, 10, 0);
            break;
    }

    // Change the text on the button.
    $text_default = get_option('no_add_to_cart_permalink_text');
    $product_types = wc_get_product_types();
    foreach ($product_types as $type => $label) {
        $text_type[$type] = get_option("no_add_to_cart_permalink_{$type}_text");
    }
    // Set the default text if specified.
    if (!empty($text_default)) {
        add_filter('woocommerce_product_add_to_cart_text', function ($text, $product) use ($text_default) {
            return $text_default;
        }, 10, 2);
    }
    // For all types, set the type specific text if specified.
    add_filter('woocommerce_product_add_to_cart_text', function ($text, $_product) use ($text_type) {
        global $product;
        // Use the passed object if available, otherwise use the global.
        $p = $_product ?: $product;

        return !empty($text_type[$p->product_type]) ? $text_type[$p->product_type] : $text;
    }, 10, 2);
}

register_activation_hook(__FILE__, function () {
    // There is no UI for configuring these options
    add_option('no_add_to_cart', null);
    add_option('no_add_to_cart_permalink_text', null);
    $product_types = wc_get_product_types();
    foreach ($product_types as $type => $label) {
        add_option("no_add_to_cart_permalink_{$type}_text", null);
    }
});
