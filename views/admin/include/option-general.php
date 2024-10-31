
<form action="<?php echo esc_url(admin_url().'admin.php?page=next-mega&tab=general');?>" name="setting_ebay_form" method="post" >
	<h3><?php echo esc_html__('General Services', 'next-megamenu');?></h3>
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<div class="flex-form">
			<div class="left-div">
				<label for="ebay_show_sold_product" class="inline-label">
					<?php echo esc_html__('Enable MegaMenu ', 'next-megamenu');?>
				</label>
			</div>
			<div class="right-div">
				<input type="checkbox" onclick="themedevmega_show(this);" nx-target=".next-custom-login-page" name="themedev[general][mega][ebable]" <?php echo isset($getGeneral['general']['mega']['ebable']) ? 'checked' : ''; ?>  class="themedev-switch-input" value="Yes" id="themedev-enable_feed">
				<label class="themedev-checkbox-switch" for="themedev-enable_feed">
					<span class="themedev-label-switch" data-active="ON" data-inactive="OFF"></span>
				</label>
				<span class="themedev-document-info block"> <?php echo esc_html__('Enable megamenu service for your site.', 'next-megamenu');?></span>
			</div>
		</div>
	</div>
	
	<div class="<?php echo esc_attr('themeDev-form');?>">
		<button type="submit" name="themedev-mail-general" class="themedev-submit"> <?php echo esc_html__('Save ', 'next-megamenu');?></button>
	</div>
</form>