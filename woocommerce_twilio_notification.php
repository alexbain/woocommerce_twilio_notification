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

/**
 * Exit if accessed directly
 **/
if (!defined('ABSPATH')) { exit; }

/**
 * Check if WooCommerce is active
 **/
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Include Twilio Library
    require 'lib/twilio-php/Services/Twilio.php';

    // Bind to action that fires after payment is received
    add_action('woocommerce_payment_complete', 'send_twilio_notification');

    // Send a Twilio SMS notification
    function send_twilio_notification($order_id) {
        global $woocommerce;

        // Needs these config settings
        if (!(defined('TWILIO_ACCOUNT_SID') &&
              defined('TWILIO_AUTH_TOKEN') &&
              defined('TWILIO_FROM_PHONE') &&
              defined('TWILIO_TO_PHONE'))) {

            return false;
        }

        // Lookup the Order
        $order = new WC_Order($order_id);

        $client = new Services_Twilio(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);
        $sms = $client->account->messages->sendMessage(

            // Twilio number you're sending from
            TWILIO_FROM_PHONE,

            // Number to notify (usually admin of site)
            TWILIO_TO_PHONE,

            // Body of message
            "New order on " . get_bloginfo('name') . "! Order #" . $order_id . " for $" . $order->get_total()
        );
    }
}
