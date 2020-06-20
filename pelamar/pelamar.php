<div class="col-lg-10 main-container">
    <div class="container">
        <div class="judul-content">
            <h5><i class="fas fa-tachometer-alt mr-2"></i> DASHBOARD</h5>
        </div>
        <div class="content">
            <div class="container"></div>
            <div class="row">
                <?php
                include('../require/kelas_lowongan.php');
                include('../require/kelas_lamaran.php');

                $lamaran = new Pelamar();
                $tampil_lowongan = new lowongan();
                $qPelamar = $lamaran->getDatapelamar($_SESSION['id_user']);
                $resPelamar = $qPelamar->fetch();
                $data_lowongan = $tampil_lowongan->GetData("JOIN perusahaan on lowongan.id_perusahaan=perusahaan.id_perusahaan JOIN lowongan_detail on lowongan_detail.id_lowongan=lowongan.id_lowongan JOIN jurusan on lowongan_detail.id_jurusan=jurusan.id_jurusan WHERE status_lowongan='ada' and jurusan.id_jurusan={$resPelamar['id_jurusan']}");

                $no = 1;
                while ($value = $data_lowongan->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div class="col-lg-3 tampil-lowongan">
                        <div class="card">
                            <div class="card-body">
                                <img src="../uploud/<?php echo $value['logo_perusahaan'] ?>" class="img-fluid" alt="logo_perusahaan">
                                <p class="card-title"><?php echo $value['nama_lowongan'] ?></p>
                                <p class="card-text"><?php echo $value['nama_perusahaan'] ?></p>
                                <ul class="list-group">
                                    <li><i class="fas fa-building"></i><?php echo $value['departemen'] ?></li>
                                    <li><i class="fas fa-map-marker-alt"></i><?php echo $value['kota'] ?></li>
                                    <li><i class="fas fa-money-bill-wave"></i><?php echo 'Rp. ' . $value['gaji'] ?>
                                    </li>
                                    <li><i class="fas fa-briefcase"></i><?php echo $value['pengalaman_kerja'] ?></li>
                                </ul>
                                <a href="?menu=detail_lowongan&id_lowongan=<?php echo $value['id_lowongan'] ?>" class="btn btn-block tombol-lamar">Lamar</a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>