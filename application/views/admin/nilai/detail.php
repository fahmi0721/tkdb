<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Detail Nilai TKDB</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <a href='<?= base_url('admins/nilai/form-nilai') ?>' class='btn btn-sm btn-success' title='Cek Nilai' data-toggle='tooltip'><i class='fa fa-cog'></i> Cek Nilai</a>
                <a href='<?= base_url('admins/nilai/form-tambah') ?>' class='btn btn-sm btn-primary' title='Generate Nilai' data-toggle='tooltip'><i class='fa fa-cog'></i> Generate Nilai</a>
            </div>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped display" id="TableData">
                    <thead>
                        <tr>
                            <th width="5px"><center>No</center></th>
                            <th>Peserta</th>
                            <th>Unit Kerja</th>
                            <th>Nilai</th>
                            <th class='text-center' width='10%'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="overlay LoadingState" >
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>


<script>

    $(document).ready(function () {
        getData();
    })

    function getData(){
        table = $('#TableData').DataTable({ 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo site_url('admins/nilai/get_data_peserta')?>",
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
                "targets": [ 0,3,4], 
                "orderable": false, 
            },
            ],

        });
    }

    function CekNilai(NoKtp){
        $.ajax({
            type : "POST",
            url : "<?= site_url('admins/nilai/intip_nilai') ?>",
            data : "Noktp="+NoKtp,
            beforeSend: function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                console.log(res);
                alert("Hasil tesnya : "+result['Nilai']+" ("+result['Hasil']+")");
                StopLoad();
            },
            error: function(er){
                console.log(er);
            }
        })
    }

    // function HapusData(Id){
    //     var conf = confirm("Apakah anda yakin menghapus data ini?");
    //     if(conf){
    //         $.ajax({
    //             type : "GET",
    //             url : "<?= site_url('admins/paket/hapus') ?>",
    //             data : "Id="+Id,
    //             beforeSend: function(){
    //                 StartLoad();
    //             },
    //             success : function(res){
    //                 var result = JSON.parse(res);
    //                 if(result['status'] === true){
    //                     sukses("delete", "Paket Soal", "002");
    //                     $("#proses").focus();
    //                     $('#TableData').DataTable().ajax.reload();
    //                     StopLoad();
    //                 }else{
    //                     error("002", 7, result['pesan']);
    //                     StopLoad();
    //                     $("#proses").focus();
    //                 }
    //             },
    //             error: function(er){
    //                 console.log(er);
    //             }
    //         })
    //     }else{
    //         return false;
    //     }
    // }
</script>