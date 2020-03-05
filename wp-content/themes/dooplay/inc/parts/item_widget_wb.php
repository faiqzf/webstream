<?php
$rating = doo_get_postmeta( DOO_MAIN_RATING );
$imdb = ($a = doo_get_postmeta('imdbRating')) ? $a : '0';

?>

<article class="w_item_b"  id="post-<?php the_id(); ?>">
<?php $dates = doo_get_postmeta("air_date"); ?>
	<a href="<?php the_permalink() ?>">
		<div class="image">
			<img src="<?php echo dbmovies_get_poster($post->ID,'dt_poster_b','dt_poster','w92'); ?>" alt="<?php the_title(); ?>" />
		</div>
		<div class="data">
				<h3><?php the_title(); ?></h3>
				<?php if($mostrar = $terms = strip_tags( $terms = get_the_term_list( $post->ID, 'dtyear'))) {  ?>
				<span class="wdate"><?php echo $mostrar; ?></span>
				<?php } ?>
				<span class="wextra">
					<b><i class="icon-star2"></i> <?php echo ($rating) ? $rating : $imdb; ?></b>
				</span>
		</div>
	</a>
</article>
