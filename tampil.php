<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
 
 
<table border="1" cellpadding="5" cellspacing="0">
     
<tr>
         
<th> NIM </th>
 
         
<th> Nama </th>
 
         
<th> Prody </th>
 
                 
<th> Action </th>
 
    </tr>
 
     
 
    <?php
        include 'koneksi.php';
 
        $select = "SELECT * FROM mahasiswa";
        $query = mysql_query($select);
 
        $no=0;
        while ($data = mysql_fetch_array($query)) {
            $nim         = $data['nim'];  // dr tabel
            $nama       = $data['nama'];
            $prodi  = $data['prodi'];
            
 
            echo "
                 
<tr>
                     
<td> $nim </td>
 
                     
<td> $nama </td>
 
                     
<td> $prodi </td>
 
                     

                     
<td>
                        <a href='#'> Edit </a> 
                        <a href='#'> Delete </a>   
                    </td>
 
                </tr>
 
            ";
        }
 
    ?>
</table>
 
 
</body>
</html>