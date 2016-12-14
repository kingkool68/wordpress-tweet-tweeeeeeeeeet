<?php
class Tweet_Date_Archive_Widget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct(
		 	// Base ID
			'Tweet_Date_Archive_Widget',

			// Name
			'Tweet Date Archive',

			// Args
			array(
				'description' => 'Add fancy archive stats',
			)
		);
	}

	function widget( $args, $instance ) {
		$date_format = '%Y-%m';
		if ( is_month() ) {
			$date_format = '%Y-%m-%d';
		}
		if ( is_day() ) {
			$date_format = '%l %p';
		}

		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		if ( $dates = get_archive_date_counts( $date_format ) ) {
			foreach ( $dates as $obj ) {
				$date = $obj->the_date;
				$count = intval( $obj->count );
				echo '<p>' . $obj->the_date . ': ' . number_format( $count ) . '</p>';
			}
		}
		echo $args['after_widget'];
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$title = '';
		if ( ! empty( $new_instance['title'] ) ) {
			$title = strip_tags( $new_instance['title'] );
		}
		$instance = array(
			'title' => $title,
		);

		return $instance;
	}

	function form( $instance ) {
		$title = '';
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
}

function tweet_theme_register_date_archive_widget() {
	register_widget( 'Tweet_Date_Archive_Widget' );
}
add_action( 'widgets_init', 'tweet_theme_register_date_archive_widget' );

/*
Suggested Date Formats:
%Y Year (2016)
%Y-%m Year  Month (2016-08)
'%Y-%m-%d Year Month Day (2016-08-01)
 */
function get_archive_date_counts( $date_format = '%Y-%m', $limit = 500 ) {
	global $wpdb;
	$result = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT
				DATE_FORMAT(`post_date`, %s) AS `the_date`,
				COUNT( DATE_FORMAT(`post_date`, %s) ) AS `count`
			FROM $wpdb->posts
			WHERE
				`post_type` = 'tweet' AND
				`post_status` = 'publish'
			GROUP BY `the_date`
			ORDER BY `count` DESC
			LIMIT 0,%d;
			",
			$date_format,
			$date_format,
			$limit
		)
	);
	return $result;
}

// get_archive_date_counts( '%Y-%m' );
