<?php
    include_once 'lib/re_header.php';
    //login action
    include_once "lib/db_conf.php";
    if(isset($_POST['login'])){
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];

        //Memeriksa apakah data username dan password cocok dengan data dari database
        $sql = "SELECT * FROM `admin` WHERE `username` = '$uname' AND `password` = \"".md5($pass)."\";";

        $data = mysqli_query($conn, $sql);
        $total_row = mysqli_num_rows($data);

        if($total_row > 0){
            //Menyimpan data username dan password di session
            $_SESSION['username'] = $uname;
            $_SESSION['password'] = md5($pass);
            if(isset($_POST['remember'])){
                //Simpan data username dan password ke cookie apabila remember me di ceklis
                setcookie('save_uname', $uname, time() + (86400 * 30), "/");
                setcookie('save_pass', $pass, time() + (86400 * 30), "/");
            }else{
                clear_cookie('save_uname');
                clear_cookie('save_pass');
            }
            echo "<script language=\"javascript\">window.location.href = 'index.php';</script>";
        }else{
            echo "<script language=\"javascript\">alert(\"Username atau password salah!\");</script>";
        }
    }

    function clear_cookie($cookie_name){
        if(isset($_COOKIE[$cookie_name])){
            unset($_COOKIE[$cookie_name]);
            setcookie($cookie_name, null, -1, '/');
        }
    }
    $conn->close();
?>


<div class="col">
    <h1 class="text-center mt-3" style="color: white;">Halaman Login</h1>

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
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="checked">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary" id="login" name="login" value="login">Login</button>
        </form>
        </div>
        <div class="card-footer">
            <div class="d-inline-flex align-content-center flex-wrap">
            <small class="justify-content-center align-self-center">Tidak punya akun?</small>
            <a class="btn btn-sm btn-link" href="register.php">Register disini</a>
            </div>
        </div>
    </div>
    </div>
</div>


<script>
    //Menampilkan data username dan password dan kolomnya dari cookie apabila ada
    var cond = <?php if(isset($_COOKIE['save_uname']) && isset($_COOKIE['save_pass'])){echo 1;}else{echo 0;}?>;
    if(cond == 1){
        document.getElementById("remember").checked = true;
        document.getElementById("uname").value = '<?php if(isset($_COOKIE['save_uname'])) echo $_COOKIE['save_uname'];?>';
        document.getElementById("pass").value = '<?php if(isset($_COOKIE['save_pass'])) echo $_COOKIE['save_pass'];?>';
    }
</script>

<?php include_once 'lib/re_footer.php';?>
