<article class="simple <?php echo get_post_type(); ?>" id="v<?php the_id(); ?>">
	<div class="poster">
		<a href="<?php the_permalink(); ?>"><img src="<?php echo dbmovies_get_poster($post->ID); ?>" alt="<?php the_title(); ?>"></a>
	</div>
	<div class="data">
		<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
		<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, 'dtyear'))) {  ?>
		<span><?php echo $mostrar; ?></span>
		<?php } else { ?>
		<span>&nbsp;</span>
		<?php } ?>
	</div>
</article>
