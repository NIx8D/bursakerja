<?php
include('../require/kelas_kriteria.php');
include('../require/kelas_lamaran.php');
$kriteria = new Kriteria();
$lamaran = new Lamaran();
if (isset($_GET['id_kriteria'])) {
    $id_lowongan = $_GET['id_lowongan'];
    $id_kriteria = $_GET['id_kriteria'];
    $hapus_lamaran = $lamaran->HapusData($id_kriteria);
    $qry = $kriteria->HapusData($id_kriteria);
    if ($qry) {
        echo "<script language='javascript'>alert('Data berhasil dihapus'); document.location='?menu=data_kriteria&id_lowongan=" . $_GET['id_lowongan'] . "'</script>";
    } else {
        echo "<script language='javascript'>alert('Gagal menghapus data'); document.location='?menu=data_kriteria'</script>";
    }
} else {
    echo "Pilih kriteria dahulu";
}
