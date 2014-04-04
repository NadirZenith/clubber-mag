


<div class="mt30">&nbsp;</div>

<div id="calendar" class="bg-50 block-5"></div>

<script type="text/javascript">
      jQuery(document).ready(function($) {
<?php
$start_date = strtotime("now");
if (isset($_GET['date'])) {
      $decoded_date = urldecode($_GET['date']);
      $DateTime = date_create_from_format('d/m/Y', $decoded_date);
      if ($DateTime) {
            $start_date = $DateTime->getTimestamp();
      }
}
?>
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

                        var location = updateQueryStringParameter('<?php echo get_post_type_archive_link('event'); ?>', 'date', encodeURIComponent(date_str));
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

      });

</script>


<?php
/*    BANNER      */
/* include_once 'banners/archive-event.php'; */
/* include_once 'banners/right-2-300-300.php'; */

/*    FACEBOOK LIKE BOX       */
include_once 'banners/right-2-300-300.php';
include_once 'facebook/like-box.php';

/* include_once 'facebook/facepile.php'; */
?>