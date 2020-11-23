<?php include_once 'lib/header.php';

    //Ketika tombol tambah di klik
    if(isset($_POST['tambah'])){
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];

        //Mencoba upload foto
        if(isset($_FILES['foto']['name'])){
            $cur_file = $_FILES['foto']['name'];
            $tmpFilePath = $_FILES['foto']['tmp_name'];
            $ext = strtolower(pathinfo($cur_file, PATHINFO_EXTENSION));
            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg'){
                if ($tmpFilePath != ""){
                    $cnt = 0;
                    $curdatenow = date("Y-m-d-H-i-s");
                    $t_nama_file = $curdatenow."-".$cnt.".".$ext;
                    
                    while(file_exists('gambar/food/'.$t_nama_file)){
                        $cnt++;
                        $t_nama_file = $curdatenow."-".$cnt.".".$ext;
                    }

                    $newFilePath = "gambar/food/" . $t_nama_file;
                
                    //Apabila sukses upload
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        //Masukan data makanan terbaru
                        include_once 'lib/db_conf.php';
                        $sql = "INSERT INTO `food` SET `name`='$nama', `price`=$harga, `image`='$newFilePath';";

                        if(mysqli_query($conn, $sql)){
                            echo "<script language=\"javascript\">window.location.href = 'food.php';</script>";
                        }
                        $conn->close();
                    }
                }
            }
        }
    }
?>

<h1 class="text-center mt-3">Tambah Makanan</h1>

<div class="card ml-3 mr-3">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <div class="form-group">
                <label for="foto">Gambar</label>
                <input class="form-control-file" type="file" id="foto" name="foto" required>
            </div></br>
            <button type="submit" class="btn btn-success" id="tambah" name="tambah" value="tambah">Tambah</button>
        </form>
    </div>
</div>

<?php include_once 'lib/footer.php';?>
