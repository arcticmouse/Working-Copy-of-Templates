<?php
#switch to blog to get bios
switch_to_blog(1);

#get_terms in switch to blog doesnt work, lines 6-8 & 114-115 make and delete a fake taxonomy in current blog
#http://wordpress.stackexchange.com/questions/98247/get-post-by-term-from-custom-taxonomy-in-another-blog-on-the-network
global $wp_taxonomies;
if( !taxonomy_exists( 'location' ) )
	$wp_taxonomies['location'] = 'delete';

global $wp_taxonomies;
if( !taxonomy_exists( 'specialty' ) )
	$wp_taxonomies['specialty'] = 'delete';


	$args = array( 
		'post_type' => 'bios', 
		'order' => 'ASC', 
		'orderby' => 'title', 
		'tax_query'	=> array(
	    	array(
		    	'taxonomy' => 'emp_type',
		    	'field' =>	'slug',
		    	'terms' => 'physician',
		    	),
			), //end tax wquery
		);
	$query = new WP_Query( $args );

	$count = 0;
	$letter = '';

	if ( $query->have_posts() ) {

		echo '<h3>By Last Name</h3>';

		while ( $query->have_posts() ) : $query->the_post(); 
		var_dump($post);
		echo '<hr>';
		#get the data for name
		$post_id = $post->ID;
		$lname = $post->post_title;
		$fname = get_post_meta( $post_id, '_cmbi_fname', true );
		$meddeg_arr = wp_get_post_terms( $post_id, 'med_degree', array( "fields" => "names" ) );

		#create the name
		$name = $fname . ' ' . $lname;

		if ( count( $meddeg_arr ) > 0 ) {
			foreach ( $meddeg_arr as $deg ) {
				$name .= ', ' . $deg; 
			}
		} 

		#fill letter array
		if ( substr( $lname, 0, 1 ) != $letter ) {
			$letter = substr( $lname, 0, 1 );
			$letters[] = $letter;
		} //end if

		#get data for specialties list
		$spec_arr = wp_get_post_terms( $post_id, 'specialty', array( "fields" => "names" ) );

		#get data for primary location
		$primary_obj = get_term( get_post_meta( $post_id, '_cmbi_primary', true ), 'location');
		$p_loc_name = $primary_obj->name;

		$t_id = 'taxonomy_' . $primary_obj->term_id;
		$term_meta = get_option( $t_id );
		$p_loc_add = $term_meta['street_address'];
		$p_loc_ste = $term_meta['suite_number'];
		$p_loc = $term_meta['city'] . ' ' . $term_meta['state'] . ' ' . $term_meta['zip_code'] . '<br />';

		#get phone number
		$phone = get_post_meta( $post_id, '_cmbi_fphone', true );

		#get permalink
		$perma = get_permalink( $post_id );

		#get specialties
		if( count( $spec_arr ) > 0 ){
			if ( count( $spec_arr ) > 1 ) {
				foreach ( $spec_arr as $s ) {
					$specs .= $s . ' <br />'; 
				}
			} else $specs .= $spec_arr[0];
		}


		#make the string to print
		$phys[$count] = '<div class="' . $letter . ' col-sm-3 col-xs-5"><a href="'. $perma . '" />' . $name . '</a><br />';

		if( $specs ){
			$phys[$count] .= $specs;
		} 

		if( $p_loc_name ) {
			$phys[$count] .= '<hr />';
 			$phys[$count] .= $p_loc_name . '<br />';
			$phys[$count] .= $p_loc_add;
			$phys[$count] .= $p_loc . '<hr />';
		} else $phys[$count] .= '<br />';

		if( $phone ) {
			$phys[$count] .= $phone . '<br />';
		}

		$phys[$count] .= '</div>';

		$count++;

		unset( $post_id, $lname, $fname, $meddeg_arr, $spec_arr, $primary_obj, $phone, $perma, $specs);
		endwhile; //end while posts
	} //end if posts

if( $wp_taxonomies['location'] == 'delete' )
	unset( $wp_taxonomies['location'] );

if( $wp_taxonomies['specialty'] == 'delete' )
	unset( $wp_taxonomies['specialty'] );

restore_current_blog();
	$p_name = Timber::get_context();
	$p_name['letters'] = $letters;
	$p_name['phys'] = $phys;
	Timber::render( 'physician-name-filter.twig', $p_name); 

?>