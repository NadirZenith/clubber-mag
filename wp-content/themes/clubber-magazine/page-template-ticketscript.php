<?php
/**
 * Template Name: TicketScript Template
 *
 * Displays the index TicketScript template.
 *
 */
?>
<div class="col-1 col-sm-1-2 fl">
    <div class="ibox-5">
        <div class="box-5">
            <?php
            $default = false;

            if ($default) {
                NzWpCmTicketscript::get_ticket_script();
            } else {
                $body = get_transient('nz_wp_cm_ticketscript_xml');

                if (!$body) {

                    $remote = wp_remote_get('https://shop.ticketscript.com/channel/xml/get-events/rid/LSSX45SZ/language/es');
                    /*
                      'headers' => array (9)
                      'body' => string UTF-8 (4463) "<?xml version="1.0" encoding="UTF-8"?> <info><organization>C …"
                      'response' => array (2)
                      'cookies' => array (1)
                      'filename' => NULL
                     */
                    if ($remote['response']['code'] === 200) {
                        $body = $remote['body'];
                        set_transient('nz_wp_cm_ticketscript_xml', $body, 60 * 20);
                    }
                }



                $xml_parser = simplexml_load_string($body);
                /*
                  public organization -> string (11) "Clubber Mag"
                  public website -> string (26) "http://www.clubber-mag.com"
                  public copyright -> string (17) "ticketscript 2015"
                  public lastBuildDate -> string (25) "2015-05-20T16:25:10+02:00"
                  public event -> array (10)
                 */
                if (!empty($xml_parser->event)) {
                    $events = $xml_parser->event;
                    ?>
                    <ul>
                        <?php
                        foreach ($events as $event) {
                            /*
                              public id -> string (6) "254478"
                              public date -> string (10) "23-05-2015"
                              public name -> string (28) "Under Club presents 2manydjs"
                              public city -> string (9) "Barcelona"
                              public location -> string (10) "UNDER Club"
                              public time -> string (8) "23:45:00"
                              public timestamp -> string (25) "2015-05-23T23:45:00+02:00"
                              public industry -> string (10) "club night"
                              public logo -> string (62) "https://shop.ticketscript.com/uploads/images/247007-perfil.jpg"
                             *  */
                            ?>
                            <li>
                                <article class="mb15 bg-50 block-5">
                                    <header class="m5">
                                        <h2>
                                            <a class="sc-2" href="#<?php echo $event->id ?>" title="">
                                                <?php
                                                echo $event->name;
                                                ?>
                                            </a>
                                        </h2>
                                    </header>
                                    <hr class="pb5">
                                    <div class="fr nm pr col-1 col-sm-1-2">
                                        <!--
                                                                                <a class="featured-image" href="<?php echo $event->id ?>">
                                                                                    <img src="<?php echo $event->logo ?>">
                                                                                </a>
                                        -->
                                        <div class="p-detail">
                                            <?php
                                            echo $event->time . ' - ' . $event->date;
                                            ?>
                                        </div>

                                    </div>
                                    <div class="fl col-1 col-sm-1-2 pb15">
                                        <div class="m5 bold tj">
                                            <p>
                                                <?php
                                                echo $event->city . '<br>';
                                                echo $event->location . '<br>';
                                                ?>

                                            </p>
                                        </div>

                                    </div>

                                    <div style="position: absolute; bottom: 10px;right: 20px;">
                                        <a class="readmore" href="#buy" title=""> <?php echo __('Read more', 'cm') ?></a>
                                    </div>
                                </article>
                                <?php ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                }
            }
            ?>

        </div>
    </div>
</div>
<div class="col-1 col-sm-1-2 fl">
    <div class="ibox-5">
        <div class="box-5">
            <?php
            $mobile = false;
            ?>
            <?php
            if ($mobile) {
                ?>
                <script language="javascript" type="text/javascript">
                    function resizeIframe(obj) {
                        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                        alert('loaded');
                    }
                </script>
                <iframe name="ts-mobile-iframe" height="1000" width="500" src="https://m.ticketscript.com/channel/web2/get-dates/rid/LSSX45SZ/eid/254478/language/es" 
                        frameborder="0" 
                        scrolling="no" 
                        seamless="seamless"
                        onload="resizeIframe(this);"
                        >

                </iframe>

                <?php
            } else {
                /*NzWpCmTicketscript::get_ticket_script();*/
                NzWpCmTicketscript::get_ticket_script(254478);
            }
            ?>
            <?php
            ?>

        </div>
    </div>
</div>