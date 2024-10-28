<?php
/*
 * Plugin Name: Accordion Addon for ACF
 * Plugin URI:  https://wordpress.org/plugins/accordion-addon-for-acf/
 * Description: The Accordian Type field is used to group together fields into Accordian sections.
 * Version:     1.2
 * Author:      Galaxy Weblinks
 * Author URI:  http://www.galaxyweblinks.com
 * Text Domain: accordion-addon-for-acf
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit; // disable direct access
}

/**
 * Add backend option for Accordion Addon in field type "Accordion Addon" in ACF.
 * @param array $field
 * @return void
 */
class aafa_accordion_addon_plugin
{

    // Construct
    function __construct()
    {
        load_plugin_textdomain('accordion-addon-for-acf', false, dirname(plugin_basename(__FILE__)) . '/lang/');
        add_action('acf/include_field_types', array($this, 'include_field_types_accordion'));
        add_action('acf/register_fields', array($this, 'register_fields_accordion'));
    }

    function include_field_types_accordion($version)
    {
        include_once('accordion-addon-for-acf-include.php');
    }
}

new aafa_accordion_addon_plugin();
