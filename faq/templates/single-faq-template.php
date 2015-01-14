<?php 

$post_id = get_the_ID(); 
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

?>

<header><h1><?php get_the_title(); ?></h1></header>
<section class="post_content clearfix" itemprop="articleBody">
	<p><?php echo get_the_content(); ?></p>
	<br />

	<?php 
	$num = get_post_meta( $post_id, 'faq', true );
	if( $num ){
	?>

	<div class="panel-group" id="accordian" role="tablist" aria-multiselectable="true">
	<?php for( $n = 0; $n < $num; $n++) { ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $f->format($n); ?>" aria-expanded="false" aria-controls="collapse<?php echo $f->format($n); ?>">
					<div class="triangle"> </div><?php echo get_post_meta( $post_id, 'faq_' . $n . '_question', true ); ?>
				</a>
			</div><!-- panel heading -->
			<div id="collapse<?php echo $f->format($n); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $f->format($n); ?>">
		      <div class="panel-body col-xs-offset-1">
		        <p><?php echo get_post_meta( $post_id, 'faq_' . $n . '_answer', true ); ?></p>
		      </div> <!-- panel-body -->
		    </div><!-- collapseOne -->
		</div> <!-- single panel -->
	<?php } ?>
	</div> <!-- panel group -->
	
	<?php }//end if ?>
</section>
