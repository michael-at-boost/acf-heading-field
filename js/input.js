(function($){

	function initialize_field( $el ) {
		var container = $el.find(".acf-heading-field-level__buttons")
		if (container.length) {
			container.addClass("acf-heading-field-level__buttons--active")
			// convert labels to buttons
			container.find(".acf-heading-field-level__button-container").each(function() {
				convertRadioToButton(this)
			})
	
			// attach click handlers to sync button state
			container.find("input[type=radio]").each(function() {
				$(this).change(function() {
					console.log( "change hit" );
					highlightLabel(container)
				})
			})
			container.find("label").each(function() {
				$(this).click(function() {
					console.log( "lbl", $(this) );
					$(this).siblings("input[type=radio]").click()
				})
			})
		}
		// return
		// define vars
		// var $checkbox = $el.find('.button-link-switch-checkbox'),
		// 	$internal = $el.find('.internal'),
		// 	$external = $el.find('.external'),
		// 	$switcherInput = $el.find('.switcher input'),
		// 	$switcherLabel = $el.find('.switcher label');

		// // listen to checkbox change
		// $checkbox.change(function() {
	 //        helperCheckboxChange(this, $internal, $external);
	 //    });

		// // trigger change function on init to respect current state (do not trigger change event as this provokes browser alert on window close)
		// helperCheckboxChange($checkbox, $internal, $external);

		// // sync id and for, for the label to work
		// $switcherLabel.attr('for', $switcherInput.attr('id'));

	}

	function convertRadioToButton(buttonContainer) {
		var label = $(buttonContainer).find("label")
		var radio = $(buttonContainer).find("input[type=radio]")
		if (radio.is(":checked")) {
			$(label).addClass("acf-heading-field-level--checked")
		}
		radio.hide()
	}

	// returns a function to highlight the correct label for a checked radio button
	function highlightLabel(container) {
		// clear previous
		container.find(".acf-heading-field-level--checked").removeClass("acf-heading-field-level--checked")
		// add highlight to current selection
		container.find(":checked").siblings("label").addClass("acf-heading-field-level--checked")
	}

	// function helperCheckboxChange(_self, $internal, $external) {
	// 	if($(_self).is(":checked")) {
 //            $internal.hide();
 //            $external.show();
 //            $external.find('input').show();
 //        } else {
 //        	$internal.show();
 //        	$external.hide();
 //        }
	// }

	if( typeof acf.add_action !== 'undefined' ) {

		/*
		*  ready append (ACF5)
		*
		*  These are 2 events which are fired during the page load
		*  ready = on page load similar to $(document).ready()
		*  append = on new DOM elements appended via repeater field
		*
		*  @type	event
		*  @date	20/07/13
		*
		*  @param	$el (jQuery selection) the jQuery element which contains the ACF fields
		*  @return	n/a
		*/

		acf.add_action('ready append', function( $el ){

			// search $el for fields of type 'button'
			acf.get_fields({ type : 'heading_field'}, $el).each(function(){

				initialize_field( $(this) );

			});

		});


	} else {


		/*
		*  acf/setup_fields (ACF4)
		*
		*  This event is triggered when ACF adds any new elements to the DOM.
		*
		*  @type	function
		*  @since	1.0.0
		*  @date	01/01/12
		*
		*  @param	event		e: an event object. This can be ignored
		*  @param	Element		postbox: An element which contains the new HTML
		*
		*  @return	n/a
		*/

		$(document).on('acf/setup_fields', function(e, postbox){

			$(postbox).find('.field[data-field_type="heading_field"]').each(function(){

				initialize_field( $(this) );

			});

		});


	}


})(jQuery);
