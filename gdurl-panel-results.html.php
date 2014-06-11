<!-- Wordpress -->
<?php if(

	// Make sure the result_data is alive
	// (poke).
	is_array( $wordpress_results )
	
): ?>

	<!-- Searched: "<?php echo $s; ?>" -->
	
	<li class="gdurl-results">
		<em><strong>
			<?php _e( 'Your Site' ); ?>
		</strong></em>
	</li>

	<?php foreach($wordpress_results as $result): ?>

		<li class="gdurl-googled">
			<input type="hidden" class="item-permalink" value="<?php echo htmlentities( $result['permalink'] ); ?>">
			<span class="item-title" title="<?php echo htmlentities( $result['permalink'] ); ?>"><?php echo $result['title']; ?></span>
			<span class="item-info" title="<?php echo htmlentities( $result['title'] ); ?>"><?php echo substr( $result['permalink'], 0, 30); ?></span>
		</li>

	<?php endforeach; ?>

<?php endif; ?>


<!-- Google -- >
<?php if(

	// Make sure the result_data is alive
	// (poke).
	is_object($google_results)

	// The there are results.
	&& is_array(
		$google_results
			->responseData
			->results
	)
	
): ?>

	<!-- Googled: "<?php echo $s; ?>" -->

	<li class="gdurl-results">
		<em><strong>
			<?php _e( 'Google Results' ); ?>
		</strong></em>
	</li>

	<?php foreach($google_results->responseData->results as $result): ?>

		<li class="gdurl-googled">
			<input type="hidden" class="item-permalink" value="<?php echo htmlentities($result->url); ?>">
			<span class="item-title" title="<?php echo htmlentities($result->url); ?>"><?php echo $result->titleNoFormatting; ?></span>
			<span class="item-info" title="<?php echo htmlentities($result->titleNoFormatting); ?>"><?php echo substr($result->url, 0, 30); ?></span>
		</li>

	<?php endforeach; ?>

<?php endif; ?>