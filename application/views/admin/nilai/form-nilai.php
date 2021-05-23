

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Cek Jawaban Peserta</h3>
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
                            <label class='control-label'>Peserta <span class='text-danger'>*</span></label>
                            <select name="Noktp" id="Noktp" class='form-control FormInput select-ktp'>
                                <option value="">..:: Pilih Peserta ::..</option>
                                <?php foreach($Peserta as $dt){ ?>
                                <option value="<?= $dt['Noktp'] ?>">[<?= $dt['Noktp'] ?>] <?= $dt['Nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Cek Jawaban</button>
                                <a href='<?= base_url('admins/nilai') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class='table table-bordered table-striped'>
                                <thead>
                                    <tr>
                                        <th class='text-center' width='5%'>No</th>
                                        <th>Kode Soal</th>
                                        <th>Bobot</th>
                                        <th>Kunci Jawaban</th>
                                        <th>Jawaban Peserta</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody id="Result"></tbody>
                                <tfood>
                                    <tr>
                                        <th colspan='5'>TOTAL NILAI</th>
                                        <th id="Total"></th>
                                    </tr>
                                </tfood>
                            </table>
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
        
        $('.select-ktp').select2({
            allowClear: true,
            ballowClear: true,
            theme: "bootstrap",
            placeholder: 'Pilih Peserta',
        });
    }


    function ValidasiForm(){
        var iForm = ["Noktp"];
        var iKet = ["Peserta belum lengkap!. mohon dilengkapi"];
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
            url : "<?= base_url('admins/nilai/detail_jawaban') ?>",
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                console.log(result);
                var html ="";
                var No=1;
                var nliai;
                var Total = 0;
                for(var i=0; i < result['Soal'].length; i++){
                    var iSoal = result['Soal'][i];
                    var KunciJawaban = atob(iSoal['KunciJawaban']);
                    var Peserta = result['Jawaban'];
                    var jwb = Peserta[iSoal['Kode']]['Jawaban'];
                    var trs = KunciJawaban == jwb ? "class='success'" : "class='danger'";
                    html +="<tr class='danger'>";
                        html +="<td class='text-center'>"+No+"</td>";
                        html +="<td>"+iSoal['Kode']+"</td>";
                        html +="<td>"+iSoal['Bobot']+"</td>";
                        html +="<td>"+KunciJawaban+"</td>";
                        html +="<td>"+jwb+"</td>";
                        nliai = KunciJawaban == jwb ? iSoal['Bobot'] : 0;
                        html +="<td>"+nliai+"</td>";
                        Total = parseInt(Total) + parseInt(nliai);
                    html +="</tr>";
                    No++;
                }
                $("#Result").html(html);
                $("#Total").html(Total);
                StopLoad();
            },
            error : function(er){
                console.log(er);
            }

        })
    }
</script>