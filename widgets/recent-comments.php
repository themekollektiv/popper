<?php
/*
 * Enhanced Recent Comments widget.
 * This code adds a new widget that shows commenter avatar, and comment excerpt.
 * Gently lifted and reworked from Anders Norén's Lovecraft theme: http://www.andersnoren.se/teman/lovecraft-wordpress-theme/
 */

register_widget( 'popper_recent_comments' );

class popper_recent_comments extends WP_Widget {

	public function __construct() {

		$widget_ops = array(
			'classname'   => 'widget_popper_recent_comments',
			'description' => esc_html__( 'Displays recent comments with user avatar and excerpt.', 'popper' )
		);
		parent::__construct(
			'widget_popper_recent_comments', esc_html__( 'Enhanced Recent Comments', 'popper' ),
			$widget_ops
		);
	}

	public function widget( $args, $instance ) {

		// Outputs the content of the widget
		extract( $args, EXTR_SKIP ); // Make before_widget, etc available.

		$widget_title       = NULL;
		$number_of_comments = NULL;

		$widget_title       = esc_attr( apply_filters( 'widget_title', $instance[ 'widget_title' ] ) );
		$number_of_comments = esc_attr( $instance[ 'number_of_comments' ] );

		echo isset( $before_widget ) ? $before_widget : '';
		$before_title = isset( $before_title ) ? $before_title : '';
		$after_title  = isset( $after_title ) ? $after_title : '';

		if ( ! empty( $widget_title ) ) {
			echo $before_title . $widget_title . $after_title;
		} else {
			echo $before_title . esc_html__( 'Recent Comments', 'popper' ) . $after_title;
		}
		?>

		<ul class="popper-widget-list" xmlns="http://www.w3.org/1999/html">

			<?php
			if ( 0 === $number_of_comments ) {
				$number_of_comments = 5;
			}

			$args = array(
				'orderby' => 'date',
				'number'  => $number_of_comments,
				'status'  => 'approve'
			);

			global $comment;

			// The Query
			$comments_query = new WP_Comment_Query;
			$comments       = $comments_query->query( $args );

			// Comment Loop
			if ( $comments ) {
				foreach ( (array) $comments as $comment ) { ?>

					<li>
						<a href="<?php echo get_permalink( $comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
							<div class="post-icon">
								<?php echo get_avatar( get_comment_author_email( $comment->comment_ID ), $size = '96' ); ?>
							</div>
							<p class="title"><span><?php comment_author(); ?></span></p>
							<p class="excerpt"><?php echo esc_attr( get_comment_excerpt( $comment->comment_ID ) ); ?></p>
							<p class="original-title">
								<span><?php esc_attr_e( 'on', 'popper' ); ?></span> <?php the_title_attribute( array( 'post' => $comment->comment_post_ID ) ); ?>
							</p>
						</a>
					</li>

				<?php }
			}
			?>

		</ul>

		<?php
		echo isset( $after_widget ) ? $after_widget : '';
	}


	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance[ 'widget_title' ] = strip_tags( $new_instance[ 'widget_title' ] );
		// make sure we are getting a number
		$instance[ 'number_of_comments' ] = is_int( (int) $new_instance[ 'number_of_comments' ] )
			? (int) $new_instance[ 'number_of_comments' ] : 5;

		//update and save the widget
		return $instance;
	}

	public function form( $instance ) {

		// Set defaults
		if ( ! isset( $instance[ 'widget_title' ] ) ) {
			$instance[ 'widget_title' ] = '';
		}
		if ( ! isset( $instance[ 'number_of_comments' ] ) ) {
			$instance[ 'number_of_comments' ] = '5';
		}

		// Get the options into variables, escaping html characters on the way
		$widget_title       = esc_attr( $instance[ 'widget_title' ] );
		$number_of_comments = esc_attr( $instance[ 'number_of_comments' ] );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>"><?php _e( 'Title', 'popper' ); ?>:
				<input id="<?php echo esc_attr( $this->get_field_id( 'widget_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'widget_title' ) ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $widget_title ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number_of_comments' ); ?>"><?php _e( 'Number of comments to display', 'popper' ); ?>:
				<input id="<?php echo $this->get_field_id( 'number_of_comments' ); ?>" name="<?php echo $this->get_field_name( 'number_of_comments' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $number_of_comments ); ?>" /></label>
			<small>(<?php _e( 'Defaults to 5 if empty', 'popper' ); ?>)</small>
		</p>

		<?php
	}
}

/**
 * Remove the line above and uncomment the lines below to replace the default widget
 *
 * @todo We should remove this, is more a task for a plugin, no relevance for a theme.
 */
/*
function popper_comments_widget_registration() {
	unregister_widget('WP_Widget_Recent_Comments');
	register_widget('popper_recent_comments');
}
add_action('widgets_init', 'popper_comments_widget_registration');
*/