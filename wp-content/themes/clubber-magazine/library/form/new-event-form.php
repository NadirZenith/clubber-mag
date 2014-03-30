      <div style="background-color: red; height: 10px; width:100%; clear: both"></div>

<style type="text/css">
      .error{
            padding: 5px 3px;
            border: 1px solid red;
            color: red;
            border-radius: 3px;
      }

      .bg-error{
            background-color: rgba(255, 0, 0, 0.30);
      }

      .success{
            padding: 5px 9px;
            border: 1px solid green;
            color: green;
            border-radius: 3px;
      }

      form span{
            color: red;
      }
</style>

<?php
if (!empty($error_response)) {
      ?>
      <ul ><?php
      foreach ($error_response as $message) {
            echo $message;
      }
      ?>
      </ul><?php
}
?>
<div class="cb"></div>
<form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data">
      <ul class="col-2-4 fl">

            <!-- event_title-->
            <li class="mt15 col-4-4 bg-50 block-5">
                  <label for="event_title" class="col-3-4 ml5 pt5 pb5 " style="display:block">Titulo del evento: <span>*</span> <br>
                        <input type="text" name="event_title" class="mt5 mr15" value="<?php echo esc_attr($_POST['event_title']); ?>">
                  </label>
            </li>
            <!-- event_description-->
            <li class="mt15 col-4-4 bg-50 block-5">
                  <label for="event_description" class="col-3-4 ml5 pt5 pb5" style="display:block">Descripción: <span>*</span> <br>
                        <textarea name="event_description" id="event_description" class="mt5"  rows="10" cols="50"><?php echo esc_attr($_POST['event_description']); ?></textarea>
                  </label>
            </li>
            <!-- event_begin_date-->
            <li class="mt15 fl col-2-4 bg-50 block-5" >
                  <label for="event_begin_date" class="col-2-4 ml5 pt5 pb5" style="display:block">Fecha inicio evento: <span>*</span> <br>
                        <input name="event_begin_date" id="event_begin_date" type="text" class="mt5" value="<?php echo esc_attr($_POST['event_begin_date']); ?>">
                  </label>
            </li>
            <!-- event_price-->
            <li class="mt15 fl col-2-4 bg-50 block-5" style="">
                  <label for="event_price" class="col-2-4 ml5 pt5 pb5" style="display:block">Precio evento: <span>*</span> <br>
                        <input name="event_price" id="event_price" type="text" class="mt5" value="<?php echo esc_attr($_POST['event_price']); ?>">
                  </label>
            </li>
      </ul>
      <ul class="col-2-4 fl">
            <!-- event_club_name-->
            <li class="mt15 col-4-4 bg-50 block-5">
                  <label for="event_club_name" class="col-3-4 ml5 pt5 pb5 " style="display:block">Nombre del club: <span>*</span> <br>
                        <input type="text" name="event_club_name" class="mt5 mr15" value="<?php echo esc_attr($_POST['event_club_name']); ?>">
                  </label>
            </li>
            <!-- event_club_address-->
            <li class="mt15 col-4-4 bg-50 block-5">
                  <label for="event_club_address" class="col-3-4 ml5 pt5 pb5 " style="display:block">Dirección del clulb: <span>*</span> <br>
                        <input type="text" name="event_club_address" class="mt5 mr15" value="<?php echo esc_attr($_POST['event_club_address']); ?>">
                  </label>
            </li>
            <!-- event_flyer-->
            <li class="mt15 fl col-2-4 bg-50 block-5">
                  <label for="event_flyer" class="ml5 pt5 pb5" style="display:block">Flyer: <span>*</span> <br>
                        <input name="event_flyer" id="event_flyer" type="file" accept="image/*" value="<?php echo esc_attr($_POST['event_flyer']); ?>" class="mt5">
                  </label>
            </li>
            <!-- event_flyer_full-->
            <li class="mt15  fl col-2-4 bg-50 block-5">
                  <label for="event_flyer_full" class="ml5 pt5 pb5" style="display:block">Espalda flyer:<br>
                        <input name="event_flyer_full" id="event_flyer_full" type="file" accept="image/*" value="<?php echo esc_attr($_POST['event_flyer_full']); ?>" class="mt5">
                  </label>
            </li>
            <!-- event_city-->
            <li class="mt15 fl col-2-4 bg-50 block-5">
                  <label for="event_city" class="ml5 pt5 pb5 col-3-4" style="display:block;">Ciudad: <span>*</span> <br>
                        <select name="event_city" id="event_city" class="mt5" >
                              <option value="spain" disabled>España</option>
                              <?php
                              $terms = get_terms("es_city_type", array('hide_empty' => 0));
                              if (count($terms) > 0) {
                                    foreach ($terms as $term) {
                                          ?>
                                          <option value="<?php echo $term->term_id ?>" 
                                          <?php
                                          if ($fv['event_city'] == $term->term_id) {
                                                echo 'selected="true"';
                                          }
                                          ?>
                                                  > - - <?php echo $term->name ?></option>
                                                  <?php
                                            }
                                      }
                                      ?>
                        </select>
                  </label>
            </li>
            <!-- event_type-->
            <li class="mt15 pb5 fl col-2-4 bg-50 block-5" style="">
                  <label class="ml5 pt5" style="display:block">Tipo de evento
                        <ul class="pt5 " id="input_2_9">
                              <?php
                              $event_types = array(
                                  'party' => 'Party',
                                  'festival' => 'Festival'
                              );
                              $fv['event_type'] = (empty($fv['event_type'])) ? 'party' : $fv['event_type'];
                              foreach ($event_types as $value => $name) {
                                    ?>
                                    <li class="col-1-4 fl">
                                          <input name="event_type" type="radio" <?php echo ($fv['event_type'] == $value) ? 'checked="checked"' : null; ?> value="<?php echo $value ?>" id="event_type_<?php echo $value ?>" tabindex=""> 
                                          <label for="event_type_<?php echo $value ?>"><?php echo $name ?></label>
                                    </li>
                                    <?php
                              }
                              ?>
                        </ul>
                  </label>
            </li>
            <!-- event_is_featured-->
            <!--
            <li class="mt15 fl col-2-4 bg-50 block-5" style="">
                  <label for="event_is_featured" class="ml5">Featured:<br>
                        <input id="event_is_featured" type="checkbox" name="event_is_featured" class="mt5">
                  </label>
            </li>
            -->
            <!--<li class="cb" style=""></li>-->
            <li class="mt15 cl fl col-2-4 bg-50 block-5">
                  <label for="human_verification" class="ml5 pt5 pb5" style="display:block">Human Verification: <span>*</span> <br>
                        <input name="human_verification" type="text" style="width: 60px;" class="mt5"> + 3 = 5
                  </label>
            </li>

            <li class="mt15 ml15 fl ">
                  <input type="hidden" name="submitted" value="1">
                  <input type="submit">
            </li>
      </ul>
</form>
<script type="text/javascript">
      jQuery(document).ready(function($) {
            $('#event_begin_date').datetimepicker({
                  format: 'd/m/Y H:i',
                  minDate: 0
            });
      });
</script>

