<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$judul = $pengarang = $penerbit = $tahun = $jumlah = $harga  = $detail = "";
$judul_err = $pengarang_err = $penerbit_err = $tahun_err = $jumlah_err = $harga_err  = $detail_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_judul = trim($_POST["judul"]);
    if(empty($input_judul)){
        $judul_err = "Isi judul buku";
    } else{
        $judul = $input_judul;
    }

    // Validate nama pengarang
    $input_pengarang = trim($_POST["pengarang"]);
    if(empty($input_pengarang)){
        $pengarang_err = "Isi NAma Pengarang";
    } else{
        $pengarang = $input_pengarang;
    }

     // Validate nama penerbit
    $input_penerbit = trim($_POST["penerbit"]);
    if(empty($input_penerbit)){
        $pengarang_err = "Isi NAma Penerbit";
    } else{
        $penerbit = $input_penerbit;
    }
 
  // Validate nama tahun
    $input_tahun = trim($_POST["tahun"]);
    if(empty($input_tahun)){
        $tahun_err = "Isi NAma tahun";
    } else{
        $tahun = $input_tahun;
    }

     // Validate nama jumlah halaman
    $input_jumlah = trim($_POST["jumlah"]);
    if(empty($input_jumlah)){
        $jumlah_err = "Isi NAma jumlah";
    } else{
        $jumlah = $input_jumlah;
    }

     // Validate detail buku
    $input_detail = trim($_POST["detail"]);
    if(empty($input_detail)){
        $detail_err = "Isi NAma detail";
    } else{
        $detail = $input_detail;
    }


    // Check input errors before inserting in database
    if(empty($judul_err) && empty($pengarang_err) && empty($penerbit_err) && empty($tahun_err) && empty ($jumlah_err) && empty($harga_err) && empty($detail_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO tabel_buku (judul, pengarang, penerbit, tahun, jumlah, harga, detail) VALUES (?, ?, ?, ?, ?, ?, ?)";

           
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sssssss", $param_judul, $param_pengarang, $param_penerbit, $param_tahun, $param_judul, $param_harga, $param_detail);

                // Set parameters
                $param_judul = $judul;
                $param_pengarang = $pengarang;
                $param_penerbit = $penerbit;
                $param_tahun = $tahun;
                $param_jumlah= $jumlah;
                $param_harga = $harga;
                $param_detail = $detail;

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
	<style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }

        .page-header h2{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Tambah Record</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data pegawai ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                        <div class="form-group <?php echo (!empty($judul_err)) ? 'has-error' : ''; ?>">
                            <label>judul buku</label>
                            <input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>">
                            <span class="help-block"><?php echo $judul_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pengarang_err)) ? 'has-error' : ''; ?>">
                            <label>pengarang</label>
                            <input type="text" name="pengarang" class="form-control" value="<?php echo $pengarang; ?>">
                            <span class="help-block"><?php echo $pengarang_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($penerbit_err)) ? 'has-error' : ''; ?>">
                            <label>penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="<?php echo $penerbit; ?>">
                            <span class="help-block"><?php echo $penerbit_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($tahun_err)) ? 'has-error' : ''; ?>">
                            <label>tahun</label>
                            <input type="text" name="tahun" class="form-control" value="<?php echo $tahun; ?>">
                            <span class="help-block"><?php echo $tahun_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($jumlah_err)) ? 'has-error' : ''; ?>">
                            <label>jumlah buku</label>
                            <input type="text" name="jumlah" class="form-control" value="<?php echo $jumlah; ?>">
                            <span class="help-block"><?php echo $jumlah_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($harga_err)) ? 'has-error' : ''; ?>">
                            <label>harga buku</label>
                            <input type="text" name="harga" class="form-control" value="<?php echo $harga; ?>">
                            <span class="help-block"><?php echo $harga_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($detail_err)) ? 'has-error' : ''; ?>">
                            <label>detail</label>
                            <input type="text" name="detail" class="form-control" value="<?php echo $detail; ?>">
                            <span class="help-block"><?php echo $detail_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

