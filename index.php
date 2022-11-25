<?php
	$namaFile="";
	$tmpUploade = "upload/";
	$max_size_file = 20*1024*1024; //20MB
if (isset($_POST["upload"])) {
  $namaFile = $_FILES['berkas_file']['name'];
  $namaSementara = $_FILES['berkas_file']['tmp_name'];
  $size_file = $_FILES['berkas_file']['size'];
  //tempat penyimpanan


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
      <a class="navbar-brand" href="#">Chương trình Nộp file thực hành</a>
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
		// wait 5 seconds and redirect :)
		echo "<meta http-equiv=\"refresh\" content=\"5;url=.\"/>";//chờ 5 s và chuyển sang trang
		?>
      </div>
      <?php endif; ?>
      <?php if (isset($error)): ?>
      <div class="alert alert-warning" role="alert">
        Tải lên không đúng!
      </div>
      <?php endif; ?>
      <?php if (isset($size_file_error)): ?>
      <div class="alert alert-warning" role="alert">
        Kích thước của file nộp phải nhỏ hơn <?php echo $max_size_file/1024/1024; ?> MB
      </div>
      <?php endif; ?>
    </form>
<table>
<?php
//phần dành cho hs2- chi tiết hơn
    echo "<b><br>Các file đã nộp gần đây</b>";
	foreach (glob("upload/*") as $path) {
		$docs[$path] = filectime($path);
	}
	if ($docs != "") {
		arsort($docs); // sort by value, preserving keys

		foreach ($docs as $path => $timestamp) {
			Echo "<tr><td>";
			$str=$tmpUploade.$namaFile;
			if (($str)==$path){//còn lỗi
				//print "<br>namaFile=".$namaFile."<br>";
				//print "<br>str=".$str."<br>";
				//print "<br>path=".$path."<br>";
				print "<font color=\"red\"><b>" . date("d M. Y: h:i:s", $timestamp)." </td><td> ".basename($path) ." </td><td>".number_format(ceil(filesize($path)/1024))."KB</b></font></td>";
				}
			else	
				print "" . date("d M. Y: h:i:s", $timestamp)." </td><td> ".basename($path) ." </td><td><font align=\"right\">".number_format(ceil(filesize($path)/1024))."KB</td></font>";
			Echo "</td></tr>";
		}
	}

?>
</table>
  </div>
 
</body>
</html>