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



	$red = get_terms( 'specialty', array( 'orderby' => 'name' ) );

	echo '<h3>By Specialty</h3>';
	echo '<ul id="specDir" class="col-xs-12">';
	foreach( $red as $r ) {
		echo '<li class="'. $r->slug . '">' . $r->name .'</li>';
	} //end echo each langauge
	echo '</ul>';


	foreach( $red as $r ) {

		$args = array( 
			'post_type' => 'bios', 
			'meta_query' => array(
				'key'		=> '_cmbi_emp_type', 
				'value' 	=> 'physician',
				'compare'	=> 'in'  
				),
			'tax_query'	=> array(
				array(
					'taxonomy'	=> 'specialty',
					'field'		=> 'slug',
					'terms'		=> $r->slug,
					)
				)
			);

		$post_list = get_posts( $args );

		foreach( $post_list as $post ){

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
			$p_loc = $term_meta['city'] . ' ' . $term_meta['state'] . ' ' . $term_meta['zip_code'];

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

			#print out div
			echo '<div class="' . $r->slug . ' col-xs-5 col-sm-3">';
			echo '<a href="' . $perma . '" />' . $name . '</a><br />';
			
			if( $specs )
				echo $specs;

			if( $p_loc_name ) {
				echo '<hr />';
				echo $p_loc_name . '<br />';
				echo $p_loc_add . ' ' . $p_loc_ste . ' ' . $p_loc . '<hr />';
			} else echo '<br />';

			if( $phone ) 
				echo $phone . '<br />';

			echo '</div>';
		
			unset( $post_id, $lname, $fname, $meddeg_arr, $spec_arr, $primary_obj, $phone, $perma, $specs);

		} //end foreach post_list

	} //end foreach red

if( $wp_taxonomies['language'] == 'delete' )
	unset( $wp_taxonomies['language'] );

if( $wp_taxonomies['location'] == 'delete' )
	unset( $wp_taxonomies['location'] );

if( $wp_taxonomies['specialty'] == 'delete' )
	unset( $wp_taxonomies['specialty'] );

restore_current_blog();
?>