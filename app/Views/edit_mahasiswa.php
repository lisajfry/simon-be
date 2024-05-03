<?php
// Inisialisasi nilai data
$data = array(
    'NIM' => 'V3921001', 
    'nama_mahasiswa'=>'Berlian Rahma',
    'angkatan' => '2021',
);


$NIM = $data['NIM']; 
$nama_mahasiswa = $data['nama_mahasiswa']; 
$angkatan = $data['angkatan']; 

?>
<form method="POST" action="/update/mahasiswa/">
    <label for="NIM">NIM:</label><br>
    <input type="text" id="NIM" name="NIM" value="V3921001"><br>
    <label for="nama_mahasiswa">Nama_mahasiswa:</label><br>
    <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="Berlian Rahma"><br>
    <label for="angkatan">Angkatan:</label><br>
    <input type="text" id="angkatan" name="angkatan" value="2021"><br>
    <input type="submit" value="Submit">
</form>

