<?php

// We are being included by the google api stuff to render HTML.
// This is the result data google sent back, I think.

global $s;

?>

<?php if(

	// Make sure the result_data is alive
	// (poke).
	is_object($result_data)

	// The there are results.
	&& is_array(
		$result_data
			->responseData
			->results
	)
	
): ?>

	<!-- Googled: "<?php echo $s; ?>" -->

	<?php foreach($result_data->responseData->results as $result): ?>

		<li onclick="gdurl_put_link_input('<?php echo $result->url; ?>','<?php echo htmlentities($result->titleNoFormatting); ?>'); return false;" class="gdurl-googled">
			<span class="item-title" title="<?php echo htmlentities($result->url); ?>">
				<?php echo substr($result->url, 0, 30); ?>
			</span>
			<span class="item-info" title="<?php echo htmlentities($result->titleNoFormatting); ?>">
				<?php echo substr($result->titleNoFormatting, 0, 30); ?>
			</span>
		</li>

	<?php endforeach; ?>

<?php endif; ?>