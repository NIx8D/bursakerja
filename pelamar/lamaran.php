<?php
require("../require/kelas_kriteria.php");
require("../require/kelas_lamaran.php");
$kriteria = new Kriteria();
$lamaran = new Lamaran();
$id_user = $_SESSION['id_user'];
$id_pelamar = $_SESSION['id_pelamar'];
$id_lowongan = $_GET['id_lowongan'];
$qry_kriteria = $kriteria->GetData("WHERE id_lowongan='{$id_lowongan}' AND status_uploud='1'");
$qry_kriteria1 = $kriteria->GetData("WHERE id_lowongan='{$id_lowongan}'");
// var_dump($qry_kriteria1);
$jml_uploud_berkas = $qry_kriteria->rowCount();
?>
<div class="col-lg-10 main-container">
    <div class="container">
        <div class="judul-content">
            <h5><i class="fas fa-tachometer-alt mr-2"></i> LAMARAN</h5>
        </div>
        <div class="content">
            <table class="table table-borderless">
                <?php

                if (isset($_POST['submit'])) {
                    // var_dump($_FILES);
                    // die;
                    while ($berkas = $qry_kriteria1->fetch()) {
                        if (!empty($_FILES['fileberkas_' . $berkas['id_kriteria']]['tmp_name'])) {
                            $explode = explode(".", $_FILES['fileberkas_' . $berkas['id_kriteria']]['name']);
                            $file = $id_user . "_" . $id_lowongan . "_" . $_FILES['fileberkas_' . $berkas['id_kriteria']]['name'];
                            move_uploaded_file($_FILES['fileberkas_' . $berkas['id_kriteria']]['tmp_name'], "../uploud/" . $file);
                        } else {
                            echo "<script language='javascript'>console.log({$berkas['id_kriteria']}+'kosong');</script>";
                            $file = '-';
                        }

                        // insert to tabel lamaran
                        $qry = $lamaran->InsertData($id_pelamar, $id_lowongan, $berkas['id_kriteria'], $file);

                        // die;
                        if ($qry) {
                            echo "<script language='javascript'>alert('Berkas lamaran anda berhasil diupload'); document.location='?menu=pelamar'</script>";
                        } else {
                            echo "<script language='javascript'>alert('Gagal mengupload berkas');document.location='?menu=lamaran&id_lowongan=$id_lowongan'</script>";
                        }
                    }
                }

                ?>
                <form action="" method="post" enctype="multipart/form-data">

                    <?php
                    while ($row = $qry_kriteria->fetch()) {
                        // var_dump($row['nama_kriteria']);
                    ?>
                        <tr>
                            <td class="pl-0" style="width: 350px;"><?= $row['nama_kriteria'] ?></td>
                            <td style="opacity: 50%;">
                                <div class="form-group">
                                    <input type="hidden" name="fileberkas_kriteria_<?= $row['id_kriteria'] ?>" value="<?= $row['id_kriteria'] ?>">
                                    <input type="file" name="fileberkas_<?= $row['id_kriteria'] ?>">
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
            </table>
            <table class="table table-borderless">
                <tr>
                    <td style="width: 350px;"></td>
                    <td>
                        <div class="form-group">
                            <input type='submit' name='submit' value='Simpan' class="btn btn-success tombol-lamar">
                        </div>

                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>