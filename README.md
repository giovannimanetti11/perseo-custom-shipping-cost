# Perseo Custom Shipping Cost
This is a WooCommerce shipping plugin that calculates shipping costs based on postal codes and weights.

## Description
The Perseo Custom Shipping Cost plugin uses a .csv file to retrieve shipping costs based on the destination postal code and the total weight of the cart. The plugin supports multiple weights and postal codes, allowing for a wide range of shipping cost configurations.

## How to install
Download the latest version of the plugin.
Go to your WordPress Dashboard and navigate to Plugins > Add New.
Click on the 'Upload Plugin' button at the top of the page.
Select the downloaded .zip file and click on 'Install Now'.
Once installed, click on 'Activate Plugin'.

## CSV File Format
The .csv file used by the plugin should be formatted as follows:

`Paese;Zip/Postal Code From;Zip/Postal Code To;Weight From;Weight To;Prezzo Spedizione;`

Each row represents a different shipping cost configuration, with the following fields:

**Paese**: The country code (e.g., IT for Italy).
**Zip/Postal Code From**: The start of the range of applicable postal codes. If this field and the next one are empty, the rule applies to all postal codes in the country.
**Zip/Postal Code To**: The end of the range of applicable postal codes.
**Weight From**: The start of the range of applicable weights.
**Weight To**: The end of the range of applicable weights.
**Prezzo Spedizione**: The shipping cost for the specified weight and postal code range.

The .csv file should be placed in the same directory as the plugin and named shipping_data.csv.

## License
This project is licensed under the MIT License. For more details, please see the LICENSE file.

## Author
Giovanni Manetti