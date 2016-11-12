<?php
include 'index.php';
$error = filter_input(INPUT_GET, 'error', FILTER_SANITIZE_SPECIAL_CHARS);
?>
<script>
    $(document).ready(function () {
        open_window(event, 'dialog', 'apps/system/dialog',<?=$error?>);
    });

</script>