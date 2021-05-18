<ul class='sidebar-menu' data-widget='tree' >
    <li class='header'>MAIN NAVIGATION</li>
    <li><a href='<?= base_url(); ?>'><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
    <?php if($this->session->userdata('Level') == "Admin"){ 
        $inact = array("paket","peserta","login","soal","gambar");
        $cekA = $this->uri->segment(2);
        $actS = in_array($cekA,$inact) ? "active" : "";
    ?>
    <li class='treeview <?= $actS ?>' >
        <a href='#'>
            <i class='fa fa-archive'></i> <span>Master Data</span>
            <span class='pull-right'>
                <i class='fa fa-angle-left pull-right'></i>
            </span>
        </a>
        <ul class='treeview-menu'>
            <li <?php if($cekA == "peserta"){ echo "class='active'"; } ?>><a  href="<?= base_url('admins/peserta') ?>"><i class='fa fa-angle-double-right'></i> <span>Data Peserta</span></a></li>
            <li <?php if($cekA == "gambar"){ echo "class='active'"; } ?>><a href="<?= base_url('admins/gambar') ?>"><i class='fa fa-angle-double-right'></i> <span>Data Gambar</span></a></li>
            <li <?php if($cekA == "paket"){ echo "class='active'"; } ?>><a href="<?= base_url('admins/paket') ?>"><i class='fa fa-angle-double-right'></i> <span>Data Paket Soal</span></a></li>
            <li <?php if($cekA == "soal"){ echo "class='active'"; } ?>><a href="<?= base_url('admins/soal') ?>"><i class='fa fa-angle-double-right'></i> <span>Data  Soal</span></a></li>
            <li <?php if($cekA == "login"){ echo "class='active'"; } ?>><a href="<?= base_url('admins/login') ?>"><i class='fa fa-angle-double-right'></i> <span>Data User Admin</span></a></li>
        </ul>
    </li>
    <li <?php if($cekA == "jadwal"){ echo "class='active'"; } ?>><a href='<?= base_url('admins/jadwal') ?>'><i class='fa fa-clock-o'></i> <span>Jadwal TKDB</span></a></li>
    <li <?php if($cekA == "data"){ echo "class='active'"; } ?>><a href='<?= base_url('faq/data') ?>'><i class='fa fa-book'></i> <span>FAQ</span></a></li>
    <?php } ?>
</ul>

?>