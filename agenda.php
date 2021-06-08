<?php 
    $koneksi = mysqli_connect("localhost","root","","calendar");
    $year   = $_GET['tahun'];

    if($year == "none"){
        header('location:index.php');
    }
    else{
        $nyear  = $year + 1;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Agenda Tahunan</title>
        <link rel="icon" href="img/icon.ico" />
        <link rel="stylesheet" media="screen" href="css/main.css" />
        <link rel="stylesheet" media="print" href="css/print.css" />
    </head>
<body>

    <div class="wrapper">
        <img style="margin:1px 285px;" src="img/logo1.png" width="100px" height="100px">
        <h3>AGENDA <?php echo $year." - ".$nyear; ?></h3><br>
        Yayasan Pondok Pesantren Hidayatullah Medan
        <h3>RAA YAA BUNAYA</h3><br>
        
        <div class="content">
            <table align="center" border="1" width="600px" cellpadding="10">
                <thead>
                    <td width="200px">Tanggal</td><td>Agenda</td>
                </thead>
                <?php 
                    $query  = "SELECT *, DATE_FORMAT(start, '%d %M %Y') AS tanggal FROM events WHERE YEAR(start) BETWEEN '$year-07-01' AND '$nyear-06-30'";
                    $sql    = mysqli_query($koneksi,$query);
                    while($tampil=mysqli_fetch_array($sql)){
                ?>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;<?php echo $tampil['tanggal']; ?></td><td class="agenda">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $tampil['title']; ?></td>
                </tr>
                
                <?php } ?>
            </table>
                <button type="button" class="printBtn hidden-print">Cetak Agenda</button><br><br><br>
        
        </div>
    </div>

        <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <script type="text/javascript">
  $('.printBtn').on('click', function (){
    window.print();
  });
                
</script>
</body>
<html>