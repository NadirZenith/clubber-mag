
<div class="mt30">&nbsp;</div>

<div id="sticky">
      <div id="calendar" class="bg-50 block-5"></div>
      <?php
      /*    banners       */
      include_once 'banners/single-event-1.php';
      include_once 'banners/single-event-2.php';
      ?>
</div>

<?php
/*    FACEBOOK LIKE BOX       */
include_once 'facebook/like-box.php';
?>

<?php
$start_date = strtotime( "now" );
if ( isset( $_GET[ 'date' ] ) ) {
      $decoded_date = urldecode( $_GET[ 'date' ] );
      $DateTime = date_create_from_format( 'd-m-Y', $decoded_date );
      if ( $DateTime ) {
            $start_date = $DateTime->getTimestamp();
      }
}
?>
<script type="text/javascript">
      function updateQueryStringParameter(uri, key, value) {
            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
            var separator = uri.indexOf('?') !== -1 ? "&" : "?";
            if (uri.match(re)) {
                  return uri.replace(re, '$1' + key + "=" + value + '$2');
            }
            else {
                  return uri + separator + key + "=" + value;
            }
      }

      jQuery(document).ready(function($) {


            var start_date = new Date('<?php echo date( 'r', $start_date ) ?>');
            $('#calendar').fullCalendar({
                  header: {
                        left: '',
                        center: 'title',
                        right: 'prev,next'
                  },
                  firstDay: 1,
                  dayClick: function(date, allDay, jsEvent, view) {
                        var date_str = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                        var location = updateQueryStringParameter('<?php echo add_query_arg( NULL, NULL ); ?>', 'date', encodeURIComponent(date_str));
                        window.location = location;
                  },
                  dayRender: function(date, cell) {
                        if (date.getDate() === start_date.getDate()
                                && date.getMonth() === start_date.getMonth()) {
                              cell.css("background-color", "#666");
                        }
                  },
                  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                  monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                  dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            });
            $('#calendar').fullCalendar('gotoDate', start_date);
            $('.fc-button-prev span').click(function() {
                  var date = $('#calendar').fullCalendar('prev').fullCalendar('getDate');
                  var date_str = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                  var location = updateQueryStringParameter('<?php echo add_query_arg( NULL, NULL ); ?>', 'date', encodeURIComponent(date_str));
                  window.location = location;
                  /*alert('prev ' + date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());*/
                  return false;
            });
            $('.fc-button-next span').click(function() {
                  var date = $('#calendar').fullCalendar('next').fullCalendar('getDate');
                  var date_str = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
                  var location = updateQueryStringParameter('<?php echo add_query_arg( NULL, NULL ); ?>', 'date', encodeURIComponent(date_str));
                  window.location = location;
                  /*                  alert('next ' + date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear());*/
                  return false;
            });


      });


</script>
