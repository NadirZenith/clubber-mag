
<script type="text/javascript">
        jQuery(document).ready(function($) {
                $('#input_<?php echo $nz['form.event']['id']; ?>_3').datetimepicker({
                        addSliderAccess: true,
                        sliderAccessArgs: {touchonly: false}
                });
                $('#input_<?php echo $nz['form.event']['id']; ?>_19').datetimepicker({
                        addSliderAccess: true,
                        sliderAccessArgs: {touchonly: false}
                });
        });
</script>
<style>
        .gform_confirmation_wrapper {
                font-size: 150%;
                font-weight: 700;
                margin-left: 20px;
                margin-top: 30px;
                color:#333;
        }

</style>

<section class="bg-50 block-5">

        <div class="col-3-4" style="margin: auto">

                <?php
                echo $nz['event_form'];
                ?>
        </div>
</section>
