<?php /** View for the search form. **/ ?>
<div id="dbcl_panel">	
	<form id="dbcl_form">
		<p>Enter the cache key and cache group:</p>
		<p>
		<label for="dbcl_key">Key:</label>
		<input type="text" id="dbcl_key" name="dbcl_key">
		</p>
		<p>
		<label for="dbcl_group">Group:</label>
		<input type="text" id="dbcl_group" name="dbcl_group">
		</p>
		<p class="center"><input type="submit" value="Lookup" class="button button-primary"></p>
	</form><br/>
	<pre id="dbcl_results"></pre>
</div>
