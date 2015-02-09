<?php

//get page id and content of page which is the category to display number
$post_id = get_the_id();
$content = get_the_content();
$cat_id  = (int) $content;

switch_to_blog(16);

	$args = array(
			'numberposts' => -1,
			'category'    => $cat_id,
			'post_type'	  => 'story',	
		);

	$feed = get_posts( $args );

	foreach( $feed as $story ) {
		echo '<div class="row news-story">';
			echo '<div class="col-sm-2 col">';
				if ( has_post_thumbnail( $story->ID ) ) {
					echo get_the_post_thumbnail( $story->ID );
				} else echo '<img src="/wp-content/uploads/2014/07/hiDefCampus-150x150.jpg" />';
				
			echo '</div>';
			echo '<div class="col-sm-8">';
				echo '<h4><a href="' . get_the_permalink( $story->ID ) . '">' . $story->post_title . '</a></h4>';
				echo '<p>';
					if( $story->post_excerpt ) {
						echo $story->post_excerpt;
					} else echo strip_tags( substr( $story->post_content, 0, 300 ) );
				echo '<a href="' . get_the_permalink( $story->ID ) . '">(read more...)</a></p>';
				echo '<p style="float: right;">' . mysql2date( 'j M Y', $story->post_date ) . '</p>';
			echo '</div>';
		echo '</div>';
	} //end foreach feed

restore_current_blog();

?>