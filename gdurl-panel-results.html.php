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

		<li class="gdurl-googled">
			<input type="hidden" class="item-permalink" value="<?php echo htmlentities($result->url); ?>">
			<span class="item-title" title="<?php echo htmlentities($result->url); ?>"><?php echo $result->titleNoFormatting; ?></span>
			<span class="item-info" title="<?php echo htmlentities($result->titleNoFormatting); ?>"><?php echo substr($result->url, 0, 30); ?></span>
		</li>

	<?php endforeach; ?>

<?php endif; ?>