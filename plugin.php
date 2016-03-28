<?php
/*
Plugin Name: No Archive Add To Cart
Version: 1.0
Description: Alters how the Add To Cart button works on product archive pages.
Author: Nick Breen
Author URI: http://www.foobar.net.nz
Plugin URI: https://github.com/nickbreen/wordpress-plugin-woocommerce-no-add-to-cart
*/


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  //
  // if ('yes' === get_option('no_add_to_cart')) {
  //   add_action('init', function () {
  //     remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
  //   });
  // }
  //
  // if ('yes' === get_option('no_add_to_cart_permalink')) {
  //   add_action('woocommerce_after_shop_loop_item','replace_add_to_cart');
  // }

  add_filter('woocommerce_loop_add_to_cart_args', function ($args, $product) {
    foreach (['ajax_add_to_cart','add_to_cart_button'] as $class)
      $args['class'] = str_replace($class, '', $args['class']);
    return $args;
  });


  if (!empty(get_option('no_add_to_cart_permalink_text'))) {

  }

  $product_types = wc_get_product_types();
  foreach ( $product_types as $type => $label ) {
    if (!empty(get_option("no_add_to_cart_permalink_{$type}_text"))) {

    }
  }
}









register_activation_hook( __FILE__, function () {
  // There is no UI for configuring these options
  add_option('no_add_to_cart', 'yes');
  add_option('no_add_to_cart_permalink', 'yes');
  add_option('no_add_to_cart_permalink_text', '');
  $product_types = wc_get_product_types();
  foreach ( $product_types as $type => $label )
    add_option("no_add_to_cart_permalink_{$type}_text", '');
});
