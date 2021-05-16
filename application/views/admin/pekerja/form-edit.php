

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Ubah Peserta</h3>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <input type="hidden" name='Id' value="<?= $Peserta->Id ?>" name='Id' />
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>No KTP <span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off value="<?= $Peserta->Noktp ?>" name='NoKtp' id='NoKtp' class='form-control FormInput' placeholder='No KTP' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Nama Lengkap <span class='text-danger'>*</span></label>
                            <input type='text' value="<?= $Peserta->Nama ?>" autocomplete=off name='Nama' id='Nama' class='form-control FormInput' placeholder='Nama Lengkap' />
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Tanggal Lahir <span class='text-danger'>*</span></label>
                            <input type='text' value="<?= $Peserta->TglLahir ?>" autocomplete=off name='TglLahir' id='TglLahir' class='form-control FormInput' placeholder='Tanggal Lahir' />
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Jabatan <span class='text-danger'>*</span></label>
                            <input type='text' autocomplete=off value="<?= $Peserta->Jabatan ?>" name='Jabatan' id='Jabatan' class='form-control FormInput' placeholder='Jabatan' />
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Unit Kerja <span class='text-danger'>*</span></label>
                            <select name="UnitKerja" id="UnitKerja" class='form-control FormInput select-unit-kerja'>
                                <option value="">..:: Pilih Unit Kerja ::..</option>
                                <?php foreach($UnitKerja as $dt){ 
                                    $sel = $Peserta->UnitKerja == $dt ? "selected" : "";
                                ?>
                                <option value="<?= $dt ?>" <?= $sel ?>><?= $dt ?></option>
                                <?php } ?>
                            </select>
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
    $(document).ready(function () {
        SelectForm();
    })
    
    $("#TglLahir").datepicker({ "dateFormat": "yy-mm-dd", "autoclose": true,changeMonth: true,changeYear: true });

    
    function SelectForm() {
        
        $('.select-unit-kerja').select2({
            allowClear: true,
            ballowClear: true,
            theme: "bootstrap",
            placeholder: 'Pilih Unit Kerja',
        });
    }

    function ValidasiForm(){
        var iForm = ["NoKtp","Nama","TglLahir","Jabatan","UnitKerja"];
        var iKet = ["No KTP belum lengkap!. mohon dilengkapi","Nama Lengkap belum lengkap!. mohon dilengkapi","Tanggal Lahir belum lengkap!. mohon dilengkapi","Jabatan belum lengkap!. mohon dilengkapi","Unit Kerja belum dipilih!. mohon dilengkapi"];
        var no = 1;
        for(var i =0; i < iForm.length; i++){
            if($("#"+iForm[i]).val() == ""){ 
                
                if(iForm[i] == "UnitKerja"){
                    $(".select-unit-kerja").select2().on('select2-focus', function(){
                        $(this).select2('open');
                    });
                }
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
            url : "<?= base_url('admins/peserta/ubah') ?>",
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                if(result['status'] === true){
                    sukses("update", "Peserta", "001");
                    $(".FormInput").val("");
                    $(".select-unit-kerja").trigger('change');
                    setTimeout(() => {
                        location.href =  "<?= base_url('admins/peserta/') ?>";
                    }, 1000);
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