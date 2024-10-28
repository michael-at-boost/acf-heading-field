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
			'label'			=> __('Default Heading Level'),
			'instructions'	=> 'Blank = &lt;p>',
			'name'			=> 'heading-default-level',
			'type'			=> 'text',

		), true);
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


    <div class="acf-heading-field-level__select">
      <select name="<?php echo $field_name; ?>[level]">
        <?php for ($i = 1; $i < 7; $i++) : ?>
        <option value="h<?php echo $i ?>" <?php if ($field['value']['level'] == "h" . $i) echo "selected" ?>>
          H<?php echo $i ?>
        </option>
        <?php endfor; ?>
        <option value="p" <?php if ($field['value']['level'] == "p" || (!$field['value']['level'])) echo "selected" ?>>
          P
        </option>
      </select>
    </div>

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

		$value['level'] = $this->merge_default_level($field, $value);

    return $value;




	}



}

if ( ! function_exists( 'get_heading' ) ) {
    function get_heading($field, $attrs="", $post_id = false) {
    	if (!$field) return "";

      // if field is a string then fetch the field
      if (is_string($field)) {
        $field = get_field($field, $post_id);
      }

      // if attrs is a string then convert to array with class
      if ($attrs && is_string($attrs)) {
        $attrs = ["class" => $attrs];
      }

    	$str = "<{$field['level']}";

      // add attributes as string
      if ($attrs) {
        foreach ($attrs as $key => $value) {
          $value = esc_attr($value);
          $str .= " {$key}='{$value}'";
        }
      }

    	$str .= ">";
    	$str .= $field['text'];
    	$str .= "</{$field['level']}>";
    	return $str;
    }
}

if ( ! function_exists( 'get_sub_heading' ) ) {
    function get_sub_heading($fieldname, $attrs="", $post_id = false) {
    	$data = get_sub_field($fieldname, $post_id);
    	return get_heading($data, $attrs);
    }
}

// create field
new acf_field_heading_field();
