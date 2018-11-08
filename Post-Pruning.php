/**
 * Add monthly interval to the schedules (since WP doesnt provide it from the start)
 */
add_filter('cron_schedules','cron_add_daily');
 function cron_add_daily($schedules) {
 $schedules['monthly'] = array(
 'interval' => 84600,
 'display' => __( 'Once per day' )
 );
 return $schedules;
 }
 /**
 * Add the scheduling if it doesnt already exist
 */
add_action('wp','setup_schedule');
 function setup_schedule() {
 if (!wp_next_scheduled('daily_pruning') ) {
 wp_schedule_event( time(), 'daily', 'daily_pruning');
 }
 }
 /**
 * Add the function that takes care of removing all rows with post_type=post that are older than 30 days
 */
add_action( 'daily_pruning', 'remove_old_posts' );
 function remove_old_posts() {
 global $wpdb;
 $wpdb->query($wpdb->prepare("DELETE FROM wp_posts WHERE post_type='jobs' AND post_date < DATE_SUB(NOW(), INTERVAL 14 DAY);"));
 }
