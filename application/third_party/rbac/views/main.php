<?php $this->load->view("header"); ?>
<div style="position: relative; top:10px; left: 250px;">
          <?php echo $this->output->get_output();?>
        </div><!--/span-->
    <?php $this->load->view("leftgame", array("menu" => $this->get_menu)); ?>
    </body>
</html>
        