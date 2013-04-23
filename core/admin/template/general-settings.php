<div class="metabox-holder">
  <div class="postbox">
    <h3><span class="global-settings">&nbsp;</span>General Settings</h3>
      <div class="content">


        <label for="mobile-theme"><strong>Thema of Mobile Site</strong></label>
        <?php $themes = wp_get_themes();?>
        <?php if ( count( $themes )  > 1) { ?>
              <select name="mobile-theme">
                <option value="default" >Default</option>
                <?php foreach ($themes as $theme) { ?>
                <option value="<?php echo $theme->template;?>"<?php if ( $this->mobile_settings->getSetting('mobile-theme') == $theme->template ) echo " selected"; ?>><?php echo $theme->name; ?></option>
                <?php }?>
              </select>
        <?php } else {?>
          <strong class="no-themes">You don't have themes or only have one themes yet. Create some first!</strong>
        <?php } ?>
      </div>
  </div><!-- postbox -->
</div><!-- metabox -->