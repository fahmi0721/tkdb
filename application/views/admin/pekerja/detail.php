<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Detail Peserta</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <a href='<?= base_url('admins/peserta/form-upload') ?>' class='btn btn-sm btn-info' title='Upload data' data-toggle='tooltip'><i class='fa fa-upload'></i> Import Peserta</a>
                <a href='<?= base_url('admins/peserta/form-tambah') ?>' class='btn btn-sm btn-primary' title='Tambah data' data-toggle='tooltip'><i class='fa fa-plus'></i> Tambah</a>
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
                            <th>Jabatan</th>
                            <th class='text-center'>Aksi</th>
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
                "url": "<?php echo site_url('admins/peserta/get_data_peserta')?>",
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
                "targets": [ 0,3,2 ], 
                "orderable": false, 
            },
            ],

        });
    }


    function HapusData(Id){
        var conf = confirm("Apakah anda yakin menghapus data ini?");
        if(conf){
            $.ajax({
                type : "GET",
                url : "<?= site_url('admins/peserta/hapus') ?>",
                data : "Id="+Id,
                beforeSend: function(){
                    StartLoad();
                },
                success : function(res){
                    var result = JSON.parse(res);
                    if(result['status'] === true){
                        sukses("delete", "Peserta", "001");
                        $("#proses").focus();
                        $('#TableData').DataTable().ajax.reload();
                        StopLoad();
                    }else{
                        error("001", 7, result['pesan']);
                        StopLoad();
                        $("#proses").focus();
                    }
                },
                error: function(er){
                    console.log(er);
                }
            })
        }else{
            return false;
        }
    }
</script>