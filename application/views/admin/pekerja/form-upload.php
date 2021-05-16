

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Upload Peserta</h3>
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
                            <label class='control-label'>File <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='file' autocomplete=off name='file' id='file' class='form-control FormInput' placeholder='File' />
                                <span class="input-group-addon"><i class='fa fa-upload'></i></span>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <a href='<?= base_url('admins/peserta') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Batal</a>
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
        var iForm = ["file"];
        var iKet = ["File belum lengkap!. mohon dilengkapi"];
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
            url : "<?= base_url('admins/peserta/import_excel') ?>",
            processData : false,
            contentType : false,
            chace : false,
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                if(result['status'] === true){
                    sukses("insert", "Peserta", "001");
                    $(".FormInput").val("");
                    $(".select-unit-kerja").trigger('change');
                    StopLoad();
                }else{
                    error("001", 7, result['pesan']);
                    StopLoad();
                }
            },
            error : function(er){
                console.log(er);
            }

        })
    }
</script>