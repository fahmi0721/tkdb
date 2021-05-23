

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Generate Nilai</h3>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12'>
                            <label class='control-label'>Unit Kerja <span class='text-danger'>*</span></label>
                            <select name="UnitKerja" id="UnitKerja" class='form-control FormInput select-unit-kerja'>
                                <option value="">..:: Pilih Unit Kerja ::..</option>
                                <?php foreach($UnitKerja as $dt){ ?>
                                <option value="<?= $dt ?>"><?= $dt ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <a href='<?= base_url('admins/nilai') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Kembali</a>
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
    $(document).ready(function(){
        SelectForm();
    })
     function SelectForm() {
        
        $('.select-unit-kerja').select2({
            allowClear: true,
            ballowClear: true,
            theme: "bootstrap",
            placeholder: 'Pilih Unit Kerja',
        });
    }

    function ValidasiForm(){
        var iForm = ["UnitKerja"];
        var iKet = ["Unit Kerja belum lengkap!. mohon dilengkapi"];
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
            url : "<?= base_url('admins/nilai/tambah') ?>",
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                console.log(result)
                if(result['status'] === true){
                    sukses("insert", "Generate Nilai", "002");
                    $(".FormInput").val("");
                    $(".select-unit-kerja").trigger("change");
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