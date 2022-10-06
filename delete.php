<?php
if($op == 'delete'){
  $id = $_GET['id'];
  $sql1 = "DELETE from mhs WHERE id='$id'";
  $q1 = mysqli_query($db,$sql1);
  if($q1){
    $sukses = "Berhasil Hapus Data";
  }else {
    $error = "Gagal Menghapus Data";
  }
}
?>