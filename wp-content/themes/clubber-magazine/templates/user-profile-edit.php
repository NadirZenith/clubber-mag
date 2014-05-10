
<?php 
?>
<section class="bg-50 block-5">
         <div class="ml15 cb group" >

                <h1 class="fl">
                        <?php echo $curauth->get('display_name'); ?>
                </h1>
                
        </div>
        <div class="mt5 ml5 meddium mr5 cb">
                <style>
                        .gfield_date_month,
                        .gfield_date_day{
                                width: 40px;
                                float: left;
                                margin-left: 5px;
                        }
                        .gfield_date_year{
                                float: left;
                                width: 50px;
                                margin-left: 5px;
                                
                        }
                </style>

                <?php
                echo do_shortcode('[gravityform id="' . 6 . '" title="false" description="false" ajax="true"]');
                ?>
        </div>
</section>
