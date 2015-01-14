<h3>Last Name</h3>
<?php 
	$args = array( 'post_type' => 'bios', 'order' => 'ASC', 'orderby' => 'title', 'meta_value=__cmbi_emp_type_physician' => 'on' );
	$phys_list = get_posts( $args );

	foreach ( $phys_list as $phys ){
		print_r($phys);
	} //end foreach phys list
?>