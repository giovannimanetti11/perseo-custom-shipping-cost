# Perseo Custom Shipping Cost

This is a WooCommerce shipping plugin that calculates shipping costs based on postal codes and weights.

## Description

The Perseo Custom Shipping Cost plugin uses a .csv file to retrieve shipping costs based on the destination postal code and the total weight of the cart. The plugin supports multiple weights and postal codes, allowing for a wide range of shipping cost configurations.

## Installation

1. Download the latest version of the plugin.
2. Go to your WordPress Dashboard and navigate to Plugins > Add New.
3. Click on the 'Upload Plugin' button at the top of the page.
4. Select the downloaded .zip file and click on 'Install Now'.
5. Once installed, click on 'Activate Plugin'.
6. Once activated, go to WooCommerce > Settings > Shipping and in the "Custom Shipping" tab Enable the shipping method.


## CSV File Format

The .csv file used by the plugin should be formatted as follows:

`Paese;Zip/Postal Code From;Zip/Postal Code To;Weight From;Weight To;Prezzo Spedizione;`

Each row represents a different shipping cost configuration, with the following fields:

- **Paese**: The country code (e.g., IT for Italy).
- **Zip/Postal Code From**: The start of the range of applicable postal codes. If this field and the next one are empty, the rule applies to all postal codes in the country.
- **Zip/Postal Code To**: The end of the range of applicable postal codes.
- **Weight From**: The start of the range of applicable weights.
- **Weight To**: The end of the range of applicable weights.
- **Prezzo Spedizione**: The shipping cost for the specified weight and postal code range.

The .csv file should be placed in the same directory as the plugin and named shipping_data.csv.
The .csv file you find in the repository is a sample file. You use it at your own risk.

## License
This project is licensed under the MIT License. For more details, please see the LICENSE file.

## Heads Up!
I've put together this WooCommerce plugin to help you calculate your shipping costs on WooCommerce. I think it's pretty neat, but keep in mind it's not perfect. 
Please use this tool responsibly and understand that I can't be held accountable for any errors or problems you might run into. While I've done my best to make sure it's working properly, I can't make any guarantees. 
Remember, you're using this plugin at your own risk. I'm sharing it to help out, but you're responsible for making sure it fits your needs.

## Author
[Giovanni Manetti](https://github.com/giovannimanetti11)

[LinkedIn](https://www.linkedin.com/in/giovannimanetti/)
