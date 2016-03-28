Alter how the Add To Cart button works on product archive pages.

Prevent display of the default WooCommerce add to cart button on the product
archive pages if the `no_add_to_cart` option is set to 'yes'.

Display a button that is just the product permalink if
the `no_add_to_cart_permalink` option is set to 'yes'.

Optionally set the button label globally by setting
the `no_add_to_cart_permalink_text` option, set the button label per product
type by setting the `no_add_to_cart_permalink_{product_type}_text` option.

# Options UI

No UI is provided to set these options.

# Installation

This plugin *must* be activated after woocommerce is as it depends
on `wc_get_product_types`.
