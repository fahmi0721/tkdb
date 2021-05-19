<div class='row'>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-red">
        <span class="info-box-icon"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">BELUM TES</span>
            <span class="info-box-number" id="BelumTes">0</span>

            <div class="progress">
            <div class="progress-bar" id="BelumTesProgresBar" style="width: 0%"></div>
            </div>
                <span class="progress-description">
                <span id="BelumTesPersen">0</span>% dari <span class='Total'>0</span> Orang
                </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-blue">
        <span class="info-box-icon"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">TES BERLANGSUNG</span>
            <span class="info-box-number" id="ProgressTes">0</span>

            <div class="progress">
            <div class="progress-bar" id="ProgressTesProgresBar" style="width: 0%"></div>
            </div>
                <span class="progress-description">
                <span id="ProgressTesPersen"></span>% dari <span class='Total'>0</span> Orang
                </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
            <span class="info-box-text">TES SELESAI</span>
            <span class="info-box-number" id="FinishTes">0</span>

            <div class="progress">
            <div class="progress-bar" id="FinishTesProgresBar" style="width: 0%"></div>
            </div>
                <span class="progress-description">
                <span id="FinishTesPersen"></span>% dari <span class='Total'>0</span> Orang
                </span>
        </div>
        <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>


<div class="row">
    <div class="col-sm-6 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Nama Belum Tes</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped display" id="TableData1">
                        <thead>
                            <tr>
                                <th width="5px"><center>No</center></th>
                                <th>Peserta</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="overlay LoadingState" >
                <i class="fa fa-refresh fa-spin"></i>   
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Tes Berlangsung</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped display" id="TableData2">
                        <thead>
                            <tr>
                                <th width="5px"><center>No</center></th>
                                <th>Peserta</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="overlay LoadingState" >
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Tes Selesai</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped display" id="TableData3">
                        <thead>
                            <tr>
                                <th width="5px"><center>No</center></th>
                                <th>Peserta</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="overlay LoadingState" >
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>




<script>
    $(document).ready(function(){
        load_data_rekap_tes();
        getData1();
        getData2();
        getData3();
        setInterval(() => {
            load_data_rekap_tes();
        }, 5000);

        setInterval(() => {
            reloadAjax();
        }, 50000);
    })

    function reloadAjax(){
        var table1 = $('#TableData1').DataTable();
        var table2 = $('#TableData2').DataTable();
        var table2 = $('#TableData2').DataTable();
        table1.ajax.reload();
        table2.ajax.reload();
        table3.ajax.reload();
    }

    function load_data_rekap_tes(){
        $.ajax({
            type : "POST",
            url : "<?= base_url("admins/home/load_data_rekap_tes") ?>",
            success: function(res){
                var iData = JSON.parse(res);
                /** Waiting */
                var persen = (iData['waiting']/iData['total'])*100;
                persen = persen.toFixed(2);
                $("#BelumTes").html(iData['waiting']);
                $("#BelumTesProgresBar").removeAttr("style");
                $("#BelumTesProgresBar").attr("style","width: "+persen+"%")
                $("#BelumTesPersen").html(persen);

                /** Berlangsung */
                var persen = (iData['progress']/iData['total'])*100;
                persen = persen.toFixed(2);
                $("#ProgressTes").html(iData['progress']);
                $("#ProgressTesProgresBar").removeAttr("style");
                $("#ProgressTesProgresBar").attr("style","width: "+persen+"%")
                $("#ProgressTesPersen").html(persen);

                /** FInish */
                var persen = (iData['finish']/iData['total'])*100;
                persen = persen.toFixed(2);
                $("#FinishTes").html(iData['finish']);
                $("#FinishTesProgresBar").removeAttr("style");
                $("#FinishTesProgresBar").attr("style","width: "+persen+"%")
                $("#FinishTesPersen").html(persen);





                $(".Total").html(iData['total']);
            },
            error :function(er){
                console.log(er);
            }
        })
    }



    function getData1(){
        table = $('#TableData1').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo site_url('admins/home/get_data_peserta_belum_tes')?>",
                "type": "POST",
                async: true,
                error: function (xhr, error, code)
                {
                    $("#proses").html(xhr.responseText);
                    console.log(xhr);
                }
            },
            "fnDrawCallback": function (oSettings) {
                $("[data-toggle='tooltip']").tooltip();
            },
            
            "columnDefs": [
            { 
                "targets": [ 0], 
                "orderable": false, 
            },
            ],

        });
    }

    function getData2(){
        table = $('#TableData2').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo site_url('admins/home/get_data_peserta_berlangsung_tes')?>",
                "type": "POST",
                async: true,
                error: function (xhr, error, code)
                {
                    $("#proses").html(xhr.responseText);
                    console.log(xhr);
                }
            },
            "fnDrawCallback": function (oSettings) {
                $("[data-toggle='tooltip']").tooltip();
            },
            
            "columnDefs": [
            { 
                "targets": [ 0], 
                "orderable": false, 
            },
            ],

        });
    }

    function getData3(){
        table = $('#TableData3').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo site_url('admins/home/get_data_peserta_selesai_tes')?>",
                "type": "POST",
                async: true,
                error: function (xhr, error, code)
                {
                    $("#proses").html(xhr.responseText);
                    console.log(xhr);
                }
            },
            "fnDrawCallback": function (oSettings) {
                $("[data-toggle='tooltip']").tooltip();
            },
            
            "columnDefs": [
            { 
                "targets": [ 0], 
                "orderable": false, 
            },
            ],

        });
    }
</script>