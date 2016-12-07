<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package popper
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( has_post_thumbnail() ) { ?>
			<figure class="featured-image">
				<?php if ( popper_is_first_post() ) { ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
						<?php the_post_thumbnail(); ?>
					</a>
				<?php } else {
					the_post_thumbnail();
				}
				?>
			</figure>
		<?php }

			if ( popper_is_first_post() ) {
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			} else {
				the_title( '<h1 class="entry-title">', '</h1>' );
			}

		/** @var \WP_Post $post */
		if ( has_excerpt( $post->ID ) ) {
			echo '<div class="deck">';
			echo '<p>' . get_the_excerpt() . '</p>';
			echo '</div><!-- .deck -->';
		}
		?>

		<div class="entry-meta">
			<?php popper_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( '' );
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'popper' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php
		if ( ! popper_is_first_post() ) { ?>
			<footer class="entry-footer">
				<?php popper_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		<?php } else { 
			echo popper_modify_read_more_link();
		}
?>
</article><!-- #post-## -->
