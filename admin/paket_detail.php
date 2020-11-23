<?php include_once 'lib/header.php';

    //Sama seperti fungsi di food_detail.php akan tetapi ini untuk paket
    if(isset($_POST['tambah'])){
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];

        if(isset($_FILES['foto']['name'])){
            $cur_file = $_FILES['foto']['name'];
            $tmpFilePath = $_FILES['foto']['tmp_name'];
            $ext = strtolower(pathinfo($cur_file, PATHINFO_EXTENSION));
            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg'){
                if ($tmpFilePath != ""){
                    $cnt = 0;
                    $curdatenow = date("Y-m-d-H-i-s");
                    $t_nama_file = $curdatenow."-".$cnt.".".$ext;
                    
                    while(file_exists('gambar/paket/'.$t_nama_file)){
                        $cnt++;
                        $t_nama_file = $curdatenow."-".$cnt.".".$ext;
                    }

                    $newFilePath = "gambar/paket/" . $t_nama_file;
                
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        include_once 'lib/db_conf.php';
                        $sql = "INSERT INTO `paket` SET `name`='$nama', `price`=$harga, `image`='$newFilePath';";

                        if(mysqli_query($conn, $sql)){
                            $cur_id = mysqli_insert_id($conn);
                            echo "<script language=\"javascript\">window.location.href = 'paket_food_detail.php?id=$cur_id';</script>";
                        }
                        $conn->close();
                    }
                }
            }
        }
    }
?>

<h1 class="text-center mt-3">Tambah Paket</h1>

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
            </div>
            </br>
            <button type="submit" class="btn btn-success" id="tambah" name="tambah" value="tambah">Tambah</button>
        </form>
    </div>
</div>

<?php include_once 'lib/footer.php';?>
