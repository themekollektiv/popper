<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package popper
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="site-info">
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'popper' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'popper' ), 'WordPress' ); ?></a>
		<?php echo apply_filters( 'popper_footer_link', sprintf(
			'<span class="sep"> | </span>' . esc_html__( 'Theme: %1$s', 'popper' ),
			'<a href="https://wordpress.org/themes/popper/" target="_none"	rel="nofollow">Popper</a>'
		) ); ?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
