<?php
/**
 * Plugin Name: getgigwp
 * Author: team Get Gig
 * Description: /!\ Warning Do Not Deactivate
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use getgigwp\Plugin;
use getgigwp\Api;
require __DIR__ . '/vendor-getgigwp/autoload.php';

$Wpprojetplugins = new Plugin();
// DOC WP PLUGININ activation "hook" : https://developer.wordpress.org/reference/functions/register_activation_hook/
register_activation_hook(
   __FILE__,
   [$Wpprojetplugins, 'activate'],
);
register_deactivation_hook(
   __FILE__,
   [$Wpprojetplugins, 'deactivate'],
);
$api = new Api();