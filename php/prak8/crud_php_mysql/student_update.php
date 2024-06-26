<?php
session_start();
if (!isset($_SESSION["username"])) {
  header("Location: login.php");
}

include("connection.php");

// Fungsi untuk mengambil data mahasiswa yang akan diperbarui
if (isset($_GET["nim"])) {
    $nim_to_update = mysqli_real_escape_string($connection, $_GET["nim"]);
    $query = "SELECT * FROM student WHERE nim='$nim_to_update'";
    $result = mysqli_query($connection, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        // Mengisi variabel dengan nilai dari database
        $nim = $row['nim'];
        $name = $row['name'];
        $birth_city = $row['birth_city'];
        $birth_date = $row['birth_date'];
        $faculty = $row['faculty'];
        $department = $row['department'];
        $gpa = $row['gpa'];
    } else {
        // Tampilkan pesan jika NIM tidak ditemukan
        echo "<div class='error'>Data mahasiswa tidak ditemukan.</div>";
        exit;
    }
    $birth_date_part = explode('-', $row["birth_date"]);
    $year = $birth_date_part[0];
    $month = $birth_date_part[1];
    $day = $birth_date_part[2];
}

// Proses pembaruan data ketika formulir dikirim
if (isset($_POST["submit"])) {
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $name = htmlentities(strip_tags(trim($_POST["name"])));
    $birth_city = htmlentities(strip_tags(trim($_POST["birth_city"])));
    $faculty = htmlentities(strip_tags(trim($_POST["faculty"])));
    $department = htmlentities(strip_tags(trim($_POST["department"])));
    $gpa = htmlentities(strip_tags(trim($_POST["gpa"])));
    $birth_date = htmlentities(strip_tags(trim($_POST["birth_date"])));
    $birth_month = htmlentities(strip_tags(trim($_POST["birth_month"])));
    $birth_year = htmlentities(strip_tags(trim($_POST["birth_year"])));

    $error_message="";

    if (empty($nim)) {
      $error_message .= "- NIM belum diisi <br>";
    }
    else if (!preg_match("/^[0-9]{8}$/",$nim) ) {
      $error_message .= "- NIM harus berupa 8 digit angka <br>";
    }

    $nim = mysqli_real_escape_string($connection, $nim);
    $query = "SELECT * FROM student WHERE nim='$nim'";
    $query_result = mysqli_query($connection, $query);

    $data_amount = mysqli_num_rows($query_result);

    if (empty($name)) {
      $error_message .= "- Nama belum diisi <br>";
    }

    if (empty($birth_city)) {
      $error_message .= "- Tempat lahir belum diisi <br>";
    }

    if (empty($department)) {
      $error_message .= "- Jurusan belum diisi <br>";
    }

    $select_ftib=""; $select_fteic="";

    switch ($faculty) {
      case 'FTIB':
        $select_ftib = "selected";
        break;
      case 'FTEIC':
        $select_fteic = "selected";
        break;
    }

    if (!is_numeric($gpa) OR ($gpa <=0)) {
      $error_message .= "- IPK harus diisi dengan angka";
    }

    if ($error_message === "") {
      $nim = mysqli_real_escape_string($connection, $nim);
      $name = mysqli_real_escape_string($connection, $name );
      $birth_city = mysqli_real_escape_string($connection, $birth_city);
      $faculty = mysqli_real_escape_string($connection, $faculty);
      $department = mysqli_real_escape_string($connection, $department);
      $birth_date = mysqli_real_escape_string($connection, $birth_date);
      $birth_month = mysqli_real_escape_string($connection, $birth_month);
      $birth_year  = mysqli_real_escape_string($connection, $birth_year);
      $gpa = (float) $gpa;

      $birth_date_full = $birth_year."-".$birth_month."-".$birth_date;

      $query = "UPDATE student SET ";
      $query .= "name='$name', ";
      $query .= "birth_city='$birth_city', ";
      $query .= "birth_date='$birth_date_full', ";
      $query .= "faculty='$faculty', ";
      $query .= "department='$department', ";
      $query .= "gpa=$gpa ";
      $query .= "WHERE nim='$nim'";

      $result = mysqli_query($connection, $query);

      if($result) {
        $message = "Data mahasiswa dengan NIM = \"$nim\" berhasil diperbarui";
        $message = urlencode($message);
        header("Location: student_view.php?message={$message}");
      }
      else {
        die ("Query gagal dijalankan: ".mysqli_errno($connection). " - ".mysqli_error($connection));
      }
    }
  }

