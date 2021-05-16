

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Gambar</h3>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Nama Gambar <span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off name='Nama' id='Nama' class='form-control FormInput' placeholder='Nama Gambar' />
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>File <span class='text-danger'>*</span></label>
                            <input type='file' accept=".jpg,.jpeg,.png" autocomplete=off name='Files' id='Files' class='form-control FormInput' placeholder='File' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12'>
                            <label class='control-label'>Keterangan</label>
                            <textarea name="Keterangan" id="Keterangan" rows="5" class="form-control FormInput" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <a href='<?= base_url('admins/gambar') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="overlay LoadingState" >
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>

<script>
    function ValidasiForm(){
        var iForm = ["Nama","Files"];
        var iKet = ["Nama Gambar belum lengkap!. mohon dilengkapi","Files belum lengkap!. mohon dilengkapi"];
        var no = 1;
        for(var i =0; i < iForm.length; i++){
            if($("#"+iForm[i]).val() == ""){ 
                StopLoad();
                error("001", no, iKet[i]); $("#"+iForm[i]).focus();  return false; 
            }
        }
    }

    $("#FormData").submit(function(e){
        e.preventDefault();
        if(ValidasiForm() != false){
            SubmitData();
        }
        
    });


    function SubmitData(){
        var iData = new FormData($("#FormData")[0]);
        $.ajax({
            type : "POST",
            url : "<?= base_url('admins/gambar/tambah') ?>",
            processData: false,
            contentType :false,
            chave: false,
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                if(result['status'] === true){
                    sukses("insert", "Paket Soal", "002");
                    $(".FormInput").val("");
                    StopLoad();
                }else{
                    error("002", 7, result['pesan']);
                    StopLoad();
                }
            },
            error : function(er){
                console.log(er);
            }

        })
    }
</script>