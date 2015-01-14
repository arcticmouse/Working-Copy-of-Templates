<?php get_header();


/**
 * Getting all the page data $vars to use throughout the template
 */

	$page_title = get_the_title();

?>
<style>
.post_content .panel {
    border-bottom: 0.5px solid;
}
.post_content .panel a {
	color: #333333;
}
.post_content .panel .triangle {
    border-bottom: 5px solid transparent;
    border-left: 6px solid #c0392b;
    border-top: 5px solid transparent;
    float: left;
    margin-top: 0.35em;
    width: 15px;
}
.post_content .panel p {
	margin: 0;
}
</style>

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

		<?php require_once( 'templates/single-faq-template.php' ); ?>	
			
    </div>
		<?php get_sidebar(); // sidebar 1 ?>
  	</div>
</div>




<?php endwhile;
	else : echo "Post Not Found"; //Make a 404 function here
	endif;
?>




<?php get_footer(); ?>