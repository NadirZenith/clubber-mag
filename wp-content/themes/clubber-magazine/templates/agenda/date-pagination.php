
<div class = "clearfix ml15 mt15 mb15 mr15 bold meddium">
        <ul>
                <li class = "fl">
                        <a href="<?php echo add_query_arg(array('date' => date('d-m-Y', $prev_date))); ?>"> <span class="meddium sc-3">&#8678; </span>Semana anterior</a>
                </li>
                <li class = "fr" >
                        <a href="<?php echo add_query_arg(array('date' => date('d-m-Y', $end_date))); ?>">Próxima semana<span class="meddium sc-3"> &#8680;</span></a>
                </li>
        </ul>
</div>
