<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package popper
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php
		if ( has_post_thumbnail() ) { ?>
			<figure class="featured-image">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_post_thumbnail(); ?>
				</a>
			</figure>
		<?php } ?>
		<?php
		if ( popper_is_first_post() ) {
			the_title(
				sprintf(
					'<h2 class="entry-title"><a href="%s" rel="bookmark">',
					esc_url( get_permalink() )
				),
				'</a></h2>'
			);

			/** @var \WP_Post $post */
			if ( has_excerpt( $post->ID ) ) {
				echo '<div class="deck">';
				echo '<p>' . get_the_excerpt() . '</p>';
				echo '</div><!-- .deck -->';
			}

			echo '<div class="entry-meta">';
			popper_posted_on();
		} else {
			the_title(
				sprintf(
					'<h2 class="entry-title index-excerpt"><a href="%s" rel="bookmark">',
					esc_url( get_permalink() )
				), '</a></h2>'
			);
			echo '<div class="index-entry-meta">';
			popper_index_posted_on();
		} ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content index-excerpt">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

	<?php echo popper_modify_read_more_link(); ?>

</article><!-- #post-## -->
