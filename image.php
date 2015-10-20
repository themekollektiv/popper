<?php
/**
 * The template for displaying image attachment posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#attachment
 *
 * @package popper
 */

// Retrieve attachment metadata.
$metadata = wp_get_attachment_metadata();

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <header class="entry-header clear">

                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <div class="entry-meta">
                                <?php _e('Featured in: ', 'popper'); ?><span class="parent-post-link"><a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></span>.
                                <?php _e('Full size image: ', 'popper'); ?><span class="full-size-link"><a href="<?php echo wp_get_attachment_url(); ?>"><?php echo $metadata['width']; ?> &times; <?php echo $metadata['height']; ?></a></span>.
                                <?php edit_post_link( __( 'Edit attachment post', 'popper' ), '<span class="edit-link">', '</span>.' ); ?>
                            </div><!-- .entry-meta -->
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <div class="entry-attachment">
								<figure class="image-attachment centered-image<?php if ( has_excerpt() ) { echo " alignnone wp-caption"; } ?>">
                                    <?php popper_the_attached_image(); ?>
                                    <?php if ( has_excerpt() ) : ?>
                                        <figcaption class="wp-caption-text">
                                            <?php echo get_the_excerpt(); ?>
                                        </figcaption><!-- .entry-caption -->
                                    <?php endif; ?>
                                </figure><!-- .wp-caption -->


                            </div><!-- .entry-attachment -->

                            <?php
                                    the_content();
                                    wp_link_pages( array(
                                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'popper' ) . '</span>',
                                            'after'       => '</div>',
                                            'link_before' => '<span>',
                                            'link_after'  => '</span>',
                                    ) );
                            ?>
                        </div><!-- .entry-content -->

			<?php popper_attachment_nav(); ?>

			<?php
                            // If comments are open or we have at least one comment, load up the comment template
                            if ( comments_open() || '0' != get_comments_number() ) :
                                    comments_template();
                            endif;
			?>
                    </article><!-- #post -->

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>