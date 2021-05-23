<?php 

    
?>
<div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?= base_url("public/img/") ?><?= $data->Jk ?>-avatar.jpg" alt="<?= base_url("public/img/") ?><?= $data->Jk ?>-avatar.jpg">

              <h4 class="text-center"><?= $data->Nama ?></h4>

              <p class="text-muted text-center"><?= $data->Jabatan ?></p>
              <p class="text-muted text-center"><?= $data->TglLahir ?></p>
              <?php if($tkdb->StatusUjian == "0"): ?>
              <a class='btn btn-sm btn-primary btn-block' href='javascript:void(0)' onclick="MulaiTKDB()"><i class='fa fa-check'></i> Mulai Tes</a>
              <?php elseif($tkdb->StatusUjian == "1"): ?>
              <p class='text-center'><span class="label label-success" style='font-size:14pt' id="clock">00:00:00</span></p>
              <hr />
            <div class='row'>
                <?php
                    $master_soal = $this->session->userdata("master_soal");
                    $master_jawaban = $this->session->userdata("master_jawaban");
                    $act = "btn-default";
                    $posisi = isset($_GET['Id']) ? $_GET['Id'] : 1;
                    for($i=0; $i<count($master_soal); $i++):
                    $no_soal = $i+1;
                    if($posisi == $no_soal):
                        $act = "btn-info";
                    elseif(array_key_exists($master_soal[$i]['KodeSoal'],$master_jawaban)):
                        $act = "btn-success";
                    else:
                        $act = "btn-default";
                    endif;
                ?>
                <div class="col-sm-3 col-xs-2" style='margin-bottom:5px'><a href="<?= base_url("home") ?>?Id=<?= $no_soal; ?>" class='btn <?= $act ?> btn-xs'><b><?= sprintf("%02d",$no_soal) ?></b></a></div>
                <?php 
                endfor; ?>
            </div>

            <?php else: ?>
                <p class='text-center'><span class="label label-success" >Tes telah selesai</span></p>
            <?php endif; ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">TKDB ONLINE</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-key margin-r-5"></i> Nomor Peserta</strong>

              <p class="text-muted"><?= $data->NomorPeserta ?></p>
              <hr>
              <strong><i class="fa fa-map-marker margin-r-5"></i> Paket Soal TKDB</strong>

              <p class="text-muted"><?= $jadwal->PaketSoal; ?></p>

              <hr>

              <strong><i class="fa fa-clock-o margin-r-5"></i> Jadwal</strong>

              <p><?= $jadwal->Mulai ?> WITA<br>S/D<br><?= $jadwal->Selesai ?> WITA</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <?php if($tkdb->StatusUjian == "0"): ?>
                <div class="callout callout-success">
                    <h4>SELAMAT DATANG <i><?= $data->Nama ?></i> </h4>
                    <p>Pada hari ini <?= $jadwal->Hari ?>, <?= $jadwal->Today ?> akan dilaksanakan Tes Kompetensi Dasar Berfikir(TKDB) untuk anda. Dalam tes ini anda diberikan waktu 60 menit untuk menjawab 60 butir soal, waktu akan berjalan ketika anda klik tombol <b class='btn btn-xs btn-primary btn-flat'><i class='fa fa-check'></i> Mulai Tes</b> yang ada di kiri </p>
                    <p>Untuk menjadi perhatian khusus selama proses menjawab soal berlangsung dimohon untuk tidak meninggalkan halaman ini, dikarenakan waktu akan trus berjalan.</p>
                    <p>Jangan lupa menekan tombol <b class='btn btn-xs btn-success btn-flat'><i class='fa fa-check'></i> Selesai</b> jika anda telah menjawab semua soal tes. Tombol selesai akan muncul setelah semua soal terjawab</p>
                </div>
            <?php elseif($tkdb->StatusUjian == "1"): 
                $NoSoal = isset($_GET['Id']) ? sprintf("%02d",$_GET['Id']) : "01";
            ?>
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SOAL NO <?= $NoSoal  ?></h3>
                    </div>
                        <!-- /.box-header -->
                    <div class="box-body">
                    <?php 
                         $PosisiArraySoal = $NoSoal - 1;
                         $Soal = $master_soal[$PosisiArraySoal];
                        
                         
                    ?>
                        <form id="FormData" action="javascript:void(0)">
                        <input type="hidden" name="KodeSoal" value="<?= $Soal['KodeSoal'] ?>">
                        <input type="hidden" name="KodePaket" value="<?= $Soal['KodePaket'] ?>">
                        <div id="ViewSoal">
                            <?php
                               
                                if(!empty($Soal['Texts'])): ?>
                                    <div class="callout callout-info"><?= $Soal['Texts'] ?></div>
                                <?php endif; ?>
                                <div class="callout callout-default"><?= $Soal['Soal'] ?></div>
                                <hr>
                        </div>
                        <hr>
                        <?php
                            $PilJab = json_decode($Soal['PilihanJawaban'],true);
                            $Keyss = array("A","B","C","D");
                            $sel = "";
                            
                            
                           
                        ?>
                        <div id="PilihanJawaban">
                            <?php  foreach($Keyss as $key): 
                                if(array_key_exists($Soal['KodeSoal'],$master_jawaban))
                                    $sel = $master_jawaban[$Soal['KodeSoal']] == $key ? "checked" : "";
                            ?>
                            <div class="input-group">
                                <span class="input-group-addon"><?= $key ?></span>
                                <div class="form-control" style='height: 100%; width: 100%; object-fit: contain'><?= $PilJab[$key] ?></div>
                                <span class='clearfix'></span>
                                <span class="input-group-addon"><input type="radio" name='PilihanJawaban' value="<?= $key ?>" <?= $sel; ?>></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        </form>
                        <hr />
                        <?php 
                            $TombolPosisiLink = isset($_GET['Id']) ? $_GET['Id'] : 0;
                            $TombolPosisi = $TombolPosisiLink - 1;
                            $LinkSelanjutnya = $TombolPosisiLink + 1;
                            $LinkSelanjutnya = $TombolPosisiLink == count($master_soal) ? $TombolPosisiLink : $LinkSelanjutnya;
                            $LinkSebelumnya = $TombolPosisiLink - 1;
                        
                        ?>
                        <div id='Tombol'>
                            <div class="row">
                                <div class="col-sm-3">
                                    <?php if($TombolPosisi > 0): ?>
                                    <button class='btn btn-sm btn-primary' type='button' onclick="SaveJawaban('<?= $LinkSebelumnya ?>')"><i class="fa fa-chevron-left"></i> Sebelumnya</button>
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-6">
                                    <?php if(count($master_jawaban) == count($master_soal)): ?>
                                        <center><button class='btn btn-sm btn-success' type='button' onclick="SelesaiNormal()"><i class="fa fa-check"></i> SELESAI </button></center>
                                        <?php endif; ?>
                                </div>
                                <div class="col-sm-3">
                                    <?php if($TombolPosisi < count($master_soal)): ?>
                                    <button class='btn btn-sm btn-primary pull-right' type='button' onclick="SaveJawaban('<?= $LinkSelanjutnya?>')">Selanjutnya <i class="fa fa-chevron-right"></i></button>
                                    <?php endif; ?>
                                </div>
                                <span class="clearfix"></span>

                            </div>
                        </div>
                        
                    </div>
                    <!-- /.box-body -->
                </div>
            <?php else: ?>
                <div class="callout callout-success">
                    <h4>TERIMA KASIH <i><?= $data->Nama ?></i> </h4>
                    <p>Pada hari ini <?= $jadwal->Hari ?>, <?= $jadwal->Today ?> anda telah melaksanakan Tes Kompetensi Dasar Berfikir(TKDB), terima kasih atas partisipasinya.</p>
                </div>
            <?php endif; ?>
        </div>
        <!-- /.col -->
      </div>


