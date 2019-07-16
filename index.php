<!DOCTYPE HTML>  
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JS CRUD Belajar</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
        integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
      html {
        scroll-behavior: smooth;
      }
    </style>
</head>
<body>  

<?php
include ("koneksi.php");

// define variables and set to empty values
$namaErr =  $alamatErr = $pekerjaanErr = "";
$id = $nama = $alamat = $pekerjaan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["nama"])) {
    $namaErr = "nama is required";
  } else {
    $nama = test_input($_POST["nama"]);
    // check if nama only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$nama)) {
      $namaErr = "Only letters and white space allowed"; 
    }
  }
  if (empty($_POST["alamat"])) {
    $alamatErr = "alamat is required";
  } else {
    $alamat = test_input($_POST["alamat"]);
  }

  if (empty($_POST["pekerjaan"])) {
    $pekerjaanErr = "pekerjaan is required";
  } else {
    $pekerjaan = test_input($_POST["pekerjaan"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!-- navbar -->
      <nav class="navbar navbar-expand-sm navbar-dark text-light fixed-top shadow bg-info rounded">
        <a class="navbar-brand">JS CRUD</a>
        <div class="col-md-3"></div>
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link text-light fa fa-home" href="#home"> Home |</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light fa fa-plus" href="#create"> Create |</a>
            </li>
            <li class="nav-item">
                    <a class="nav-link text-light fa fa-table" href="#read"> Read |</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light fa fa-edit" href="#update"> Update |</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light fa fa-trash" href="#delete"> Delete |</a>
            </li>
          </ul>
        </nav>

<!-- Home -->
    <div class="jumbotron text-center bg-info text-light" id="home">
      <img src="img/logojs-blue.png" class="rounded-circle img-fluid img-thumbnail" alt="Joko Santosa" width="200" height="auto">
      <h2>JS CRUD Database MySql</h2>
      <h3>Project No : JWP007</h3>
      <h3>Junior Web Programmer</h3>
    </div>
<!-- Proses input -->
<?php
if(isset($_POST["input"])){
  extract($_POST);
  if(empty($id) || $id==""){
    $sql = "INSERT INTO user (nama,alamat,pekerjaan)
            VALUES ('$nama', '$alamat', '$pekerjaan')";

      if (mysqli_query($con, $sql)) {
          echo '<div class="alert alert-success fixed-bottom alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Data Massssoooookkk....!!!!!.</strong>
                </div>';
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($con);
      }
    }
   else{
    $sql = "UPDATE user SET 
            nama = '$nama',
            alamat = '$alamat',
            pekerjaan = '$pekerjaan'
            WHERE id='$id'";

      if (mysqli_query($con, $sql)) {
          print '<div class="alert alert-success fixed-bottom alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Data No '. $id .' Teredit....!!!!!.</strong>
                </div>';
      } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($con);
      }
    }
  }
?>

<?php
  //Update
  if(isset($_GET["edit"])){
    extract($_GET);
    $sql = "SELECT * FROM user WHERE id='$edit'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    extract($row);
  }
  //Delete
  if(isset($_GET["delete"])){
    extract($_GET);
    $sql = "DELETE FROM user WHERE id='$delete'";

    if (mysqli_query($con, $sql)) {
        echo '<div class="alert alert-danger alert-dismissible fixed-bottom">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Data Hanguuuussss....!!!!!.</strong>
              </div>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
  ?>

<!-- Create -->
  <div class="jumbotron bg-light" id="create">
    <div class="col-md-6 mx-auto">
      <h3>Input data Baru (Create)</h3>
      <span class="text-danger">* required field</span>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'#read';?>">
        <div class="input-group-sm">
          <label for="nama">Nama:</label>
          <input type="hidden" name="id" value="<?php echo $id;?>">
          <input type="text" class="form-control" name="nama" value="<?php echo $nama;?>">
          <span class="text-danger">* <?php echo $namaErr;?></span>
        </div>
        <div class="input-group-sm">
          <label for="alamat">Alamat:</label>
          <textarea class="form-control" name="alamat" value="<?php echo $alamat;?>"><?php echo $alamat;?></textarea>
        </div>
        <div class="input-group-sm">
          <label for="pekerjaan">Pekerjaan:</label>
          <input type="text" class="form-control" name="pekerjaan" value="<?php echo $pekerjaan;?>">
          <span class="text-danger">* <?php echo $pekerjaanErr;?></span>
        </div>
        <button name="input" type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
      </form>
    </div>
  </div>

<!-- Read -->
  <div class="jumbotron text-center bg-info text-light" id="read">
    <div class="col-md-6 mx-auto" id="update">
      <h3>Data Tabel (Read)</h3>
      <div class="table-responsive-md" id="delete">          
        <table id="ba_tabel" class="table table-bordered table-striped table-sm text-light">
          <thead>
            <tr class="bg-light text-info">
              <th>ID</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Pekerjaan</th>
              <th><span class="fa fa-cog"></span></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT *
                    FROM `user`";
            $result = mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($result)) {
              print'
              <tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['nama'].'</td>
                <td>'.$row['alamat'].'</td>
                <td>'.$row['pekerjaan'].'</td>
                <td class="text-center">
              <a class="text-warning" href="?edit='.$row["id"].'#create" ><i class="fa fa-edit"></i></a>
              <a class="text-danger" href="?delete='.$row["id"].'#read"><i class="fa fa-trash"></i></a>
              </td>
              </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</body>
</html>