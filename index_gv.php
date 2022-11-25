<?php
	$namaFile="";
	$tmpUploade = "upload/";
	$max_size_file = 20*1024*1024; //20MB
if (isset($_POST["upload"])) {
  $namaFile = $_FILES['berkas_file']['name'];
  $namaSementara = $_FILES['berkas_file']['tmp_name'];
  $size_file = $_FILES['berkas_file']['size'];
  

  //file size
  if ($size_file > $max_size_file) {
    $size_file_error = true;
  } else {
    $ter_upload = move_uploaded_file($namaSementara, $tmpUploade.$namaFile);

    if ($ter_upload) {
      $success = true;
    } else {
      $error = true;
    }
  }

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>upload</title>
  <!-- CSS bootstrap only -->
  <link href="bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Chương trình Nộp file thực hành - GV</a>
    </div>
  </nav>
  <br>
  


  <br>
  <div class="container-sm">
    <form action="" method="post" enctype="multipart/form-data">
      <div>
        Hãy nhấn vào nút dưới đây hoặc Drag file vào:
      </div>
	  <div class="mb-3">
        <input type="file" class="form-control" name="berkas_file">
      </div>
      <div class="d-grid gap-2">
        <input type="submit" class="btn btn-primary" name="upload" value="Nộp" class="" />
      </div>
	  <?php if (isset($success)): ?>
      <div class="alert alert-success" role="alert">
        Nộp file thành công (<?php echo "file <b>".$namaFile."</b>";?>)
		<!--a href="<?=$tmpUploade.$namaFile; ?>" download="<?= $namaFile; ?>" class="alert-link">download</a-->
		
		<?php
		// wait 10 seconds and redirect :)
		echo "<meta http-equiv=\"refresh\" content=\"10;url=index_gv.php\"/>";//chờ 10s và chuyển sang trang
		?>
		
      </div>
      <?php endif; ?>
      <?php if (isset($error)): ?>
      <div class="alert alert-warning" role="alert">
        Tải lên không đúng
      </div>
      <?php endif; ?>
      <?php if (isset($size_file_error)): ?>
      <div class="alert alert-warning" role="alert">
        Kích thước của file nộp phải nhỏ hơn <?php echo $max_size_file/1024/1024; ?> MB
      </div>
      <?php endif; ?>
	  
      
	  
    </form>
<?php
/*phan danh cho hs1
     echo "<b><br>Các file đã nộp gần đây</b>";
     $dir = "upload";
     //$a="";
     // Sort in descending order
     $a = scandir($dir, 1);
     echo " (" . (count($a) - 2) . " files)";
     if (count($a) == 2) {
         echo "<br> Không có";
     } else {
         foreach ($a as $entry) {
             if ($entry == $namaFile) {
                 echo "<b><br>. " . $entry . "</b>";
             } elseif ($entry == ".." || $entry == ".") {
                 echo "";
             } else {
                 echo "<br>. " . $entry;
             }
         };
     }

*/
?>
<?php
//phần dành cho hs2- chi tiết hơn
    echo "<b><br>Các file đã nộp gần đây</b>";
	foreach (glob("upload/*") as $path) {
		$docs[$path] = filectime($path);
	}
	if ($docs != "") {
		arsort($docs); // sort by value, preserving keys

		foreach ($docs as $path => $timestamp) {
			$str=$tmpUploade.$namaFile;
			if (($str)==$path){//còn lỗi
				//print "<br>namaFile=".$namaFile."<br>";
				//print "<br>str=".$str."<br>";
				//print "<br>path=".$path."<br>";
				print "<font color=\"red\"><br /><b>" . date("d M. Y: h:i:s", $timestamp)." ".basename($path) ." ".ceil(filesize($path)/1024)."KB</b></font>";
			}
			else	
				print "<br />" . date("d M. Y: h:i:s", $timestamp)." ".basename($path) ." ".ceil(filesize($path)/1024)."KB";
		}
	}

?>
	  

<?php
// Phan danh cho giao vien
echo "<b><br><br>Phần quản lý file dành cho GV</b>";

// You can use the desired folder to check and comment the others.
// foreach (glob("../downloads/*") as $path) { // lists all files in sub-folder called "downloads"
foreach (glob("upload/*") as $path) {
    // lists all files in folder called "test"
    //foreach (glob("*.php") as $path) { // lists all files with .php extension in current folder
    $docs[$path] = filectime($path);
}


if ($docs != "") {
    asort($docs); // sort by value, preserving keys
    foreach ($docs as $path => $timestamp) {
        print "<br />" . date("d M. Y: h:i:s", $timestamp);
        print ' <a href="' .
            $path .
            '">' .
            basename($path) .
            "</a>" .
            " Size: " .
            filesize($path);
    }
}

?>

  </div>
 
</body>
</html>