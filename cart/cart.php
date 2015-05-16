<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<!--<table class="shop_table cart" cellspacing="0">-->
	<!--<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>-->
    <div class="container" style="width: 990px; padding: 15px 30px; border: none;">
	<div class="row shop_table cart">
            <div class="col-md-8">
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
        
                <div class="row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <div class="col-md-4 product-thumbnail product-remove">
                        <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                            if ( ! $_product->is_visible() )
                                    echo $thumbnail;
                            else
                                    printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
                        ?>
                        <?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove-trash-icon" title="%s">Remove item</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
                        ?>
                    </div>
                    <div class="col-md-8 product-names">
                        <div class="row">
                            <div class="col-md-12 product-name">
                                <?php
                                    if ( ! $_product->is_visible() )
                                            echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
                                    else
                                            echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

                                    // Meta data
                                    echo WC()->cart->get_item_data( $cart_item );

                                    // Backorder notification
                                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
                                    echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
                                ?>
                            </div>
                        </div>
                    
                        <div class="row product-quantity">
                            <div class="col-md-6">
                                <?php
                                    if ( $_product->is_sold_individually() ) {
                                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                    } else {
                                            $product_quantity = woocommerce_quantity_input( array(
                                                    'input_name'  => "cart[{$cart_item_key}][qty]",
                                                    'input_value' => $cart_item['quantity'],
                                                    'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                                                    'min_value'   => '0'
                                            ), $_product, false );
                                    }

                                    echo 'Quantity: ' . apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
                                ?>
                            </div>
                            <div class="col-md-6 product-price">
                                <?php
                                    //echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
                                ?>
                                <?php
                                    echo 'Price: ' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                                ?>
                            </div>
                            
                        </div>
                    </div>
                </div>
            
            
        
        
        
        
        
				
				<?php
			}
		}
                
		do_action( 'woocommerce_cart_contents' );
		?>
                <div class="row update-button">
                    <input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" />
                </div>
            </div>
            <div class="col-md-4 right-column">
                <div class="row">
                    <h2><?php _e( 'Order Information', 'woocommerce' ); ?></h2>
                    <div class="col-md-12">
                        <?php woocommerce_cart_totals(); ?>
                    </div>
                </div>
                <div class="row coupon-code">
                    <h2>Coupon Code</h2>
                    <div class="col-md-12">
                        <?php if ( WC()->cart->coupons_enabled() ) { ?>
                            <div class="coupon">
                                
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button ac-btn-coupon" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />

                                <?php do_action( 'woocommerce_cart_coupon' ); ?>

                            </div>
                        <?php } ?>

                        <input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" />

                        <?php do_action( 'woocommerce_cart_actions' ); ?>

                        <?php wp_nonce_field( 'woocommerce-cart' ); ?>
                    </div>
                </div>
                
            </div>
            <div class="col-md-8">
                <?php do_action( 'woocommerce_cart_collaterals' ); ?>
            </div>
        </div>
    </div>

	<?php do_action( 'woocommerce_after_cart_contents' ); ?>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