else {
    $error_message = "";
    $nim = "";
    $name = "";
    $birth_city = "";
    $select_ftib = "selected";
    $select_fteic = ""; 
    $department = "";
    $gpa = "";
    $birth_date=1; 
    $birth_month="1"; 
    $birth_year=1996;
}

$arr_month = [
  "1"=>"Januari",
  "2"=>"Februari",
  "3"=>"Maret",
  "4"=>"April",
  "5"=>"Mei",
  "6"=>"Juni",
  "7"=>"Juli",
  "8"=>"Agustus",
  "9"=>"September",
  "10"=>"Oktober",
  "11"=>"Nopember",
  "12"=>"Desember"
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa</title>
  <link href="assets/style.css" rel="stylesheet" >
</head>
<body>
  <div class="container">
    <div id="header">
      <h1 id="logo">Data Mahasiswa</h1>
    </div>
    <hr>
    <nav>
      <ul>
        <li><a href="student_view.php">Tampil</a></li>
        <li><a href="student_add.php">Tambah</a>
        <li><a href="logout.php">Logout</a>
      </ul>
    </nav>
    <h2>Update Data Mahasiswa</h2>
    <?php
      if ($error_message !== "") {
          echo "<div class='error'>$error_message</div>";
      }
    ?>
    <form id="form_mahasiswa" action="" method="post">
      <fieldset>
        <legend>Mahasiswa</legend>
        <p>
          <label for="nim">NIM : </label>
          <input type="text" name="nim" id="nim" value="<?php echo $row["nim"] ?>" placeholder="Contoh: 12345678"> (8 digit angka)
        </p>
        <p>
          <label for="name">Nama : </label>
          <input type="text" name="name" id="name" value="<?php echo $row["name"] ?>">
        </p>
        <p>
          <label for="birth_city">Tempat Lahir : </label>
          <input type="text" name="birth_city" id="birth_city"
          value="<?php echo $row["birth_city"] ?>">
        </p>
        <p>
          <label for="birth_date" >Tanggal Lahir : </label>
            <select name="birth_date" id="birth_date">
              <?php
                for ($i = 1; $i <= 31; $i++) {
                  if ($i == $day){
                    echo "<option value=$i selected>";
                  }
                  else {
                    echo "<option value=$i>";
                  }
                  echo str_pad($i, 2, "0", STR_PAD_LEFT);
                  echo "</option>";
                }
              ?>
            </select>
            <select name="birth_month">
              <?php
                foreach ($arr_month as $key => $value) {
                  if ($key == $month){
                    echo "<option value=\"{$key}\" selected>{$value}</option>";
                  }
                  else {
                    echo "<option value=\"{$key}\">{$value}</option>";
                  }
                }
              ?>
            </select>
            <select name="birth_year">
              <?php
                for ($i = 1990; $i <= 2005; $i++) {
                if ($i == $year){
                    echo "<option value=$i selected>";
                  }
                  else {
                    echo "<option value=$i>";
                  }
                  echo "$i </option>";
                }
              ?>
            </select>
        </p>
        <p>
          <label for="faculty" >Fakultas : </label>
            <select name="faculty" id="faculty">
              <option value="FTIB" <?php if($row["faculty"] == "FTIB") echo "selected" ?>>FTIB </option>
              <option value="FTEIC" <?php if($row["faculty"] == "FTEIC") echo "selected" ?>>FTEIC</option>
            </select>
        </p>
        <p>
          <label for="department">Jurusan : </label>
          <input type="text" name="department" id="department" value="<?php echo $row["department"] ?>">
        </p>
        <p>
          <label for="gpa">IPK : </label>
          <input type="text" name="gpa" id="gpa" value="<?php echo $row["gpa"] ?>" placeholder="Contoh: 2.75"> (angka desimal dipisah dengan karakter titik ".")
        </p>
      </fieldset>
      <br>
      <p>
        <input type="submit" name="submit" value="Update Data">
      </p>
    </form>
  </div>
</body>
</html>
<?php
mysqli_close($connection);
?>
