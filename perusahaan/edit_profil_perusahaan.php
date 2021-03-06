<div class="col-md-10 main-container">
    <div class="container">
        <div class="judul-content">
            <h5><i class="fas fa-suitcase mr-2"></i> EDIT PROFIL PERUSAHAAN</h5>
        </div>
        <div class="content">
            <div class="wrapper">

                <?php
                $id_user = $_SESSION['id_user'];
                $hak_akses = $_SESSION['hak_akses'];
                $user = new User();
                $perusahaan = new Perusahaan();
                $profile = $user->getData("INNER JOIN perusahaan WHERE user.id_user=perusahaan.id_user AND user.id_user={$id_user}");
                $row = $profile->fetch(PDO::FETCH_ASSOC);
                if ($_POST) {
                    if ($_POST['submit']) {
                        $id_perusahaan = $_POST['id_perusahaan'];
                        $nama_perusahaan = $_POST['nama_perusahaan'];
                        $alamat = $_POST['alamat'];
                        $kota = $_POST['kota'];
                        $email = $_POST['email'];
                        $logolama = $_POST['logolama'];

                        if (empty($_FILES['logo']['tmp_name']) && $row['logo_perusahaan'] == "default.png") {
                            echo '
                            <div class="alert alert-warning fade show" role="alert">
                                <strong>Data Kosong!</strong>
                            </div>
                            ';
                        } else {
                            if ($_FILES['logo']['error'] == 4) {
                                $fileName = $logolama;
                            } else {
                                // ketika gambar diubah maka file yang sebelumnya harus di hapus kecuali file default.png
                                if ($row['logo_perusahaan'] != 'default.png') {
                                    $hps = unlink('../uploud/' . $row['logo_perusahaan']);
                                }

                                // upload gambar
                                $explode = explode(".", $_FILES['logo']['name']);
                                $fileName = $id_user . "_Logo_" . $row['username'] . "." . end($explode);
                                move_uploaded_file($_FILES['logo']['tmp_name'], "../uploud/" . $fileName);
                            }
                            // update data perusahaan
                            $updt_perusahaan_rinci = $perusahaan->EditData($nama_perusahaan, $alamat, $kota, $fileName, $email, $id_perusahaan);

                            // direct link
                            echo "<script>document.location='?menu=profil_perusahaan';</script>";
                        }
                    }
                }
                ?>



                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_perusahaan" value="<?php echo $row['id_perusahaan'] ?>">
                    <input type="hidden" name="logolama" value="<?= $row['logo_perusahaan'] ?>">
                    <div class="row">
                        <div class="col-md-3 logo">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <img src="../uploud/<?= $row['logo_perusahaan'] ?>" width="5%" class="img img-thumbnail logo_perusahaan" alt="Logo Perusahaan">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label" for="foto_pelamar">Foto Pelamar</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label" for="nama_perusahaan">Nama Perusahaan</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="nama_perusahaan" class="form-control" id="nama_perusahaan" value="<?= ($row['nama_perusahaan'] == '-') ? "" : $row['nama_perusahaan'] ?>" placeholder="Nama Perusahaan" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label" for="email">Email</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="email" value="<?= ($row['email'] == '-') ? "" : $row['email'] ?>" placeholder="Nama Perusahaan" id="email" rows="4" required></input>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label" for="kota">Kota</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" name="kota" value="<?= ($row['kota'] == '-') ? "" : $row['kota'] ?>" id="Kota" placeholder="Kota" rows="4" required></input>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="control-label" for="alamat">Alamat</label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="alamat" placeholder="Alamat" id="alamat" rows="4" required><?= ($row['alamat'] == '-') ? "" : $row['alamat'] ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9">
                                        <button type="submit" name="submit" value="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>