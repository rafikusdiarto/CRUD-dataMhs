<!DOCTYPE html>
<?php
include 'db.php'; //memanggil database
$fakultas= "";
$animo= "";
$error= "";
$sukses= "";
$data="";
$id="";
$row="";

if(isset($_GET["op"])){
  $op = $_GET['op'];
}else {
  $op ="";
}

if ($op == 'asc') {
  $id = $_GET['id'];
  $sql1 = "SELECT * FROM mhs ORDER BY animo ASC";
  $q1 = mysqli_query($db,$sql1);
  if($q1){
    $sukses = "Berhasil Urut Berdasarkan Ascending";
  }else {
    $error = "Gagal Mengurut Data";
  }
}
if ($op == 'desc') {
  $id = $_GET['id'];
  $sql1 = "SELECT * FROM mhs ORDER BY animo DESC";
  $q1 = mysqli_query($db,$sql1);
  if($q1){
    $sukses = "Berhasil Urut Berdasarkan Descending";
  }else {
    $error = "Gagal Mengurut Data";
  }
}




if($op == 'delete'){ //untuk delete data
  $id = $_GET['id'];
  $sql1 = "DELETE from mhs WHERE id='$id'";
  $q1 = mysqli_query($db,$sql1);
  if($q1){
    $sukses = "Berhasil Hapus Data";
  }else {
    $error = "Gagal Menghapus Data";
  }
}

if($op == "edit"){ // untuk edit data
  $id = $_GET['id'];
  $sql1 = "SELECT * from mhs where id = '$id'";
  $q1 = mysqli_query($db,$sql1);
  $r1 = mysqli_fetch_array($q1);
  $fakultas = $r1['fakultas'];
  $animo = $r1['animo'];
  
  if($fakultas==''){
    $error= "Data tidak ditemukan";
  }
}


if(isset($_POST["simpan"])){ ///untuk create
  $fakultas= $_POST['fakultas'];
  $animo= $_POST['animo'];
  
  if($fakultas && $animo){
    if($op == 'edit'){ //untuk update data
      $sql1= "UPDATE mhs SET fakultas='$fakultas', animo='$animo' WHERE id= '$id'";
      $q1 = mysqli_query($db, $sql1);
      if($q1){
        $sukses = "Data Berhasil Diupdate";
      }else {
        $error = "Data Gagal Diupdate";
      }
      
    }
    else {
      $sql1= "INSERT into mhs(fakultas,animo) values('$fakultas','$animo')";
      $q1= mysqli_query($db,$sql1);
      if($q1){
        $sukses= "Berhasil Input Data";
      }else {
        $error= "Gagal Input Data";
      }
    }
  }
  else {
    $error= "Masukkan semua data";
  }
  
}

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Bootstrap CSS -->
    
    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
    />
    <title>Data</title>
  </head>
  
  <body>
    <nav
    class="navbar navbar-light mt-5 mb-5 p-3"
    style="background-color: #e3f2fd"
    >
    <h1 class="text-center">DATA MAHASISWA</h1>
  </nav>
  <figure class="text-center">
    <blockquote class="blockquote">
      <p>Fakultas dan Animo Mahasiswa</p>
    </blockquote>
    <figcaption class="blockquote-footer">
      <cite title="Source Title"
      >CRUD : Create, Read, Update, dan Delete</cite
      >
    </figcaption>
  </figure>
  
  <div class="container">
    <div class="deskripsi">
      <h4>Tambah Data</h4>
    </div>
    <?php
      if($sukses){
        ?>
      <div class="alert alert-success" role="alert">
        <?php echo $sukses?>
      </div>
      <?php
      }
      ?>
      <?php
      if($error){
        ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error?>
      </div>
      <?php
      }
      ?>
      <!--untuk input data-->
      <form action="" method="POST">
        <div class="mb-3 row">
          <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
          <div class="col-sm-10">
            <input
            type="text"
            class="form-control"
            id="fakultas"
            name="fakultas"
            value="<?php echo $fakultas ?>"
            />
          </div>
        </div>
        <div class="mb-3 row">
          <label for="animo" class="col-sm-2 col-form-label">Animo</label>
          <div class="col-sm-10">
            <input
            type="text"
            class="form-control"
            id="animo"
            name="animo"
            value="<?php echo $animo ?>"
            />
          </div>
        </div>
        <div class="col-12">
          <input
          type="submit"
          name="simpan"
          value="Simpan Data"
          class="btn btn-primary mb-3 rounded"
          />
        </div>
        <select name="" class="form-select" aria-label="Default select example">
          <option selected>Urutkan</option>
          <option value="<?php echo $animo ?>" href="index.php?op=edit&asc=<?php echo $row->id;?>" id="asc">Ascending</option>
          <option value="<?php echo $animo ?>" href="index.php?op=edit&desc=<?php echo $row->id;?>" id="desc">Descending</option>
        </select>
      </form>
      
      
      <!--untuk tabel-->
      <div class="position-sticky">
        <table
        class="table table-dark table-striped table-hover table-bordered mt-5"
        >
        <thead>
          <tr>
            <th scope="col">Fakultas</th>
            <th scope="col">Animo</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $query = mysqli_query($db, "SELECT * FROM mhs");
            while ($row = mysqli_fetch_object($query)) :
              ?>
            <tr>
              <td><?= $row->fakultas;?></td>
              <td><?= $row->animo;?></td>
              <td>
                <a
                class="btn btn-warning"
                href="index.php?op=edit&id=<?php echo $row->id;?>"
                role="button"
                >Edit</a
                >
                <a
                class="btn btn-danger"
                href="index.php?op=delete&id=<?php echo $row->id;?>"
                onclick="return confirm('Yakin Mau Delete Data')"
                role="button"
                >Delete</a
                >
              </td>
            </tr>
            <?php
            endwhile;
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
