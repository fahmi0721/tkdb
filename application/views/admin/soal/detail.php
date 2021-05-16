<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Detail Soal</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <a href='<?= base_url('admins/soal/form-tambah') ?>' class='btn btn-sm btn-primary' title='Tambah data' data-toggle='tooltip'><i class='fa fa-plus'></i> Tambah</a>
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
                            <th>Deskripsi</th>
                            <th width="10%" class='text-center'>Soal</th>
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

<div class='modal fade in' id='modal' data-keyboard="false" data-backdrop="static" tabindex='0' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h5 class="modal-title">Detail Data</h5>
</div>
<div class='modal-body'>
    <div id="proses_modal"></div>
    

</div>
</div>
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
                "url": "<?php echo site_url('admins/soal/get_data_peserta')?>",
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
                "targets": [ 0,3,2], 
                "orderable": false, 
            },
            ],

        });
    }

    function DetailDataSoal(str){
        jQuery("#modal").modal('show', { backdrop: 'static' });
        var iData = atob(str);
        var c = iData.substring(0,1)
        if(c == "{"){
            iData = JSON.parse(iData);
            var html = "<p>A = "+iData['A'].replace(/(<([^>]+)>)/gi, "")+"</p>";
            html += "<p>B = "+iData['B'].replace(/(<([^>]+)>)/gi, "")+"</p>";
            html += "<p>C = "+iData['C'].replace(/(<([^>]+)>)/gi, "")+"</p>";
            html += "<p>D = "+iData['D'].replace(/(<([^>]+)>)/gi, "")+"</p>";
            $("#proses_modal").html(html);
        }else{
            $("#proses_modal").html(iData);
        }
    }


    function HapusData(Id){
        var conf = confirm("Apakah anda yakin menghapus data ini?");
        if(conf){
            $.ajax({
                type : "GET",
                url : "<?= site_url('admins/soal/hapus') ?>",
                data : "Id="+Id,
                beforeSend: function(){
                    StartLoad();
                },
                success : function(res){
                    var result = JSON.parse(res);
                    if(result['status'] === true){
                        sukses("delete", "Soal", "005");
                        $("#proses").focus();
                        $('#TableData').DataTable().ajax.reload();
                        StopLoad();
                    }else{
                        error("005", 7, result['pesan']);
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