

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah User Login</h3>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <input type="hidden" name="Id" value="<?= $data->Id ?>">
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                <div class='form-group'>
                        <div class='col-sm-12 col-md-12'>
                            <label class='control-label'>Nama Lengkap<span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off value="<?= $data->Nama ?>" name='Nama' id='Nama' class='form-control FormInput' placeholder='Nama Lengkap' />
                        </div>
                        
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Username <span class='text-danger'>*</span></label>
                            <input type='text' readonly autocomplete=off value="<?= $data->Username ?>" name='Username' id='Username' class='form-control FormInput' placeholder='Username' />
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Password <span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off name='Password' id='Password' class='form-control FormInput' placeholder='Password' />
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <a href='<?= base_url('admins/login') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Kembali</a>
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
        var iForm = ["Nama","Username"];
        var iKet = ["Nama belum lengkap!. mohon dilengkapi","Username  belum lengkap!. mohon dilengkapi"];
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
        var iData = $("#FormData").serialize();
        $.ajax({
            type : "POST",
            url : "<?= base_url('admins/login/ubah') ?>",
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                if(result['status'] === true){
                    sukses("update", "User Login", "003");
                    setTimeout(() => {
                        location.href="<?= base_url('admins/login') ?>";
                    }, 1000);
                    StopLoad();
                }else{
                    error("003", 7, result['pesan']);
                    StopLoad();
                }
            },
            error : function(er){
                console.log(er);
            }

        })
    }
</script>