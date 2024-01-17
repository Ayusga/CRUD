<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$judul = $pengarang = $penerbit = $tahun = $jumlah = $harga = $detail = "";
$judul_err = $pengarang_err = $penerbit_err = $tahun_err = $jumlah_err = $harga_err = $detail_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate judul
    $input_judul = trim($_POST["judul"]);
    if(empty($input_judul)){
        $judul_err = "Please enter a judul.";
    } elseif(!filter_var($input_judul, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $judul_err = "Please enter a valid judul.";
    } else{
        $judul = $input_judul;
    }
    
    // Validate pengarang pengarang
    $input_pengarang = trim($_POST["pengarang"]);
    if(empty($input_pengarang)){
        $pengarang_err = "Please enter an pengarang.";     
    } else{
        $pengarang = $input_pengarang;
    }

    // Validate penerbit penerbit
    $input_penerbit = trim($_POST["penerbit"]);
    if(empty($input_pengarang)){
        $penerbit_err = "Please enter an penerbit.";     
    } else{
        $penerbit = $input_penerbit;
    }

    // Validate tahun
    $input_tahun = trim($_POST["tahun"]);
    if(empty($input_tahun)){
        $tahun_err = "Please enter an tahun.";     
    } else{
        $tahun = $input_tahun;
    }

    // Validate jumlah jumlah
    $input_jumlah = trim($_POST["jumlah"]);
    if(empty($input_jumlah)){
        $jumlah_err = "Please enter an jumlah.";     
    } else{
        $jumlah = $input_jumlah;
    }

    // Validate harga harga
    $input_harga = trim($_POST["harga"]);
    if(empty($input_harga)){
        $harga_err = "Please enter an harga.";     
    } else{
        $harga = $input_harga;
    }

    // Validate detail detail
    $input_detail = trim($_POST["detail"]);
    if(empty($input_detail)){
        $detail_err = "Please enter an detail.";     
    } else{
        $detail = $input_detail;
    }
    
    
    
    // Check input errors before inserting in database
    if(empty($judul_err) && empty($pengarang_err) && empty($penerbit_err) && empty($tahun_err) && empty($jumlah_err) && empty($harga_err) && empty($detail_err)){
        // Prepare an update statement
        $sql = "UPDATE tabel_buku SET judul=?, pengarang=?, penerbit=?, tahun=?, jumlah=?, harga=?, detail=? WHERE no=?";
   
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssi", $param_judul, $param_pengarang, $param_penerbit, $param_tahun, $param_jumlah, $param_harga, $param_detail, $param_id);

            // Set parameters
            $param_judul = $judul;
            $param_pengarang = $pengarang;
            $param_penerbit = $penerbit;
            $param_tahun = $tahun;
            $param_jumlah = $jumlah;
            $param_harga = $harga;
            $param_detail = $detail;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM tabel_buku WHERE no = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $judul = $row["judul"];
                    $pengarang = $row["pengarang"];
                    $penerbit = $row["penerbit"];
                    $tahun = $row["tahun"];
                    $jumlah = $row["jumlah"];
                    $harga = $row["harga"];
                    $detail = $row["detail"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($judul_err)) ? 'has-error' : ''; ?>">
                            <label>judul Buku</label>
                            <input type="text" name="judul" class="form-control" value="<?php echo $judul; ?>">
                            <span class="help-block"><?php echo $judul_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pengarang_err)) ? 'has-error' : ''; ?>">
                            <label>pengarang</label>
                            <textarea name="pengarang" class="form-control"><?php echo $pengarang; ?></textarea>
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
                            <label>jumlah</label>
                            <input type="text" name="jumlah" class="form-control" value="<?php echo $jumlah; ?>">
                            <span class="help-block"><?php echo $jumlah_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($harga_err)) ? 'has-error' : ''; ?>">
                            <label>harga</label>
                            <input type="text" name="harga" class="form-control" value="<?php echo $harga; ?>">
                            <span class="help-block"><?php echo $harga_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($detail_err)) ? 'has-error' : ''; ?>">
                            <label>detail</label>
                            <input type="text" name="detail" class="form-control" value="<?php echo $detail; ?>">
                            <span class="help-block"><?php echo $detail_err;?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>