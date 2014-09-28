<?php
/**
 * Plugin Name: WooCommerce Twilio Notification
 * Plugin URI: N/A
 * Description: Allows owner to receive a Twilio SMS notification every time an order is placed
 * Version: 0.0.1
 * Author: Alex Bain
 * Author URI: http://alexba.in
 * License: ???
 */

// Include Twilio Library
require 'lib/twilio-php/Services/Twilio.php';

// Bind to action that fires after order is placed
add_action('woocommerce_thankyou', 'send_twilio_notification');

// Send a Twilio SMS notification
function send_twilio_notification() {
    global $woocommerce;
}
