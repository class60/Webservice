<?php
// Check for the path elements
// Turn off error reporting
error_reporting(0);
// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// Report all errors
error_reporting(E_ALL);
// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);
// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);
$method = $_SERVER['REQUEST_METHOD'];
//site.com/data -> /data
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
// echo "request===".$request;
// echo "|||";
// echo "method===".$method;
// echo "|||";
 
// $input = json_decode(file_get_contents('php://input'),true);
// $input = file_get_contents('php://input');
// var_dump($input);die*();
$link = mysqli_connect('localhost', 'id8194877_admin', 'admin12', 'id8194877_konsulnilai');
// $link = mysqli_connect('localhost', 'root', '', 'posyandu');
mysqli_set_charset($link,'utf8');
 
$params = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
// echo "data===".$data;
// echo "|||";
$id = array_shift($request);
// echo "id===".$id;
// echo "|||";
if ($params == 'data') {
	switch ($method) {
		case 'GET':
	    {
		    if (empty($id))
		    {
			    $sql = "select * from nilai"; 
			    // echo "select * from posyandu ";break;
		    }
		    else
		    {
		         $sql = "select * from nilai where id='$id'";
		         // echo "select * from posyandu where id='$id'";break;
		    }
	    }
	}
 
	$result = mysqli_query($link,$sql);
 
	if (!$result) {
		http_response_code(404);
		die(mysqli_error());
	}
	if ($method == 'GET') {
		$hasil=array();
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		{
			$hasil[]=$row;
		} 
		$resp = array('status' => true, 'message' => 'Data show succes', 'data' => $hasil);
	} else {
		$resp = array('status' => false, 'message' => 'Access Denied');
	}
}elseif ($method == 'POST') {
	$data = $_POST;
    if ($params == "create") {
    	$kode=$data["kode"];
	    $nim=$data["nim"];
	    $matakuliah=$data["matakuliah"];
	    $kpkl=$data["kpkl"];
	    $khs=$data["khs"];
	    $dosenp=$data["dosenp"];
		$querycek = "SELECT * FROM nilai WHERE kode like '$kode'";
		$result=mysqli_query($link,$querycek);
		if (mysqli_num_rows($result) == 0)
		{
			$query = "INSERT INTO nilai (
			kode,
			nim,
			matakuliah,
			kpkl,
			khs,
			dosenp)
			VALUES (				
			'$kode',
			'$nim',
			'$matakuliah',
			'$kpkl',
			'$khs',
			'$dosenp)";
			
			mysqli_query($link,$query);
			$resp = array('status' => true, 'message' => "nilai $kode ditambahkan");
		} else { 
			$resp = array('status' => false, 'message' => 'nilai sudah terdaftar');
		}
    } elseif ($params == "update") {
    	$id=$data["id"];
	    $kode=$data["kode"];
	    $nim=$data["nim"];
	    $matakuliah=$data["matakuliah"];
	    $kpkl=$data["kpkl"];
	    $khs=$data["khs"];
	    $dosenp=$data["dosenp"];
	    $query = "UPDATE nilai 
	    	SET kode = '$kode',
	    	nim = '$nim',
	    	matakuliah = '$matakuliah',
	    	kpkl = '$kpkl',
	    	khs = '$khs',
	    	dosenp = '$dosenp',
			WHERE id =$id";
	    if (mysqli_query($link,$query)) {
	    	
			$resp = array('status' => true, 'message' => "nilai $kode diupdate");
	    } else {
	    	$resp = array('status' => false, 'message' => 'proses update gagal');
	    }
    } elseif ($params == "delete") {
    	$id=$data["id"];
	    $query = "DELETE FROM nilai WHERE id = $id";
	    if (mysqli_query($link,$query)) {
	    	
		    $resp = array('status' => true, 'message' => 'data berhasil dihapus');
	    } else {
	    	$resp = array('status' => false, 'message' => 'data gagal dihapus');
	    }
    }    
} else {
	$resp = array('status' => false, 'message' => 'data gagal');
}
echo json_encode($resp);
mysqli_close($link);
?>