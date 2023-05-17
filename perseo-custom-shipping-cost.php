<?php
/*
Plugin Name: Perseo Custom Shipping Cost
Plugin URI: https://dev.perseodesign.com
Description: A WooCommerce shipping plugin that calculates shipping costs based on postal codes and weights.
Version: 0.1
Author: Giovanni Manetti
Author URI: https://github.com/giovannimanetti11
*/

if (!defined('ABSPATH')) {
    exit;
}

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    function perseo_shipping_method_init() {
        if (!class_exists('WC_Perseo_Shipping_Method')) {
            class WC_Perseo_Shipping_Method extends WC_Shipping_Method {
                public function __construct() {
                    $this->id                 = 'perseo_shipping';
                    $this->method_title       = __('Custom shipping', 'perseo-custom-shipping-cost');
                    $this->method_description = __('Shipping method adjusted by postal code and weight', 'perseo-custom-shipping-cost');
                    $this->enabled            = $this->get_option('enabled', 'no');
                    $this->title              = "Custom shipping";
                
                    $this->init();
                }
                
                function init() {
                    $this->init_form_fields();
                    $this->init_settings();
                    add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
                }
                
                function init_form_fields() {
                    $this->form_fields = array(
                        'enabled' => array(
                            'title' => __('Enable/Disable', 'woocommerce'),
                            'type' => 'checkbox',
                            'label' => __('Enable this shipping method', 'woocommerce'),
                            'default' => 'no'
                        ),
                        
                    );
                }

                function calculate_shipping($package = array()) {

                    if ($this->enabled == 'no') {
                        return;
                    }

                    
                    $weight = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];
                    $postcode = $package["destination"]["postcode"];

                    foreach ($package['contents'] as $item_id => $values) {
                        $_product = $values['data'];
                        $weight = $weight + $_product->get_weight() * $values['quantity'];
                    }

                    $cost = $this->get_shipping_cost($country, $postcode, $weight);

                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost,
                        'calc_tax' => 'per_item'
                    );

                    $this->add_rate($rate);
                }

                function get_shipping_cost($country, $postcode, $weight) {
                    $csvFile = plugin_dir_path(__FILE__) . 'shipping_data.csv';
                    $file = fopen($csvFile, 'r');
                    $headers = fgetcsv($file, 0, ';');
                
                    $data = [];
                    while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
                        $data[] = array_combine($headers, $row);
                    }
                    fclose($file);
                
                    // Set the default shipping cost
                    $shipping_cost = 20.00;
                
                    // Debug: Log the input values
                    error_log("Input values - Country: $country, Postcode: $postcode, Weight: $weight");

                    foreach ($data as $row) {
                        error_log(print_r($row, true));
                        if ($country == $row["Paese"] && $postcode >= $row["Zip/Postal Code From"] && $postcode <= $row["Zip/Postal Code To"] && $weight >= $row["Weight From"] && $weight <= $row["Weight To"]) {
                            $cost = $row["Prezzo Spedizione"];
                            break;
                        }
                    }
                    
                
                    // First, check for matching postcode and weight
                    foreach ($data as $shipping_cost_row) {
                        if ($shipping_cost_row['Paese'] === $country &&
                            $shipping_cost_row['Zip/Postal Code From'] <= $postcode &&
                            $shipping_cost_row['Zip/Postal Code To'] >= $postcode &&
                            floatval(str_replace(",", ".", $shipping_cost_row['Weight From'])) <= $weight &&
                            floatval(str_replace(",", ".", $shipping_cost_row['Weight To'])) >= $weight) {
                            // Debug: Log the matched row
                            error_log("Matched row with postcode and weight: " . print_r($shipping_cost_row, true));
                            return floatval(str_replace(",", ".", $shipping_cost_row['Prezzo Spedizione']));
                        }
                    }
                
                    // Next, check for matching weight without postcode
                    foreach ($data as $shipping_cost_row) {
                        if ($shipping_cost_row['Paese'] === $country &&
                            empty($shipping_cost_row['Zip/Postal Code From']) &&
                            empty($shipping_cost_row['Zip/Postal Code To']) &&
                            floatval(str_replace(",", ".", $shipping_cost_row['Weight From'])) <= $weight &&
                            floatval(str_replace(",", ".", $shipping_cost_row['Weight To'])) >= $weight) {
                            // Debug: Log the matched row
                            error_log("Matched row with weight (no postcode): " . print_r($shipping_cost_row, true));
                            return floatval(str_replace(",", ".", $shipping_cost_row['Prezzo Spedizione']));
                        }
                    }
                
                    // Debug: Log if no match is found
                    error_log("No match found, returning default shipping cost");
                
                    // Finally, return the default shipping cost if no match is found
                    return $shipping_cost;
                }
                
                

                                                        
            }
        }
    }

    add_action('woocommerce_shipping_init', 'perseo_shipping_method_init');

    function add_perseo_shipping_method($methods) {
        $methods[] = 'WC_Perseo_Shipping_Method';
        return $methods;
    }

    add_filter('woocommerce_shipping_methods', 'add_perseo_shipping_method');
}
