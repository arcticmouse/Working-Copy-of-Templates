<?php get_header(); ?>

			<div id="content" class="clearfix row-fluid">
				<div id="main" class="span8 clearfix" role="main">
					<div class="page-header search-header"><div class="container"><h1 class="">Search Results</h1> <p>HOME &raquo; SEARCH RESULTS</p></div></div>

						<header>
						</header> <!-- end article header -->

						<div class="container">
							<div class="row search-results-main">
								<div class="col-md-2">
									<ul>
										<li><a href="">Directory</a></li>
										<li><a href="">Maps</a></li>
										<li><a href="">Useful Links</a></li>
									</ul>
								</div>
								<div class="col-md-10">

									<?php 
								    if ( !isset( $_GET['post_type'] ) ) {
								    	?>

										<h3>Search UNT Health Sciences</h3>

										<form class="search-results-form" role="search" method="get" id="searchform" action="/">
									    <div class="form-group row">
									      <div class="col-sm-10">
									        <input type="text" value="" name="s" id="s" placeholder="<?= get_search_query(); ?>">
									      </div>
									      <div class="col-sm-2">
									        <button type="submit" class="btn btn-block btn-primary">Search</button>
									      </div>
									    </div>
									    </form>

										<!-- begin Google search results -->
										<gcse:searchresults-only queryParameterName="s"></gcse:searchresults-only>
										<!-- end Google search results -->
										<?php
									} else {
										if ( !isset( $_GET['emp_type_physician'] ) ) {
										/****************************************************/
										/*	this is  the employee directory search code
										/****************************************************/
											?><h3>UNT Health Sciences Biographies Search Results</h3><br /><br /><?php
											#get data from form
											$fname = $_GET['fname'];
											$lname = $_GET['s'];
											$type_arr = $_GET['emp_type'];
											$dept = $_GET['department'];

											#set search variables if thats what the user is looking for 
											#special case for post title, which isnt post_meta
											#put a filter on lname and fname, which are user strings
											if( $fname ){
												$fn = sanitize_text_field( $fname );
												$fname_arr = array(
											            'key' => '_cmbi_fname',
											            'value' => $fn,
											            'compare' => 'LIKE'
											        	);
											}
											if ( $lname ){
												$ln = sanitize_text_field( $lname );
												$title_query = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE UCASE(post_title) LIKE '$ln%' OR UCASE(post_title) LIKE '%$ln%'" );
											}
											if ( $dept ){
												$dept_arr = array(
											            'key' => '_cmbi_department',
											            'value' => $dept,
											            'compare' => 'LIKE'
											        );
											}
											if ( $type_arr ){
												$emp_arr = array(
														'taxonomy' => 'emp_type',
														'field' => 'slug',
														'terms' => $type_arr,
													);
											}

											#set args to query for
											$args = array(
											    'meta_query' => array(
											        'relation' => 'OR',
											        $fname_arr,
											        $dept_arr,
											    ), //end meta query
											    'tax_query' => array(
											    	$emp_arr,
											    ), //end taxonomy query
											    'post_type' => 'bios',
											    'post__in' => $title_query,
											); //end args

											#query for args
											$query = new WP_Query( $args );

											#if there are results loop through them and set variables to print
								       		if ( $query->have_posts() ){
												$k = 0;
												while( $query->have_posts() ) : $query->the_post();
													$post_id = get_the_ID();
													$results[$k]['thumb']	   = get_the_post_thumbnail();
													$results[$k]['url']		   = get_the_permalink( $post_id );
													$results[$k]['lname']	   = get_the_title();
													$results[$k]['fname']      = get_post_meta( $post_id, '_cmbi_fname', true );
													$results[$k]['titles']     = get_post_meta( $post_id, '_cmbi_titles', true);
													$results[$k]['phone']      = get_post_meta( $post_id, '_cmbi_fphone', true);
													$results[$k]['fax']        = get_post_meta( $post_id, '_cmbi_fax', true);
													$results[$k]['department'] = get_post_meta( $post_id, '_cmbi_department', true);
													$results[$k]['email']      = get_post_meta( $post_id, '_cmbi_email', true);
													$k++;
												endwhile;
											} 

											#send everything to the lil twig to print out
									        $context = Timber::get_context();
											$context['results'] = $results;
									        Timber::render('bios-search-results.twig', $context);

									        #reset the query
									        wp_reset_query();

										} else {
											/****************************************************/
											/*	this is  the physician directory search code
											/****************************************************/
											?><h3>UNT Health Sciences Physician Search Results</h3><br /><br /><?php
											#get data from form
											$fname = $_GET['fname'];
											$lname = $_GET['s'];
											$specialty = $_GET['specialty'];
											$language = $_GET['language'];

											#set search variables if thats what the user is looking for 
											#special case for post title, which isnt post_meta
											#put a filter on lname and fname, which are user strings
											if( $fname ){
												$fn = sanitize_text_field( $fname );
												$fname_arr = array(
											            'key' => '_cmbi_fname',
											            'value' => $fn,
											            'compare' => 'LIKE'
											        	);
											}
											if ( $lname ){
												$ln = sanitize_text_field( $lname );
												$title_query = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE UCASE(post_title) LIKE '$ln%' OR UCASE(post_title) LIKE '%$ln%'" );
											}
											if ( $specialty ){
												$spec_arr = array(
											            'key' => '_cmbi_specialty',
											            'value' => $specialty,
											            'compare' => 'LIKE'
											        );
											}
											if ( $language ){
												$lang_arr = array(
											            'key' => '_cmbi_language',
											            'value' => $language,
											            'compare' => 'LIKE'
											        );
											}
											


											#set args to query for
											$args = array(
											    'post_type' => 'bios',
											    'post__in' => $title_query,
											    'meta_query' => array(
											    	'relation' => 'OR',
												       $fname_arr,
												       $spec_arr,
												       $lang_arr,
											    ), //end meta query
											    'tax_query' => array(
											    	array(
											    	'taxonomy' => 'emp_type',
											    	'field' =>	'slug',
											    	'terms' => 'physician',
											    	),
											    ), //end taxonomy query
											); //end args

											#query for args
											$query = new WP_Query( $args );

											#if there are results loop through them and set variables to print
								       		if ( $query->have_posts() ){
												$k = 0;
												while( $query->have_posts() ) : $query->the_post();
													$post_id = get_the_ID();

													$p_deg_list = wp_get_post_terms( $post_id, 'med_degree', array( 'fields' => 'names' ) );
													$p_loc_list = wp_get_post_terms( $post_id, 'location', array( 'fields' => 'names' ) );

													$results[$k]['thumb']	   = get_the_post_thumbnail();
													$results[$k]['url']		   = get_the_permalink( $post_id );
													$results[$k]['lname']	   = get_the_title();
													$results[$k]['fname']      = get_post_meta( $post_id, '_cmbi_fname', true );
													$results[$k]['med_deg']    = $p_deg_list;
													$results[$k]['phone']      = get_post_meta( $post_id, '_cmbi_fphone', true);
													$results[$k]['locations']  = $p_loc_list;
													$k++;
												endwhile;
											} 

											#send everything to the lil twig to print out
									        $context = Timber::get_context();
											$context['results'] = $results;
									        Timber::render('physician-search-results.twig', $context);

									        #reset the query
									        wp_reset_query();

										} //end if else is a bios of physician search
										
									} // if else get post type bios
									?>

								</div>
							</div>
						</div><!-- end container -->

						<footer>
						</footer> <!-- end article footer -->

				</div> <!-- end #main -->

			</div> <!-- end #content -->

<?php get_footer(); ?>