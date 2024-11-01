<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly    //(added)

class aafa_acf_field_accordion extends acf_field //changed
{

	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	1/11/2022
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct()
	{

		$this->name = 'accordion';
		$this->label = __('Accordion Type', 'accordion-acf');
		$this->category = 'layout';

		$this->defaults = array(
			'value'			=> false, // prevents acf_render_fields() from attempting to load value
			'icon_class'	=> 'dashicons-arrow-right'
		);

		$location = plugin_dir_url(__FILE__);
		$location = apply_filters("acf/accordion/dir", $location);

		// Settings
		$this->settings = array(
			'icons'		=>	$location . 'icons/icons.json'
		);

		$this->l10n = array();
		parent::__construct();
	}

	/*
	*  aafa_render_field_settings() 
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	1/11/2022
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field_settings($field)
	{

		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/


		$json_file = wp_remote_get($this->settings['icons']);
		$json_file = wp_remote_retrieve_body($json_file);
		$json_content = @json_decode($json_file, true);

		if (!isset($json_content['icons'])) {
			esc_html_e(' ', 'accordion-addon-for-acf'); // (changed)
			return;
		}

		$icons = array();

		foreach ($json_content['icons'] as $icon) {
			$icons[$icon['icon']['class']] = $icon['icon']['name'];
		}

		acf_render_field_setting($field, array(
			'label'			=> __('Icon', 'acf-accordion'),
			'type'			=> 'select',
			'id'			=> $field['ID'] . 'accordion-select',
			'name'			=> 'icon_class',
			'choices'		=> $icons,
		));

?>
		<script>
			(function($) {
				var ID = '<?php printf(
															esc_html_e('%s.', 'accordion-addon-for-acf'),
															esc_html($field['ID'])
														);
														?>'; //(changed)

				jQuery("#" + ID + "accordion-select").select2({
					aafaformatResult: aafaformat, //changed 
					aafaformatSelection: aafaformat, //changed 
				});

				function aafaformat(o) { //changed name
					if (!o.id) {
						return o.text; // optgroup
					} else {
						return "<i class='accordion dashicons " + o.id + "' style='margin-right: 5px;'></i>" + o.text;
					}
				}
			})(jQuery);
		</script>
<?php
	}


	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	1/11/2022
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/



	/*
	*  aafa_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	1/11/2022
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function input_admin_enqueue_scripts() //changed
	{

		$location = plugin_dir_url(__FILE__);
		$location = apply_filters("acf/accordion/dir", $location);

		// Register & include CSS
		wp_register_style('acf-input-accordion', "{$location}css/input.css");
		wp_enqueue_style('acf-input-accordion');
	}
}

// create field

new aafa_acf_field_accordion(); //changed
?>