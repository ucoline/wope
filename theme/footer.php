<?php wp_nonce_field('ajax-action-nonce', 'ajax_action'); ?>

<script type="text/javascript">
  var ajax_nonce = $("#ajax_action").val();
</script>

<!--- jQuery & JS Scripts --->
<script src="<?= libs_url('bootstrap/js/bootstrap.min.js'); ?>"></script>
<script src="<?= libs_url('fancybox/jquery.fancybox.min.js'); ?>"></script>
<script src="<?= libs_url('felkit/jquery.scripts.js'); ?>"></script>
<script src="<?= libs_url('notify/jquery.notify.min.js'); ?>"></script>
<script src="<?= libs_url('owl-carousel/owl.carousel.min.js'); ?>"></script>

<?php
// Container js files
$js_files = Container::js_files();

if ($js_files) {
  foreach ($js_files as $js_file) {
    echo '<script src="'. $js_file .'"></script>';
  }
} ?>
