<style>
  .wp-editor-wrap.tmce-active{
    margin-top: -25px;
  }
  
  .form-control {
    width:100%;
  }
</style>


<div class="wrap">
  <h1>Site settings</h1>
  <form method="post" action="options.php">
    <?php
      settings_fields("section");
      do_settings_sections("theme-options");
      submit_button(); ?>
  </form>
</div>
