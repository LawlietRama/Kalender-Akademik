<?php
	$koneksi = mysqli_connect('localhost','root','');
    $db      = mysqli_select_db($koneksi,'calendar');
		
	$semester1 = $_GET['tahun'];
	$semester2 = $semester1+1;
	  
	$sql2     = "SELECT *, DATE_FORMAT(start, '%d') AS hari FROM events WHERE YEAR(start) BETWEEN '$semester1-07-01' AND '$semester2-06-30'";
	$query2   = mysqli_query($koneksi,$sql2);
	$row2    = mysqli_num_rows($query2);
	
function showMonth($month, $year)
{
  $date = mktime(12, 0, 0, $month, 1, $year);
  $daysInMonth = date("t", $date);
  // calculate the position of the first day in the calendar (sunday = 1st column, etc)
  $offset = date("w", $date);
  $rows = 1;
   
  $koneksi = mysqli_connect('localhost','root','');
    $db      = mysqli_select_db($koneksi,'calendar');
		
	$semester1 = $_GET['tahun'];
	$semester2 = $semester1+1;
	  
	$sql2     = "SELECT *, DATE_FORMAT(start, '%d') AS haristart, DATE_FORMAT(start, '%m') AS bulanstart, DATE_FORMAT(start, '%Y') AS tahunstart, DATE_FORMAT(start, '%d') AS hariend, DATE_FORMAT(start, '%m') AS bulanend, DATE_FORMAT(start, '%Y') AS tahunend FROM events WHERE YEAR(start) BETWEEN '$semester1-07-01' AND '$semester2-06-30'";
	$query2   = mysqli_query($koneksi,$sql2);
	$row2    = mysqli_num_rows($query2);
	
	$datas = array();
    while ($tampil2 = mysqli_fetch_array($query2))
	{
		$datetime1 = new DateTime($tampil2['start']);
		$datetime2 = new DateTime($tampil2['end']);
		$interval = $datetime1->diff($datetime2);
		$totalAgenda = $interval->format('%d');
		for ($k=1;$k<=(int)$totalAgenda;$k++)
		{
		$tampil2['start'] = $datetime1->format('Y-m-d H:i:s');
		$tampil2['haristart'] = $datetime1->format('d');
		$tampil2['bulanstart'] = $datetime1->format('m');
		$tampil2['tahunstart'] = $datetime1->format('Y');
		$datas[] = $tampil2;
		$datetime1->add(new DateInterval('P1D'));
		}
	}
   
  echo date("F Y", $date);
   
  echo "<table style=\"padding:2px;\" border=\"0\">\n";
  echo "\t<tr><th>Su</th><th>M</th><th>Tu</th><th>W</th><th>Th</th><th>F</th><th>Sa</th></tr>";
  echo "\n\t<tr>";
   
  for($i = 1; $i <= $offset; $i++)
  {
    echo "<td></td>";
  }
  
  for($day = 1; $day <= $daysInMonth; $day++)
  {
	  $agenda = False;
	  
    if( ($day + $offset - 1) % 7 == 0 && $day != 1)
    {
      echo "</tr>\n\t<tr>";
      $rows++;
    }
	if( ($day + $offset - 1) % 7 == 0)						//determine sunday
	{
		for ($j=0;$j<count($datas);$j++)
		{
			if ($datas[$j]['haristart'] == $day && $datas[$j]['bulanstart'] == $month && $datas[$j]['tahunstart'] == $year)
			{
				echo '<td style="background-color:'.$datas[$j]['color'].'">' . $day . '</td>';
				$agenda = True;
			}
			
		}
		if ($agenda == False){
		echo "<td style=\"color:red\">" . $day . "</td>";
		}
		
	}
	/*else
	{
		echo "<td>" . $day . "</td>";	
	}*/
	else
	{
		for ($j=0;$j<count($datas);$j++)
		{
			if ($datas[$j]['haristart'] == $day && $datas[$j]['bulanstart'] == $month && $datas[$j]['tahunstart'] == $year)
			{
				echo '<td style="background-color:'.$datas[$j]['color'].'">' . $day . '</td>';
				$agenda = True;
			}
			
		}
		if ($agenda == False){
		echo "<td>" . $day . "</td>";
		}
			
	}
	
	/*for ($j=0;$j<=count($datas);$j++)
		{
			if ($datas[$j]['haristart'] == $day)
			{
			  echo "<td style=\"color:blue\">" . $day . "</td>";
			  break;
			}
			else
			{
			  
			  break;
			}
			
		}*/
	
	
	/*else if ($tampil2['haristart'] == $day && $tampil2['bulanstart'] == $month && $tampil2['tahunstart'] == $year)
	{
		echo "<td style=\"color:blue\">" . $day . "</td>";
	}*/
	
	
    
  
  }

  while( ($day + $offset) <= $rows * 7)
  {
    echo "<td></td>";
    $day++;
  }

  echo "</tr>\n";
  echo "</table>\n";
}
?>

