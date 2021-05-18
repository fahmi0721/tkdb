

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah Jadwal TKDB</h3>
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
                            <label class='control-label'>Tanggal Mulai <span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off name='Dari' id='Dari' class='form-control FormInput' placeholder='Tanggal Mulai' />
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Tanggal Selesai <span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off name='Sampai' id='Sampai' class='form-control FormInput' placeholder='Tanggal Selesai' />
                        </div>
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <a href='<?= base_url('admins/jadwal') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Kembali</a>
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

    $(document).ready(function () {
        SelectForm();
        $("#Dari,#Sampai").datepicker({ "format": "yyyy-mm-dd", "autoclose": true,changeMonth: true,changeYear: true });

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
        var iForm = ["UnitKerja","Dari","Sampai"];
        var iKet = ["Unit Kerja belum lengkap!. mohon dilengkapi","Tanggal Mulai belum lengkap!. mohon dilengkapi","Tanggal Selesai belum lengkap!. mohon dilengkapi"];
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
            url : "<?= base_url('admins/jadwal/tambah') ?>",
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                if(result['status'] === true){
                    sukses("insert", "Jadwal TKDB", "006");
                    $(".FormInput").val("");
                    StopLoad();
                }else{
                    error("006", 7, result['pesan']);
                    StopLoad();
                }
            },
            error : function(er){
                console.log(er);
            }

        })
    }
</script>