<script>
    $(document).ready(function(){

        <?php if($tkdb->StatusUjian != "0" ): ?>
        var waktu_ujian = "<?= $this->session->userdata("waktu_ujian"); ?>";
        $('#clock').countdown(waktu_ujian, function(event) {
            var menit = event.offset.minutes;
            var detik = event.offset.seconds;
            var jam = event.offset.hours;
            if(menit <= 30 && menit > 10){
                $("#clock").removeClass("label-success");
                $("#clock").removeClass("label-danger");
                $("#clock").addClass("label-warning");
            }else if(menit <= 10){
                $("#clock").removeClass("label-success");
                $("#clock").removeClass("label-warning");
                $("#clock").addClass("label-danger");
            }

            if(jam < 1 && menit < 1 && detik < 1){
                SelesaiPaksa();
            }
            $(this).html(event.strftime('%H:%M:%S'));
        });
        <?php endif; ?>
    });


    function SaveJawaban(Id){
        var iData = $("#FormData").serialize();
        $.ajax({
            type : "POST",
            url : "<?= base_url('home/jawab_soal'); ?>",
            data : iData,
            success: function(res){
                var iRes = JSON.parse(res);
                if(iRes['status'] == true){
                    location.href = "<?= base_url("home")."?Id=" ?>"+Id;
                }
            },
            error: function(er){
                console.log(er);
            }
        })       
    }

    function SelesaiPaksa(){
            var iData = $("#FormData").serialize();
            $.ajax({
                type : "POST",
                url : "<?= base_url('home/selesai_normal'); ?>",
                data : iData,
                success: function(res){
                    console.log(res);
                    var iRes = JSON.parse(res);
                    if(iRes['status'] == true){
                        alert("Maaf waktu anda telah habis");
                        location.reload();
                    }
                },
                error: function(er){
                    console.log(er);
                }
            })   
          
    }

    function SelesaiNormal(){
        var cnfr = confirm("Pastikan jawaban anda telah terisi semua ?");
        if(cnfr){
            var iData = $("#FormData").serialize();
            $.ajax({
                type : "POST",
                url : "<?= base_url('home/selesai_normal'); ?>",
                data : iData,
                success: function(res){
                    console.log(res);
                    var iRes = JSON.parse(res);
                    if(iRes['status'] == true){
                        location.reload();
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

    function MulaiTKDB(){
        var cnfr = confirm("Anda sudah siap untuk memulai Tes ?");
        if(cnfr){
            $.ajax({
                type : "POST",
                url : "<?= base_url('home/proses_mulai'); ?>",
                data : "Noktp=<?= $data->Noktp ?>",
                success: function(res){
                    var iRes = JSON.parse(res);
                    if(iRes['status'] == true){
                        location.reload();
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