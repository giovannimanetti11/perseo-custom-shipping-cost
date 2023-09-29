<?php
/*
Plugin Name: Perseo Custom Shipping Cost
Plugin URI: https://github.com/giovannimanetti11/perseo-custom-shipping-cost
Description: A WooCommerce shipping plugin that calculates shipping costs based on postal codes and weights.
<<<<<<< HEAD
Version: 0.1
=======
Version: 0.1.2
>>>>>>> 75732fc (Code slimming and duplicate removal)
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
<<<<<<< HEAD
=======
                // Property definitions to avoid PHP deprecated errors.
                public $plugin_file;
                public $payment_methods_store;
                public $cache_time;
                public $error_cache_time;
                public $tracks;
                public $label_reports;

>>>>>>> 75732fc (Code slimming and duplicate removal)
                public function __construct() {
                    $this->id                 = 'perseo_shipping';
                    $this->method_title       = __('Custom shipping', 'perseo-custom-shipping-cost');
                    $this->method_description = __('Shipping method adjusted by postal code and weight', 'perseo-custom-shipping-cost');
                    $this->enabled            = $this->get_option('enabled', 'no');
<<<<<<< HEAD
                    $this->title              = "Custom shipping";
=======
                    $this->title              = "Corriere Espresso";
>>>>>>> 75732fc (Code slimming and duplicate removal)
                
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
<<<<<<< HEAD
                        
=======
>>>>>>> 75732fc (Code slimming and duplicate removal)
                    );
                }

                function calculate_shipping($package = array()) {
<<<<<<< HEAD

                    if ($this->enabled == 'no') {
                        return;
                    }

                    
=======
                    if ($this->enabled == 'no') {
                        return;
                    }
                
>>>>>>> 75732fc (Code slimming and duplicate removal)
                    $weight = 0;
                    $cost = 0;
                    $country = $package["destination"]["country"];
                    $postcode = $package["destination"]["postcode"];
<<<<<<< HEAD

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
=======
                
                    foreach ($package['contents'] as $item_id => $values) {
                        $_product = $values['data'];
                
                        $product_weight = $_product->get_weight();
                        if (is_null($product_weight) || !is_numeric($product_weight)) {
                            $product_weight = 0;
                        }
                
                        $weight += $product_weight * $values['quantity'];
                    }
                
                    $cost = $this->get_shipping_cost($country, $postcode, $weight);
                
                    $rate = array(
                        'id' => $this->id,
                        'label' => $this->title,
                        'cost' => $cost
                    );                    
                
                    $this->add_rate($rate);
                }
                
>>>>>>> 75732fc (Code slimming and duplicate removal)

                function get_shipping_cost($country, $postcode, $weight) {
                    $csvFile = plugin_dir_path(__FILE__) . 'shipping_data.csv';
                    $file = fopen($csvFile, 'r');
                    $headers = fgetcsv($file, 0, ';');
                
                    $data = [];
                    while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
<<<<<<< HEAD
                        $data[] = array_combine($headers, $row);
                    }
                    fclose($file);
                
                    // Set the default shipping cost
                    $shipping_cost = 20.00;
                

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

                            return floatval(str_replace(",", ".", $shipping_cost_row['Prezzo Spedizione']));
                        }
                    }
                
                
                    // Finally, return the default shipping cost if no match is found
                    return $shipping_cost;
=======
                        if (count($row) == count($headers)) {  // Controllo aggiunto
                            $data[] = array_combine($headers, $row);
                        }
                    }
                    fclose($file);

                    // Default shipping cost
                    $cost = 20.00;

                    foreach ($data as $row) {
                        if ($country === $row["Paese"] && 
                            floatval(str_replace(",", ".", $row["Weight From"])) <= $weight && 
                            floatval(str_replace(",", ".", $row["Weight To"])) >= $weight) {
                            if (empty($row["Zip/Postal Code From"]) || 
                                ($postcode >= $row["Zip/Postal Code From"] && $postcode <= $row["Zip/Postal Code To"])) {
                                $cost = floatval(str_replace(",", ".", $row["Prezzo Spedizione"]));
                                break;
                            }
                        }
                    }

                    return $cost;
>>>>>>> 75732fc (Code slimming and duplicate removal)
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
