<!-- THis is the footer -->
    
    <div class="footer-copyright-area">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="footer-copy-right">
                            <p>© 2020 UCCIA | <a href="">UNIVERSITY OF CAPE COAST</a></p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>

<!-- jquery
		============================================ -->
        <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/notify.min.js"></script>

    <?php
      //die(EXTRAO);
      if(EXTRAO == "upload") {
        //die('Hi');
        echo "<script src='" . base_url() . "assets/js/bootstrap-fileupload.js'></script>";
        echo "<script src='" . base_url() . "assets/js/tab.js'></script>";
      } else if(EXTRAO == "duallist") {
        echo "<script src='" . base_url() . "assets/js/duallistbox/jquery.bootstrap-duallistbox.js'></script>";
        echo "<script src='" . base_url() . "assets/js/duallistbox/duallistbox.active.js'></script>";
      } else if(EXTRAO == "dash") {
        echo "<script src='" . base_url() . "assets/js/c3-charts/d3-5.8.2.min.js' charset='utf-8'></script>";
        echo "<script src='" . base_url() . "assets/js/c3-charts/c3.min.js'></script>";
        echo "<script src='" . base_url() . "assets/js/calendar/moment.min.js'></script>";
        echo "<script src='" . base_url() . "assets/js/calendar/fullcalendar.min.js'></script>";
        echo "<script src='" . base_url() . "assets/js/calendar/fullcalendar-active.js'></script>";
      }
    ?>

    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="<?php echo base_url();?>assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/scrollbar/mCustomScrollbar-active.js"></script>
    <!-- metisMenu JS
		============================================ -->
    <script src="<?php echo base_url();?>assets/js/metisMenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/metisMenu/metisMenu-active.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery.meanmenu.js"></script>
    <!-- plugins JS
		============================================ -->
    <script src="<?php echo base_url();?>assets/js/plugins.js"></script>
    <!-- main JS
		============================================ -->
    <script src="<?php echo base_url();?>assets/js/main.js"></script>

    <?php
      if(EXTRAO == "dash") {
        echo "<script>
                var chart = c3.generate({
                  bindto: '#exam-props-chart',

                  size: {
                    height: 265,
                    width: 220
                  },

                  data: {
                      columns: [
                          ['data1', 30],
                          ['data2', 120],
                      ],

                      type : 'pie',

                      names: {
                        data1: 'Exams Written',
                        data2: 'Exams Remaining'
                      },

                      colors: {
                        data1: '#DFCFBE',
                        data2: '#98B4D4'
                      }
                  }
                });
          </script>
        ";
      }
    ?>
</body>

</html>