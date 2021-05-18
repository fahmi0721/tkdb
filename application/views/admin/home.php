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





<script>
    $(document).ready(function(){
        load_data_rekap_tes();
    })


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
</script>