<html>
  <head>
    <title>Calendar</title>

        <link rel="icon" href="img/icon.ico" />
        <link rel="stylesheet" media="screen" href="css/main.css" />
        <link rel="stylesheet" media="print" href="css/print.css" />
  </head>
  <body>
    <div style="" class="header">
      <img class="logo" align="center" src="img/logo1.png" width="100" height="100">
      <h2 style="padding-top: 20px;">KALENDER AKADEMIK RA YAA BUNAYYA <br>T.A <?php echo $semester1." / ".$semester2;?></h2>
    </div>
    <div class="bungkus">
    <center>
      <h1 style="font-size:30px;clear: both; margin-right:200px;" align="center"><?php echo $semester1; ?></h1>
    <div class="bulan7" style=""> <?php showMonth(7, $semester1); ?> </div>
    <div class="bulan8"><?php showMonth(8, $semester1); ?> </div>
    <div class="bulan9"><?php showMonth(9, $semester1); ?> </div><br>
    <div class="bulan10">  <?php showMonth(10, $semester1); ?> </div>
    <div class="bulan11"> <?php showMonth(11, $semester1); ?> </div>
    <div class="bulan12"><?php showMonth(12, $semester1); ?> </div><br><br><br><br>

    <!-- Semester 2 -->

    <h1 style="font-size:30px;clear: both; margin-right:200px;" align="center"><?php echo $semester2; ?></h1>

    <div class="bulan1">  <?php showMonth(1, $semester2); ?> </div>
    <div class="bulan2">  <?php showMonth(2, $semester2); ?> </div>
    <div class="bulan3">  <?php showMonth(3, $semester2); ?> </div><br>
    <div class="bulan4">  <?php showMonth(4, $semester2); ?> </div>
    <div class="bulan5">  <?php showMonth(5, $semester2); ?> </div>
    <div class="bulan6">  <?php showMonth(6, $semester2); ?> </div><br>
  </center>
  </div>

  <div class="agenda">
      <h3>Agenda <?php echo $semester1."/".$semester2;?> </h3><br>
      <?php  
        $sql     = "SELECT *, DATE_FORMAT(start, '%d %M %Y') AS tanggalstart, DATE_FORMAT(end, '%d %M %Y') AS tanggalend FROM events WHERE YEAR(start) BETWEEN '$semester1-07-01' AND '$semester2-06-30'";
        $query   = mysqli_query($koneksi,$sql);
        $row     = mysqli_num_rows($query);
        if($row!='0'){
        while($tampil=mysqli_fetch_array($query)){
		$datetime1 = new DateTime($tampil['start']);
		$datetime2 = new DateTime($tampil['end']);
		$datetime2->sub(new DateInterval('P1D'));
		$tanggalawal = $datetime1->format('d M Y');
		$tanggalakhir = $datetime2->format('d M Y');
		$interval = $datetime1->diff($datetime2);
		$pjgAgenda = $interval->format('%d');
		if ((int)$pjgAgenda>1)
		{
		?>
        <span style="font-size:15px;" class="date"><b><?php echo $tanggalawal; ?>-<?php echo $tanggalakhir;
		}
		else
		{	
      ?>
        <span style="font-size:15px;" class="date"><b><?php echo $tanggalawal; }?></b></span>  
		<?php 
		echo '<span class="title" style="Color:'.$tampil['color'].'">' . $tampil['title'] . '</td>'; ?> </i></span> |
      <?php 
        }
        }

        else{
          echo "Agenda Kosong";
        }
      ?>
  </div>
  </body>
</html>