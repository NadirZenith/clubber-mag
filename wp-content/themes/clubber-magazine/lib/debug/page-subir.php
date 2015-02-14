
<style>
        #nz-debug{
                width:80%;min-height: 500px; margin-top: 20px; background-color: #fff;position: relative;border: 3px solid #111;
                /*height: auto;*/
        }
        #nz-debug .buttons{
                min-height:70px; background-color: #eee
        }
        #nz-debug input[type=button]{
                color: #6d6d6d; background-color: #333; height: 30px; width: 80px;
                padding: 3px;
                margin: 5px;
        }
        #nz-debug-output{
                min-height:50px;max-height: 500px; ;width: 98%;position:absolute; bottom: 0;
                background-color: #999; color: #036881;padding: 0.3% 1% 0.3% 1.1%;border-top: 2px solid #333;
        }
        #nz-debug-output .panel-1{
                width: 98%;max-height: 400px; margin-right: 2%;background-color:inherit; 
                overflow-y: scroll;
        }
        #nz-debug-output .panel-1 pre{
                background-color:#999;padding: 8px; 
        }
        #nz-debug-output .panel-2{
                display: none;
                width: 48%;max-height: 400px; margin-right: 2%;background-color: #777; 
                overflow-y: scroll;
                
        }

</style>
<div id="nz-debug" style="">
        <h1>NZ DEBUG</h1>
        <div class="buttons" style="">

                <input style="" type="button" id="ajax-test" value="ajax-test" />
                <input id="nz-output-keep" type="checkbox" name="nz-output-keep" /> <span style="color:black">keep</span>
        </div>


        <div id="nz-debug-output" class="pr" style="">
                <h2 class="big" style="margin:2px;line-height: 1">nz-debug-output</h2>
                <div class="panel-1 fl" style="">panel 1</div>
                <div class="panel-2 fl" style="">panel 2
                        <span style="color:#036881">color: 036881</span>
                        <span style="color:#2b2">color: 2b2</span>
                        <span style="color:#f26e50">color: f26e50</span>
                </div>
        </div>
</div>
<?php

wp_enqueue_script('nz-debug-ajax-page-subir', get_template_directory_uri() . '/js/debug/ajax-page-subir.js', array('jquery'), 1, true)
?>
