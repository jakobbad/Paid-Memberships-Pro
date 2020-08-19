<?php
/**
 * This is a simple example that references a select drop down and when a certain option is selected will it show.
 * Add this code to your PMPro Customizations and tweak to your liking.
 */
 
function my_pmprorh_init() {
	//don't break if Register Helper is not loaded
	if(!function_exists( 'pmprorh_add_registration_field' )) {
		return false;
	}
	
	//define the fields
	$fields = array();
	$fields[] = new PMProRH_Field(
		'depends_1',
		'select',
		array(
			'label' => 'Do you have a valid first aid certificate?',
			'profile' => true,
			'options' => array(
				' ' => 'Please Select',
				'no' => 'No',
				'yes_wo' => 'Yes (without CPR/AED)',
				'yes_w' => 'Yes (with CPR/AED)',
			)
		)
	);

	$fields[] = new PMProRH_Field(
		'depends_2',
		'text',
		array(
			'label' => 'Please enter expiry date',
			'profile' => true,
			'required' => false,
		)
	);

	
	//add the fields into a new checkout_boxes are of the checkout page
	foreach($fields as $field)
		pmprorh_add_registration_field(
			'after_email',				// location on checkout page
			$field						// PMProRH_Field object
		);
	//that's it. see the PMPro Register Helper readme for more information and examples.
}
add_action( 'init', 'my_pmprorh_init' );


function add_to_footer_example() {
	global $pmpro_pages;

	// Only load script on checkout page.
	if ( is_page( $pmpro_pages['checkout'] ) ) {
	?>
	<script type="text/javascript">
			
			jQuery(document).ready(function(){

				// Hide fields by default that may depend on something.
				jQuery('#depends_2_div').hide();

				// Show fields.
				jQuery('#depends_1').change(function(){
					var val = jQuery('#depends_1').val();

					switch( val ) {
						case 'yes_wo':
							jQuery('#depends_2_div').show();
							jQuery('#depends_2').prop('required', true).after(' *');; // make the input field required and add * after it.
							break;
						case 'yes_w':
							jQuery('#depends_2_div').show();
							jQuery('#depends_2').prop('required', true).after(' *');; // make the input field required and add * after it.
							break;
						case 'no':
							jQuery('#depends_2_div').hide();
							jQuery('#depends_2').prop('required', false);
							break;
					}
				});
			});

	</script>
	<?php
	}
}
add_action( 'wp_footer', 'add_to_footer_example' );
