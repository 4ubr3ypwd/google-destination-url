<?php

// We are being included by the google api stuff to render HTML.
// This is the result data google sent back, I think.
global $result_data;

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

		<!-- I'm here because google-destination-url plugin put me here. -->
		<div class="query-results">
			<ul>

				<div class="query-notice" style="text-align:right">
					<em>
						<a href="#" 
							id="gdesturl_js_setback" 
							onclick="gdesturl_js_setback(gdesturl_js_search_panel_html);">
						&times Close
					</a></em>
				</div>

				<?php foreach($result_data->responseData->results as $result): ?>

					<li class="alternate">
						<span class="item-title" title="<?php echo htmlentities($result->url); ?>">
							<?php echo substr($result->url, 0, 30); ?>
						</span>
						<span class="item-info" title="<?php echo htmlentities($result->titleNoFormatting); ?>">
							<?php echo substr($result->titleNoFormatting, 0, 30); ?>
						</span>
					</li>

				<?php endforeach; ?>
			</ul>
		</div>

<?php else: ?>

	<div class="query-notice">
		<em>
			<a href="#" 
				id="gdesturl_js_setback" 
				onclick="gdesturl_js_setback(gdesturl_js_search_panel_html);">
			&times Close
		</a></em>
	</div>

	<div class="query-results">
		<div class="query-notice">
			<em>No results.</em>
		</div>
	</div>

<?php endif; ?>