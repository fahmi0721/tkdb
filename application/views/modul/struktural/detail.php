
<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Data Struktural</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <a href='<?= base_url('struktural/tambah') ?>' class='btn btn-sm btn-primary' title='Tambah Data' data-toggle='tooltip'><i class='fa fa-plus'></i> Tambah</a>
            </div>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="TableData">
                    <thead>
                        <tr>
                            <th width="5px"><center>No</center></th>
                            <th>Jabatan</th>
                            <th>Deskpripsi Pekerjaan</th>
                            <th width="10%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
