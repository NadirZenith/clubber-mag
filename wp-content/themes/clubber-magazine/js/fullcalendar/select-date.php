<!DOCTYPE html>
<html>
      <head>
            <link href='../fullcalendar/fullcalendar.css' rel='stylesheet' />
            <!--<link href='../fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />-->
            <script src='../lib/jquery.min.js'></script>
            <!--<script src='../lib/jquery-ui.custom.min.js'></script>-->
            <script src='../fullcalendar/fullcalendar.min.js'></script>

            <?php
            $start_date = strtotime("now");
            if (isset($_GET['date'])) {
                  $decoded_date = urldecode($_GET['date']);
                  $DateTime = date_create_from_format('d/m/Y', $decoded_date);
                  if ($DateTime)
                        $start_date = $DateTime->getTimestamp();
            }

            $end_date = strtotime('+ 1 week', $start_date);

            $prev_date = strtotime('- 1 week', $start_date);
            ?>
            <script>

                  $(document).ready(function() {
                        var start_date = new Date('<?php echo date('r', $start_date) ?>');

                        $('#calendar').fullCalendar({
                              header: {
                                    left: '',
                                    center: 'title',
                                    right: 'prev,next'
                              },
                              /*year: 2014,*/
                              /*month: 2,*/
                              /*date: 2,*/
                              firstDay: 1,
                              dayClick: function(date, allDay, jsEvent, view) {
                                    var date_str = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
                                    console.log(date_str);
                                    window.location = "?date=" + encodeURIComponent(date_str);

                              },
                              dayRender: function(date, cell) {
                                    if (date.getDate() === start_date.getDate()
                                            && date.getMonth() === start_date.getMonth()) {
                                          cell.css("background-color", "blueviolet");
                                    }
                              }
                        });

                        $('#calendar').fullCalendar('gotoDate', start_date);

                  });

            </script>
            <style>

                  body {
                        margin-top: 40px;
                        text-align: center;
                        font-size: 14px;
                        font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                  }

                  #calendar {
                        width: 300px;
                        margin: 0 auto;
                  }

            </style>
      </head>
      <body>
            <div id='calendar'></div>
            <hr>
            <?php var_dump($start_date) ?>
            <?php var_dump(date('d/m/Y', $start_date)) ?>
            <div class="" style="background-color: red; height: 50px; width: 500px;">
                  <div class="" style="float: left;">
                        <a href="?date=<?php echo urlencode(date('d/m/Y', $prev_date)) ?>">prev week</a>
                        <a href="?date=<?php echo (date('d/m/Y', $prev_date)) ?>">prev week(no encode)</a>
                        <?php echo urlencode(date('d/m/Y', $prev_date)) ?>
                  </div>
                  <div class="" style="float: right;">
                        <a href="?date=<?php echo urlencode(date('d/m/Y', $end_date)) ?>">next week</a>
                        <?php echo urlencode(date('d/m/Y', $end_date)) ?>
                  </div>
            </div>
      </body>
</html>
