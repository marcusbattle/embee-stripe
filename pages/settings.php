<?php $stripe_settings = get_option( 'stripe_settings', false ); ?>
<div class="wrap">
	<h2>Stripe Settings</h2>
	<form method="POST" action="<?php echo admin_url('admin-post.php'); ?>" />
		<input type="hidden" name="action" value="save_stripe_settings" />
		<?php wp_nonce_field(); ?>
		<div class="form-row">
			<label>Mode</label>
			<select name="stripe_settings[mode]">
				<option value="">--</option>
				<option value="test" <?php selected( $stripe_settings['mode'], 'test' ); ?>>Test</option>
				<option value="live" <?php selected( $stripe_settings['mode'], 'live' ); ?>>Live</option>
			</select>
		</div>
		<div class="form-row">
			<label>Currency</label>
			<select name="stripe_settings[currency]">
				<option value="">--</option>
				<option value="USD" <?php selected( $stripe_settings['currency'], 'USD' ); ?>>USD</option>
			</select>
		</div>
		<div class="form-row">
			<label>Live Secret Key</label>
			<input type="text" name="stripe_settings[live_secret_key]" value="<?php echo $stripe_settings['live_secret_key'] ?>" />
		</div>
		<div class="form-row">
			<label>Live Publishable Key</label>
			<input type="text" name="stripe_settings[live_publishable_key]" value="<?php echo $stripe_settings['live_publishable_key'] ?>" />
		</div>
		<div class="form-row">
			<label>Test Secret Key</label>
			<input type="text" name="stripe_settings[test_secret_key]" value="<?php echo $stripe_settings['test_secret_key'] ?>" />
		</div>
		<div class="form-row">
			<label>Test Publishable Key</label>
			<input type="text" name="stripe_settings[test_publishable_key]" value="<?php echo $stripe_settings['test_publishable_key'] ?>" />
		</div>
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
		</p>
	</form>
</div>