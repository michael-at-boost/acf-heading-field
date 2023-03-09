<?php

class acf_field_heading_field extends acf_field {


	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function __construct() {

		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/

		$this->name = 'heading_field';


		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/

		$this->label = __('Heading');


		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/

		$this->category = 'basic';


		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/

		$this->defaults = array();


		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/

		// $this->l10n = array(
		// 	'error'	=> __('Error! Please enter a higher value', 'acf-smart-button'),
		// );

		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

		// do not delete!
    	parent::__construct();

	}


	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field_settings( $field ) {

		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/

		$field = array_merge($this->defaults, $field);


		acf_render_field_setting( $field, array(
      'label'			=> __('Heading Selector Interface'),
			'instructions'	=> 'Show a dropdown or a list of buttons?',
			'name'			=> 'heading-field-select',
			'type'			=> 'radio',
      'layout'        => 'horizontal',
			'choices'       => array(
				'dropdown' => __('Dropdown'),
			  'buttons' => __('Buttons')
			)
		), true);

		acf_render_field_setting( $field, array(
			'label'			=> __('Default Heading Level'),
			'instructions'	=> 'Blank = <p></p>',
			'name'			=> 'heading-default-level',
			'type'			=> 'text',
		
		), true);

		acf_render_field_setting( $field, array(
      'label'			=> __('Return Type'),
			'instructions'	=> 'Return data or markup?',
			'name'			=> 'heading-return-type',
			'type'			=> 'radio',
      'layout'        => 'horizontal',
			'choices'       => array(
			  'data' => __('Data'),
				'markup' => __('Markup')
			)
		), true);


		acf_render_field_setting($field, [
		    'label'        => __('CSS Class'),
		    'instructions' => 'Optional CSS class to apply to heading element',
		    'type'         => 'text',
		    'name'         => 'heading-css-class',
		    // Here's the magic
		    'conditions'   => [
		        'field'    => 'heading-return-type',
		        'operator' => '==',
		        'value'    => 'markup'
		    ]
		]);

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
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/

	function render_field( $field ) {

		$field = array_merge($this->defaults, $field);

		$field_name = esc_attr( $field['name'] );

		/* overwrite fields with empty values to avoid warning */
		$field['value']['text'] = isset($field['value']['text']) ? $field['value']['text'] : null;
		$field['value']['level'] = isset($field['value']['level']) ? $field['value']['level'] : $this->merge_default_level($field, $field["value"]);
		$field['heading-field-select'] = isset($field['heading-field-select']) ? $field['heading-field-select'] : null;

		?>

<div class="acf-heading-field-wrap">
  <div class="acf-heading-field-text">
    <input type="text" value="<?php echo esc_attr( $field['value']['text'] ); ?>"
      name="<?php echo $field_name; ?>[text]" class="text" />
  </div>
  <div class="acf-heading-field-level">
    <?php if ($field['heading-field-select'] !== "dropdown"): ?>

    <div class="acf-heading-field-level__buttons">
      <?php for ($i = 1; $i < 7; $i++) : ?>
      <div class="acf-heading-field-level__button-container">
        <label for="<?php echo $field['key'] ?>-h<?php echo $i ?>">H<?php echo $i ?>
        </label>
        <input type="radio" value="h<?php echo $i ?>" id="<?php echo $field['key'] ?>-h<?php echo $i ?>"
          name="<?php echo $field_name; ?>[level]"
          <?php if ($field['value']['level'] == "h" . $i || (!$field['value']['level'] && $i == 1)) echo "checked" ?> />
      </div>
      <?php endfor; ?>

      <div class="acf-heading-field-level__button-container">
        <label for="<?php echo $field['key'] ?>-p">
          None (P)
        </label>
        <input type="radio" value="p" id="<?php echo $field['key'] ?>-p" name="<?php echo $field_name; ?>[level]"
          <?php if ($field['value']['level'] == "p") echo "checked" ?> />
      </div>
    </div>

    <?php else: ?>

    <div class="acf-heading-field-level__select">
      <select name="<?php echo $field_name; ?>[level]">
        <?php for ($i = 1; $i < 7; $i++) : ?>
        <option value="h<?php echo $i ?>"
          <?php if ($field['value']['level'] == "h" . $i || (!$field['value']['level'] && $i == 2)) echo "selected" ?>>
          H<?php echo $i ?>
        </option>
        <?php endfor; ?>
        <option value="p" <?php if ($field['value']['level'] == "p") echo "selected" ?>>
          None (P)
        </option>
      </select>
    </div>

    <?php endif; ?>
  </div>
</div>

<?php

	}


	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function input_admin_enqueue_scripts() {

		$dir = plugin_dir_url( __FILE__ );

		// register & include JS
		wp_register_script( 'acf-heading-field', "{$dir}js/input.js" );
		wp_enqueue_script('acf-heading-field');


		// register & include CSS
		wp_register_style( 'acf-heading-field', "{$dir}css/input.css" );
		wp_enqueue_style('acf-heading-field');

		// wp_enqueue_script(array(
		// 	'acf-heading-field',
		// ));

	}

	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_head() {



	}

	*/


	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/

   	/*

   	function input_form_data( $args ) {



   	}

   	*/


	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function input_admin_footer() {



	}

	*/


	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_enqueue_scripts() {

	}

	*/


	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*

	function field_group_admin_head() {

	}

	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	

	function load_value( $value, $post_id, $field ) {

		// if a text field is converted to a heading it may already
		// contain a string value
		if (!is_array($value)) {
			$value = [
				"text" => $value
			];
		}
		return $value;

	}

	


	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/

	/*

	function update_value( $value, $post_id, $field ) {

		return $value;

	}

	*/


	function merge_default_level($field, $value) {
		// always return a level so as not to break html
		if( !isset($value['level']) || empty($value['level']) ) {
			// global default
			$default_level = defined("DEFAULT_HEADING") ? DEFAULT_HEADING : "p";
			
			// field default
			if (isset($field["heading-default-level"])) {
				$default_level =  $field["heading-default-level"];
			}
			
			return $default_level;
		}

		return $value['level'];
	}

	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/


	function format_value( $value, $post_id, $field ) {

		// if no text then return blank string (no tags)
		if (!$value['text']) {
			return "";
		}

		// // always return a level so as not to break html
		// if( !isset($value['level']) || empty($value['level']) ) {
		// 	// global default
		// 	$default_level = defined("DEFAULT_HEADING") ? DEFAULT_HEADING : "p";
			
		// 	// field default
		// 	if (isset($field["heading-default-level"])) {
		// 		$default_level =  $field["heading-default-level"];
		// 	}
			
		// 	$value['level'] = $default_level;
		// }
		$value['level'] = $this->merge_default_level($field, $value);

		// option to dump the data out
		if ($field['heading-return-type'] == "data") {
			return $value;
		} 

		// if class is set better insert that too
		$css_class = "";
		if (isset($field['heading-css-class']) && $field['heading-css-class']) {
			$css_class = " class='{$field['heading-css-class']}' ";
		}

		return "<" . $value['level'] . " " . $css_class . ">" .
		$value['text'] .
		"</" . $value['level'] . ">";

	}


	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/

	/*

	function validate_value( $valid, $value, $field, $input ){

		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}


		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','acf-FIELD_NAME'),
		}


		// return
		return $valid;

	}

	*/


	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/

	/*

	function delete_value( $post_id, $key ) {



	}

	*/


	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function load_field( $field ) {

		return $field;

	}

	*/


	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/

	/*

	function update_field( $field ) {

		return $field;

	}

	*/


	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/

	/*

	function delete_field( $field ) {



	}

	*/


}

if ( ! function_exists( 'get_heading' ) ) {
    function get_heading($field, $cls="") {
    	if (!$field) return "";
    	$str = "<{$field['level']}";
    	if ($cls) {
    		$str .= " class='{$cls}'";
    	}
    	$str .= ">";
    	$str .= $field['text'];
    	$str .= "</{$field['level']}>";
    	return $str;
    }
}

// if ( ! function_exists( 'get_subfield_heading' ) ) {
//     function get_subfield_heading($name, $cls="") {
//     	$data = get_sub_field($name);
//     	$str = "<{$data['level']}";
//     	if ($cls) {
//     		$str .= " class='{$cls}'";
//     	}
//     	$str .= ">";
//     	$str .= $data['text'];
//     	$str .= "</{$data['level']}>";
//     	return $str;
//     }
// }

// create field
new acf_field_heading_field();
