<?php
/*
 *
 * Template Name: News Feed Template
 *
 */

get_header();

	$page_title = get_the_title();
	$post_thumbnail_id = get_post_thumbnail_id();
	$featured_img = wp_get_attachment_image_src( $post_thumbnail_id, 'wpbs-featured-home' );

	$featured_img = (object)array( "url" 	=> $featured_img[0]
											 				 , "w"		=> $featured_img[1]
															 , "h"		=> $featured_img[2]
											 );


?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<header class='page-title'>
		<div class='container text-left'>
			<?=get_bloginfo('name')?>
            <div class="breadcrumbs">
				<?php the_breadcrumb(); ?>
            </div><!--breadcrumbs -->
		</div><!-- container -->

	</header>

<div class="container">
	<div class="row main-wrapper">
		<div class="main-content">
			<header><h1><?=$page_title?></h1></header>
			<?php require_once( 'templates/news-feed.php' ); ?>	
		</div>
		<?php get_sidebar(); // sidebar 1 ?>
  	</div>
</div>




<?php endwhile;
	else : echo "Post Not Found"; //Make a 404 function here
	endif;
?>




<?php get_footer(); ?>