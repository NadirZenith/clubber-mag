<?php

function nz_ajaxurl() {
        ?>
        <script type="text/javascript">
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
        <?php
}
