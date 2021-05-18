<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Daftar Pertanyaan Yang Masuk</h3>
        <!-- <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <a href='<?= base_url('admins/paket/form-tambah') ?>' class='btn btn-sm btn-primary' title='Tambah data' data-toggle='tooltip'><i class='fa fa-plus'></i> Tambah</a>
            </div>
        </div> -->
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
                            <th>No Hp</th>
                            <th>Keterangan</th>
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
                "url": "<?php echo site_url('faq/get_data_faq')?>",
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
                "targets": [ 0,3,2,4], 
                "orderable": false, 
            },
            ],

        });
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