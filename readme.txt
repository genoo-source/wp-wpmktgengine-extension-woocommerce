=== WooCommerce - WPMktgEngine | Genoo Extension ===
Contributors: Genoo, latorante
Tags: marketing automation, email marketing, lead capture forms
Requires at least: 3.3
Tested up to: 6.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: 1.7.47
Understand how your leads and customers are participating with your ecommerce.

== Description ==

Understand how your leads and customers are participating with your ecommerce system using the WooCommerce - WPMktgEngine extension. It extends the ActivityStream for your lead & customer database within your WPMktgEngine account, so you can see which leads are buying, and ties the order to the lead record. Having a full view of lead & customer activity allows you to incorporate that knowledge into smart rules and actions that ensure people are getting relevant messages, and you are building deeper relationships and trust with your leads and customers.

= Requirements =

1. Wordpress at least version 3.3
2. PHP at least version 5.3.1
3. Active WPMktgEngine account (http://wpmktgengine.com)

== Installation ==

= Automatic =
1. Go to your admin area and select Plugins -> Add new from the menu.
2. Search for “WooCommerce - WPMktgEngine Extension”.
3. Click install.
4. Click activate.
5. Enjoy.

= Manual =
1. Go to [http://wordpress.org/plugins/wpmktgengine-extension-woocommerce/](http://wordpress.org/plugins/wpmktgengine-extension-woocommerce/ “WooCommerce - WPMktgEngine Extension”)
2. Download latest version of the plugin.
3. Unzip file into WordPress plugins directory.
4. Activate plugin.
5. Enjoy.

== Screenshots ==

== Frequently Asked Questions ==

== Upgrade Notice ==

== Changelog ==

== 1.7.47 ==
Fixed the jquery conflict issue while Failed orders data table display.

== 1.7.46 ==
Stored cron default setup values in database table.

== 1.7.45 ==
Fixed the issue of subscription on-hold duplicating while inserting into the order queue table.

== 1.7.44 ==
Fixed the issue of subscription renewal order duplicating while inserting into the order queue table.

== 1.7.43 ==
Fixed issue payload not generated while changing the order status completed into processing in the order.

== 1.7.42 == 
Fixed Update database button jquery issue.

= 1.7.41 = 
Added Order Queue if order fails to find Genoo API (i.e. if it's down) and will retry the push to Genoo account on regular increment.  Cron job is set to run every 5 mniutes by default, and can be edited at Settings > eCommerce tab in Genoo plugin.  Also added ability to push individual orders across if they have not yet synced with Genoo account.  Go to Edit order and send to genoo button should be available.

= 1.7.0 =
* Enhanced support for subscriptions - new activity stream items - subsccription started, subscription ended, subscription payment (for payments after the first payment), as well as subscription pending hold and subscription on hold.

= 1.6.0 =
* Fix Woo Division by zero bug

= 1.5.6 =
* WooFunnels Upsell Plugin bridge

= 1.5.5 =
* Optim for WP5

= 1.5.4 =
* Completed order - if doesn't exist - make one

= 1.5.2 =
* Compatibility hooks with Amazon Pay

= 1.5.1 =
* Declined order update

= 1.4.9 =
* API protection for patching null line_items

= 1.4.8 =
* Compatibility with Affiliate extension

= 1.4.5=
* Logger bugfix of var_export function

= 1.4.1 =
* Extensive logging added for debugging purposes

= 1.4.0 =
* Lead compatibility, better logging

= 1.3.8 =
* Better Name and Surname handling when creating new orders

= 1.3.3 =
* Updated compatibility with the latest plugin

= 1.2.6 =
* Updating order records
