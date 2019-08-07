
</div>
        <!-- ./page-wrapper -->
        <!-- Preloader -->
        <div id="preloader">
            <div class="preloader-position">
                <div class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-teal">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Preloader -->

        <script type="text/javascript">
          function exportExcel() {
        alasql('SELECT * INTO XLSX("Reports.xlsx",{headers:true}) \
                    FROM HTML(".table",{headers:true})');
    }


        </script>

        <!-- Start Core Plugins
             =====================================================================-->
        <!-- jQuery -->
        <script type="text/javascript" src="<?=base_url()?>/assets/web/js/calculator.js"></script>
        <script src="<?= base_url() ?>assets/web/plugins/jQuery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <!-- jquery-ui -->
        <script src="<?= base_url() ?>assets/web/plugins/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?= base_url() ?>assets/web/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <!-- materialize  -->
        <script src="<?= base_url() ?>assets/web/plugins/materialize/js/materialize.min.js" type="text/javascript"></script>
        <!-- metismenu-master -->
        <script src="<?= base_url() ?>assets/web/plugins/metismenu-master/dist/metisMenu.min.js" type="text/javascript"></script>
        <!-- SlimScroll -->
        <script src="<?= base_url() ?>assets/web/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- m-custom-scrollbar -->
        <script src="<?= base_url() ?>assets/web/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>
        <!-- scroll -->
        <script src="<?= base_url() ?>assets/web/plugins/simplebar/dist/simplebar.js" type="text/javascript"></script>
        <!-- custom js -->
        <script src="<?= base_url() ?>assets/web/dist/js/custom.js" type="text/javascript"></script>


        
        <!-- End Core Plugins
             =====================================================================-->
        <!-- Start Page Lavel Plugins
             =====================================================================-->
        <!-- Sparkline js -->
        <script src="<?= base_url() ?>assets/web/plugins/sparkline/sparkline.min.js" type="text/javascript"></script>
        <!-- Counter js -->
        <script src="<?= base_url() ?>assets/web/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <!-- ChartJs JavaScript -->
        <script src="<?= base_url() ?>assets/web/plugins/chartJs/Chart.min.js" type="text/javascript"></script>
        <!-- Monthly js -->
        <script src="<?= base_url() ?>assets/web/plugins/monthly/monthly.js" type="text/javascript"></script>

        <!-- End Page Lavel Plugins
             =====================================================================-->
        <!-- Start Theme label Script
             =====================================================================-->
        <!-- main js-->
        <script src="<?= base_url() ?>assets/web/dist/js/main.js" type="text/javascript"></script>

        <!-- CK Editor -->
        <script src="<?=base_url()?>assets/web/js/ckeditor/ckeditor.js" type="text/javascript"></script>
        
        <script type="text/javascript">

            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor');
                //bootstrap WYSIHTML5 - text editor
                $(".textarea").wysihtml5();
            });
        </script>
        <!-- End Theme label Script
             =====================================================================-->
        <script>
            $(document).ready(function () {
                "use strict";
                // Message
                function slscroll() {
                    $('.chat_list , .activity-list , .message_inner').slimScroll({
                        size: '3px',
                        height: '320px',
                        allowPageScroll: true,
                        railVisible: true
                    });
                }
                slscroll();
                function chatscroll() {
                    $('.chat_list').slimScroll({
                        size: '3px',
                        height: '290px'
                    });
                }
                chatscroll();

                //monthly calender
                $('#m_calendar').monthly({
                    mode: 'event',
                    //jsonUrl: 'events.json',
                    //dataType: 'json'
                    xmlUrl: 'events.xml'
                });

                //panel refresh
                $.fn.refreshMe = function (opts) {
                    var $this = this,
                            defaults = {
                                ms: 1500,
                                started: function () {},
                                completed: function () {}
                            },
                            settings = $.extend(defaults, opts);

                    var panelToRefresh = $this.parents('.panel').find('.refresh-container');
                    var dataToRefresh = $this.parents('.panel').find('.refresh-data');
                    var ms = settings.ms;
                    var started = settings.started;     //function before timeout
                    var completed = settings.completed; //function after timeout

                    $this.click(function () {
                        $this.addClass("fa-spin");
                        panelToRefresh.show();
                        started(dataToRefresh);
                        setTimeout(function () {
                            completed(dataToRefresh);
                            panelToRefresh.fadeOut(800);
                            $this.removeClass("fa-spin");
                        }, ms);
                        return false;
                    });
                };

                $(document).ready(function () {
                    $('.refresh, .refresh2').refreshMe({
                        started: function (ele) {
                            ele.html("Getting new data..");
                        },
                        completed: function (ele) {
                            ele.html("This is the new data after refresh..");
                        }
                    });
                });


                //line chart
                var ctx = document.getElementById("lineChart");
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: date,
                        datasets: [{
                                label: "Enroll",
                                borderColor: "#73879C",
                                borderWidth: "1",
                                backgroundColor: "#73879C",
                                data: E_status
                            }, {
                                label: "Identification",
                                borderColor: "rgba(26, 187, 156, 0.64)",
                                borderWidth: "1",
                                backgroundColor: "rgba(26, 187, 156, 0.64)",
                                pointHighlightStroke: "rgba(26, 187, 156, 0.64)",
                                data: I_status
                            }]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }

                    }
                });



                //bar chart  Month
                var bar = document.getElementById("bar");
                var myChart = new Chart(bar, {
                    type: 'bar',
                    data: {
                        labels: Mdate,
                        datasets: [{
                                label: "Enroll",
                                borderColor: "#FF6E33",
                                borderWidth: "1",
                                backgroundColor: "#FF6E33",
                                data: MI_status
                            }, {
                                label: "Identification",
                                borderColor: "#FFC133",
                                borderWidth: "1",
                                backgroundColor: "#FFC133",
                                pointHighlightStroke: "rgba(26, 187, 156, 0.64)",
                                data: M_status
                            }]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }

                    }
                });

            });
        </script>
    </body>


</html>
