<?php
    include_once 'lib/re_header.php';
    //register action
    include_once "lib/db_conf.php";
    if(isset($_POST['register'])){
        $uname = $_POST['uname'];
        $pass = md5($_POST['pass']);
        $kpass = md5($_POST['kpass']);
        $phone = $_POST['phone'];

        //Memeriksa apakah username sudah ada
        $sql = "SELECT * FROM `admin` WHERE `username` = '$uname';";

        $data = mysqli_query($conn, $sql);
        $total_row = mysqli_num_rows($data);

        if($total_row == 0){
            //Memeriksa apakah password sesuai dengan konfirmasi
            if($pass == $kpass){
                //Apabila sesuai daftarkan admin bedasarkan datanya
                $sql = "INSERT INTO `admin` SET `username`='$uname', `password`='$pass', `phone`='$phone';";
                if(mysqli_query($conn, $sql)){
                    echo "<script language=\"javascript\">window.location.href = 'login.php';</script>";
                }else{
                    echo "<script language=\"javascript\">alert(\"Register kredensial gagal!\");</script>";
                }
            }else{
                echo "<script language=\"javascript\">alert(\"Konfirmasi password tidak sesuai!\");</script>";
            }
        }else{
            echo "<script language=\"javascript\">alert(\"Username sudah ada!\");</script>";
        }
    }
    $conn->close();
?>


<div class="col">
    <h1 class="text-center mt-3" style="color: white;">Halaman Register</h1>

    <div class="row justify-content-center" style="margin-top: 3rem;">
    <div class="card" style="width: 20rem;">
        <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" class="form-control" id="uname" name="uname" required>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="form-group">
                <label for="kpass">Konfirmasi Password</label>
                <input type="password" class="form-control" id="kpass" name="kpass" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Nomor Telepon</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary" id="register" name="register" value="register">Register</button>
            <a class="btn btn-danger" href="login.php">Kembali</a>
        </form>
        </div>
    </div>
    </div>
</div>

<?php include_once 'lib/re_footer.php';?>
