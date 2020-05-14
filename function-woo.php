<? //начало документа
//woocommerce


//показывыть цену у вариативных товаров даже если она равна между собой
add_filter('woocommerce_show_variation_price', function() {
    return true;
});



//отключить зум в woocommerce
function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'wp', 'remove_image_zoom_support', 100 );



//конец документа
?>