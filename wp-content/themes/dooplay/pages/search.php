<header>
	<h1><?php _d('Results found:');  ?> <?php echo get_search_query(); ?></h1>
</header>
<div class="search-page">
	<div class="search_page_form">
		<form method="get" id="searchformpage" action="<?php echo esc_url( home_url() ); ?>">
			<input type="text" placeholder="<?php _d('Search...'); ?>" name="s" id="s" value="<?php echo get_search_query(); ?>">
			<button type="submit"><span class="icon-search2"></span></button>
		</form>
	</div>

<?php
	if (have_posts()) :while (have_posts()) : the_post();
	$dt_date = new DateTime(doo_get_postmeta('air_date'));
	$dt_player	= get_post_meta($post->ID, 'repeatable_fields', true);
?>
	<div class="result-item">
		<article>
			<div class="image">
				<div class="thumbnail animation-2">
					<a href="<?php the_permalink(); ?>">
					<?php if(get_post_type() == 'episodes') { ?>
					<img src="<?php echo dbmovies_get_backdrop($post->ID, 'w92'); ?>" alt="<?php the_title(); ?>" />
					<?php } else { ?>
					<img src="<?php echo dbmovies_get_poster($post->ID,'thumbnail','dt_poster','w92'); ?>" alt="<?php the_title(); ?>" />
					<?php } ?>
					<span class="<?php echo get_post_type(); ?>">
					<?php
					// Get post types
					if($d = get_post_type() == 'movies') { _d('Movie'); }
					if($d = get_post_type() == 'tvshows') { _d('TV'); }
					if($d = get_post_type() == 'post') { _d('Post'); }
					if($d = get_post_type() == 'episodes') { _d('Episode'); }
					if($d = get_post_type() == 'seasons') { _d('Season'); }
					?>
					</span>
					</a>
				</div>
			</div>
			<div class="details">
				<div class="title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</div>
				<div class="meta">
				<?php if($rt = doo_get_postmeta('imdbRating')) { echo '<span class="rating">IMDb '. $rt .'</span>'; } ?>
				<?php if( get_post_type() == 'episodes') { if($d = $dt_date) { echo '<span class="year">', $d->format(DOO_TIME), '</span>'; } } ?>
				<?php if($yr = $tms = strip_tags( $tms = get_the_term_list( $post->ID, 'dtyear'))) { echo '<span class="year">'. $yr .'</span>'; } ?>
				<?php $i=0; if ( $dt_player ) : foreach ( $dt_player as $field ) { if($i==2) break; if($field['idioma']) { ?>
				<span class="flag" style="background-image: url(<?php echo DOO_URI, '/assets/img/flags/',$field['idioma'],'.png'; ?>)"></span>
				<?php } $i++; } endif; ?>
				</div>
				<div class="contenido">
					<p><?php dt_content_alt('200'); ?></p>
				</div>
			</div>
		</article>
	</div>
<?php endwhile; else: ?>
<div class="no-result animation-2">
	<h2><?php _d('No results to show with'); ?> <span><?php echo get_search_query(); ?></span></h2>
	<strong><?php _d('Suggestions'); ?>:</strong>
	<ul>
		<li><?php _d('Make sure all words are spelled correctly.'); ?></li>
		<li><?php _d('Try different keywords.'); ?></li>
		<li><?php _d('Try more general keywords.'); ?></li>
	</ul>
</div>
<?php endif; ?>
</div>
