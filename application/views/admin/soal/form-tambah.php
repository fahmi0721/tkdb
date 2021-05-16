

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tambah  Soal</h3>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="Texts">
                            <label class='control-label'>Text</label>
                            <textarea name="Texts" id="Texts" rows="10" class="form-control FormInput" placeholder='Text'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="Soal">
                            <label class='control-label'>Soal</label>
                            <textarea name="Soal" id="Soal" rows="10" class="form-control FormInput" placeholder='Soal'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="A">
                            <label class='control-label'>Pilihan A</label>
                            <textarea name="A" id="A" rows="5" class="form-control FormInput" placeholder='Pilihan A'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="B">
                            <label class='control-label'>Pilihan B</label>
                            <textarea name="B" id="B" rows="5" class="form-control FormInput" placeholder='Pilihan B'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="C">
                            <label class='control-label'>Pilihan C</label>
                            <textarea name="C" id="C" rows="5" class="form-control FormInput" placeholder='Pilihan C'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="D">
                            <label class='control-label'>Pilihan D</label>
                            <textarea name="D" id="D" rows="5" class="form-control FormInput" placeholder='Pilihan D'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Paket Soal <span class='text-danger'>*</span></label>
                            <select name="KodePaket" id="KodePaket" class="form-control select-paket FormInput">
                                <option value="">..:: Pilih Paket ::..</option>
                                <?php foreach($paket_soal as $key => $iData){ ?>
                                    <option value="<?= $iData['Kode'] ?>"><?= $iData['Nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Kunci Jawaban<span class='text-danger'>*</span></label>
                            <div class="input-group">
                                <span class="input-group-addon">Jawaban</span>
                                <select name="KunciJawaban" id="KunciJawaban" class="form-control FormInput">
                                    <option value="">..:: Pilih Jawaban ::..</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                                <span class="input-group-addon">Bobot</span>
                                <input type="text" class="form-control FormInput" name='Bobot' id="Bobot" placegolder="Bobot">
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <a href='<?= base_url('admins/soal') ?>' class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Kembali</a>
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
        LoadEditor();
        ///LoadSearchForm();
    });

    function LoadEditor(){
        var iData = ["Texts","Soal",'A','B',"C","D"];
        for(var i=0; i < iData.length; i++){
            EditorText(iData[i]);
        }
    }

    function EditorText(Id) {
        $('#' + Id).wysihtml5({
            toolbar: {
                "font-styles": true, // Font styling, e.g. h1, h2, etc.
                "emphasis": true, // Italics, bold, etc.
                "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
                "html": true, // Button which allows you to edit the generated HTML.
                "link": false, // Button to insert a link.
                "image": true, // Button to insert an image.
                "color": false, // Button to change color of font
                "blockquote": true, // Blockquote
                "size": "sm",
                "format-code": true 
            }
        });
    }
    function ValidasiForm(){
        var iForm = ["Soal","A","B","C","D","KodePaket","KunciJawaban","Bobot"];
        var iKet = ["Soal belum lengkap!. mohon dilengkapi","Pilihan Jawaban A  belum lengkap!. mohon dilengkapi","Pilihan Jawaban B  belum lengkap!. mohon dilengkapi","Pilihan Jawaban C  belum lengkap!. mohon dilengkapi","Pilihan Jawaban D  belum lengkap!. mohon dilengkapi","Paket Soal belum lengkap!. mohon dilengkapi", "Kunci Jawaban belum lengkap!. mohon dilengkapi", "Bobot Paket belum lengkap!. mohon dilengkapi"];
        var no = 1;
        for(var i =0; i < iForm.length; i++){
            if($("#"+iForm[i]).val() == ""){ 
                StopLoad();
                error("005", no, iKet[i]); $("#"+iForm[i]).focus(); scrolltop();  return false; 
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
            url : "<?= base_url('admins/soal/tambah') ?>",
            data : iData,
            beforeSend : function(){
                StartLoad();
            },
            success : function(res){
                var result = JSON.parse(res);
                if(result['status'] === true){
                    sukses("insert", "Soal", "005");
                    $(".FormInput").val("");
                    var iData = ['Soal', 'A', "B", "C", "D","Texts"];
                    for(var i=0; i < iData.length; i++){
                        $('div[for="'+iData[i]+'"]').find('iframe').contents().find('.wysihtml5-editor').html(null);
                    }
                    scrolltop();
                    StopLoad();
                }else{
                    error("005", 7, result['pesan']);
                    StopLoad();
                }
            },
            error : function(er){
                console.log(er);
            }

        })
    }
</script>