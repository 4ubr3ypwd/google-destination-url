<?php if(

	/**
	 * WordPress
	 */

	// Make sure the result_data is alive
	// (poke).
	is_array( $wordpress_results )
	
): ?>

	<!-- Wordpress -->
	
	<li class="gdurl-results">
		<em><strong>
			<?php _e( 'Your Site' ); ?>
		</strong></em>
	</li>

	<?php foreach($wordpress_results as $result): ?>

		<li class="gdurl-googled">
			<input type="hidden" class="item-permalink" value="<?php echo htmlentities( $result['permalink'] ); ?>">
			<span class="item-title" title="<?php echo htmlentities( $result['permalink'] ); ?>"><?php _e( $result['title'], 'gdurl' ); ?></span>
			<span class="item-info" title="<?php _e( htmlentities( $result['title'] ), 'gdurl' ); ?>"><?php echo substr( $result['permalink'], 0, 30); ?></span>
		</li>

	<?php endforeach; ?>

<?php endif; ?>

<?php if(

	/**
	 * Google
	 */

	// Make sure the result_data is alive
	// (poke).
	is_object( $google_results )

): ?>

	<!-- Google -->
	<li class="gdurl-results">
		<em>
			<strong>
				<?php _e( 'Google Results', 'gdurl' ); ?>
			</strong>
		</em>
	</li>

	<?php foreach($google_results->responseData->results as $result): ?>

		<li class="gdurl-googled">
			<input type="hidden" class="item-permalink" value="<?php echo htmlentities($result->url); ?>">
			<span class="item-title" title="<?php echo htmlentities($result->url); ?>"><?php _e( $result->titleNoFormatting, 'gdurl' ); ?></span>
			<span class="item-info" title="<?php _e( htmlentities($result->titleNoFormatting), 'gdurl' ); ?>"><?php echo substr($result->url, 0, 30); ?></span>
		</li>

	<?php endforeach; ?>

<?php else: ?>
	<li class="gdurl-googled">
		<em>
			<?php _e( 'No Results from Google', 'gdurl' ); ?>
		</em>
	</li>
<?php endif; ?>