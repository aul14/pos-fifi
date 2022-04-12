<?php
	session_start();
	header('Cache-Control: no-cache');
	header('Pragma: no-cache');
	include_once ("koneksi.php");
	include("phpqrcode.php");
	
	$norm = $_SESSION['norm'];
	$kd_inst = $_SESSION['kd_inst'];
	$kd_sub_inst = $_SESSION['kd_sub_inst'];
	$kd_dtl_sub_inst = $_SESSION['kd_dtl_sub_inst'];
	$no_pengunjung = $_SESSION['no_pengunjung'];
	$no_kunjungan = $_SESSION['no_kunjungan'];
	$no_sep = $_SESSION['no_sep'];
	
	// $norm = '00104484';
	// $no_sep = '0221R00801495454821';
	// $kd_inst = '01';
	// $kd_sub_inst = '10';
	// $kd_dtl_sub_inst = '01';
	// $no_pengunjung = '201700000325';
	// $no_kunjungan = '001';
	
	if($_SESSION['kd_dokter_rsf'] && $_SESSION['kd_dokter_rsf'] != '' && $_SESSION['kd_dokter_rsf'] != '--'){
		$kd_dokter_rsf = $_SESSION['kd_dokter_rsf'];
	}else{
		$kd_dokter_rsf = '';
	}
	
	$namaBulan=array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
	
	// //if no sep tidak ada validasi dari sini
	if(!$no_sep){
		$sql_pasien = "SELECT NAMA,
							  KELAMIN,
							convert(VARCHAR(10), PASIEN_NO_RM.TGL_LAHIR, 103) AS TGL_LAHIR,
							 UMUR = convert(VARCHAR(3), dbo.f_hitung_umur_tahun(CONVERT(DATETIME, CONVERT(DATE, GETDATE())), PASIEN_NO_RM.TGL_LAHIR))+' Th '						          
					FROM PASIEN_NO_RM WHERE NORM = '$norm'";
		$query_pasien = sybase_query($sql_pasien);
		while($row=sybase_fetch_array($query_pasien)){
			$nama = $row['NAMA'];
			$kelamin = $row['KELAMIN'];
			$tgl_lahir = $row['TGL_LAHIR'];
			$umur = $row['UMUR'];
		}
		
		if($kelamin=='1') {
			$nama_pasien = 'Tn. '.$nama;
		} else {
			$nama_pasien = 'Ny. '.$nama;
		}
		$nama_pasien = $nama;
		
		$sql_dtl_sub_inst = "SELECT KET_DTL_SUBINST FROM DTL_SUB_INST
		WHERE KD_INST = '$kd_inst'
		AND KD_SUB_INST = '$kd_sub_inst'
		AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst'";
		$query_dtl_sub_inst = sybase_query($sql_dtl_sub_inst);
		
		while($row=sybase_fetch_array($query_dtl_sub_inst)){
			$ket_dtl_sub_inst = $row['KET_DTL_SUBINST'];
		}
		$sql_antrian = "SELECT NO_ANTRIAN FROM ANTRIAN_LYN
		WHERE KD_INST = '$kd_inst'
		AND KD_SUB_INST = '$kd_sub_inst'
		AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst'
		AND NO_PENGUNJUNG = '$no_pengunjung'
		AND NO_KUNJUNGAN = '$no_kunjungan'";
		$query_antrian = sybase_query($sql_antrian);
		
		$no_antrian = '';
		while($row=sybase_fetch_array($query_antrian)){
			$no_antrian = $row['NO_ANTRIAN'];
		}
		
		
		$sql_dokter = "SELECT NM_DOKTER_RSF FROM TDOKTER_RSF WHERE KD_DOKTER_RSF = '$kd_dokter_rsf'";
		$query_dokter = sybase_query($sql_dokter);
		
		while($row=sybase_fetch_array($query_dokter)){
		$nm_dokter_rsf = $row['NM_DOKTER_RSF'];
		}
		
		
	} else {
		
		$tempDir = dirname(__FILE__).'\qrcode\\';
		
		$fileName = $no_sep.'.png';
		
		$pngAbsoluteFilePath = $tempDir.$fileName;
		$urlRelativeFilePath = 'qrcode/'.$fileName;
		
		QRcode::png($no_sep, $pngAbsoluteFilePath); 
		
		
		if($kd_dokter_rsf != ''){
			$sql_dokter = "SELECT NM_DOKTER_RSF FROM TDOKTER_RSF WHERE KD_DOKTER_RSF = '$kd_dokter_rsf'";
			$query_dokter = sybase_query($sql_dokter);
			
			while($row=sybase_fetch_array($query_dokter)){
			$nm_dokter_rsf = $row['NM_DOKTER_RSF'];
			}
		}else{
			$nm_dokter_rsf ='';
		}
		
		
		$query_sep ="SELECT NORM = PASIEN.NORM, 
							NO_REGISTRASI = PASIEN.KD_INST+'.'+PASIEN.KD_SUB_INST+'.'+PASIEN.KD_DTL_SUB_INST+'.'+PASIEN.NO_PENGUNJUNG+'.'+PASIEN.NO_KUNJUNGAN, 
							TGL_REG = convert(VARCHAR(10), PASIEN.TGL_REG, 103)+' '+convert(VARCHAR(8), PASIEN.TGL_REG, 108),
							NAMA = PASIEN.NAMA,
							TGL_LAHIR = convert(VARCHAR(10), PASIEN.TGL_LAHIR, 103)+
							            ' ('+convert(VARCHAR(3),dbo.f_hitung_umur_tahun(PASIEN.TGL_REG, PASIEN.TGL_LAHIR))+' Th '+
							           convert(VARCHAR(2),dbo.f_hitung_umur_bulan(PASIEN.TGL_REG, PASIEN.TGL_LAHIR))+' Bl '+
							           convert(VARCHAR(2),dbo.f_hitung_umur_hari(PASIEN.TGL_REG, PASIEN.TGL_LAHIR))+' Hr)', 
							KELAMIN = CASE WHEN PASIEN.KELAMIN = '1' THEN 'Laki-laki' ELSE 'Perempuan' END,
							CARA_BAYAR = (SELECT A.PAKET_JAMINAN FROM PAKET_JAMINAN A
										   WHERE A.KD_BAYAR = JAMINAN.KD_BAYAR
											 AND A.KD_JNS_CR_BYR = JAMINAN.KD_JNS_CR_BYR
											 AND A.KD_PAKET_JAMINAN = JAMINAN.KD_PAKET_JAMINAN),
							PROSEDUR_MASUK = (SELECT A.PROSMSK FROM TPROSEDUR_MSK A WHERE A.KD_PROSMSK = REGISTRASI_MASUK.KD_PROSMSK), 
							CARA_MASUK = (SELECT A.CARAMASUK FROM TCARA_MSK A WHERE A.KD_CARAMASUK = REGISTRASI_MASUK.KD_CARAMASUK), 
							POLI_TUJUAN	= ISNULL((SELECT REF_POLI.NM_POLI 
											  FROM REF_POLI
											 WHERE REF_POLI.KD_POLI		= REGISTRASI_MASUK.KD_POLI_BPJS),ISNULL((SELECT REF_POLI.NM_POLI 
																													  FROM REF_POLI
																													 WHERE REF_POLI.KD_POLI		= REF_PESERTA.KD_POLI_BPJS),(SELECT MAX(REF_POLI.NM_POLI) 
																																												  FROM REF_POLI,SHARE_POLI
																																												 WHERE SHARE_POLI.KD_INST			= REGISTRASI_MASUK.KD_INST
																																													AND SHARE_POLI.KD_SUB_INST		= REGISTRASI_MASUK.KD_SUB_INST
																																													AND SHARE_POLI.KD_DTL_SUB_INST	= REGISTRASI_MASUK.KD_DTL_SUB_INST
																																													AND SHARE_POLI.STS_AKTIF			='1'
																																													AND REF_POLI.KD_POLI				= SHARE_POLI.KD_POLI))),
							DIAGNOSA_AWAL = RUJUKAN_MASUK.DIAGNOSE,
							TGL_SEP = convert(VARCHAR(10), PASIEN.TGL_REG, 103)+' '+convert(VARCHAR(8), PASIEN.TGL_REG, 108),   
							NO_RUJUKAN = RUJUKAN_MASUK.NO_SRT_RUJUKAN,   
							TGL_RUJUKAN = convert(VARCHAR(10), RUJUKAN_MASUK.TGL_RUJUK, 103), 
							ASAL_RUJUKAN = ISNULL(LIST_SJP.NM_PROVIDER_SJP,REF_PESERTA.NM_PROVIDER),
							KODE_PPK = RUJUKAN_MASUK.KD_PUSKESMAS,   
							DIAGNOSA_PUSK = RUJUKAN_MASUK.DIAGNOSE,
							IDENTITAS_KUNJUNGAN = PASIEN.KD_INST+'.'+PASIEN.KD_SUB_INST+'.'+PASIEN.KD_DTL_SUB_INST+'.'+PASIEN.NO_PENGUNJUNG+'.'+PASIEN.NO_KUNJUNGAN, 
							ASAL_PESERTA = RUJUKAN_MASUK.INSTANSI_PERUJUK,   
							NO_BUKTI_SEP = JAMINAN.NO_SURAT_JAMINAN, 
							NO_KARTU = JAMINAN.NO_PESERTA, 
							NO_ANTRIAN = (SELECT A.NO_ANTRIAN FROM ANTRIAN_LYN A
										   WHERE A.KD_INST = PASIEN.KD_INST
											 and A.KD_SUB_INST = PASIEN.KD_SUB_INST and  
							A.KD_DTL_SUB_INST = PASIEN.KD_DTL_SUB_INST and  
							A.NO_PENGUNJUNG = PASIEN.NO_PENGUNJUNG and  
							A.NO_KUNJUNGAN = PASIEN.NO_KUNJUNGAN ),
							ALAMAT = PASIEN.ALAMAT,
							NO_HP = PASIEN.NO_TELP,
							COB = ISNULL(LIST_SJP.NM_CABANG_SJP,REF_PESERTA.NM_CABANG),
							NM_JENIS_PESERTA = ISNULL(LIST_SJP.NM_JENIS_PESERTA_SJP,REF_PESERTA.NM_JENIS_PESERTA),
							JENIS_RAWAT = CASE WHEN PASIEN.KD_INST = '02' THEN 'Rawat Inap' ELSE 'Rawat Jalan' END,
							KELAS = ISNULL(LIST_SJP.NM_KELAS_SJP,REF_PESERTA.NM_KELAS),
							PENJAMIN = REGISTRASI_MASUK.PENJAMIN_LL,
							CATATAN = REGISTRASI_MASUK.CATATAN,
							JML_CETAK = LIST_SJP.JML_CETAK,
							HUB_KEL = LIST_SJP.HUB_KEL
					   FROM PASIEN,  
							JAMINAN,   
							LIST_SJP, 
							RUJUKAN_MASUK, 
							REGISTRASI_MASUK,
         					REF_PESERTA
					  WHERE PASIEN.KD_INST = JAMINAN.KD_INST and  
							PASIEN.KD_SUB_INST = JAMINAN.KD_SUB_INST and  
							PASIEN.KD_DTL_SUB_INST = JAMINAN.KD_DTL_SUB_INST and  
							PASIEN.NO_PENGUNJUNG = JAMINAN.NO_PENGUNJUNG and  
							PASIEN.NO_KUNJUNGAN = JAMINAN.NO_KUNJUNGAN and  
							JAMINAN.KD_INST = LIST_SJP.KD_INST and  
							JAMINAN.KD_SUB_INST = LIST_SJP.KD_SUB_INST and  
							JAMINAN.KD_DTL_SUB_INST = LIST_SJP.KD_DTL_SUB_INST and  
							JAMINAN.NO_PENGUNJUNG = LIST_SJP.NO_PENGUNJUNG and  
							JAMINAN.NO_KUNJUNGAN = LIST_SJP.NO_KUNJUNGAN and  
							JAMINAN.NO_PESERTA = LIST_SJP.NO_PESERTA and  
							JAMINAN.NO_SURAT_JAMINAN = LIST_SJP.NO_SURAT_JAMINAN and  
							JAMINAN.HUB_KEL = LIST_SJP.HUB_KEL and  
							JAMINAN.TGL_AWAL = LIST_SJP.TGL_JAMINAN and  
							PASIEN.KD_INST = RUJUKAN_MASUK.KD_INST AND 
							PASIEN.KD_SUB_INST = RUJUKAN_MASUK.KD_SUB_INST AND 
							PASIEN.KD_DTL_SUB_INST = RUJUKAN_MASUK.KD_DTL_SUB_INST AND 
							PASIEN.NO_PENGUNJUNG = RUJUKAN_MASUK.NO_PENGUNJUNG AND 
							PASIEN.NO_KUNJUNGAN = RUJUKAN_MASUK.NO_KUNJUNGAN AND
							PASIEN.KD_INST = REGISTRASI_MASUK.KD_INST AND 
							PASIEN.KD_SUB_INST = REGISTRASI_MASUK.KD_SUB_INST AND 
							PASIEN.KD_DTL_SUB_INST = REGISTRASI_MASUK.KD_DTL_SUB_INST AND 
							PASIEN.NO_PENGUNJUNG = REGISTRASI_MASUK.NO_PENGUNJUNG AND 
							PASIEN.NO_KUNJUNGAN = REGISTRASI_MASUK.NO_KUNJUNGAN AND
							LIST_SJP.NO_PESERTA	= REF_PESERTA.NO_PESERTA AND
							PASIEN.KD_INST = '$kd_inst' AND  
							PASIEN.KD_SUB_INST = '$kd_sub_inst' AND  
							PASIEN.KD_DTL_SUB_INST = '$kd_dtl_sub_inst' AND  
							PASIEN.NO_PENGUNJUNG = '$no_pengunjung' AND  
							PASIEN.NO_KUNJUNGAN = '$no_kunjungan' AND  
							LIST_SJP.NO_SURAT_JAMINAN <> NULL AND  
							RTRIM(LTRIM(LIST_SJP.NO_SURAT_JAMINAN)) <> ''";
		
		$result_sep=sybase_query($query_sep);
		while($row=sybase_fetch_array($result_sep)){
			$norm			= $row['NORM'];
			$no_registrasi	= $row['NO_REGISTRASI'];
			$tgl_registrasi	= $row['TGL_REG'];
			$nama_pasien	= $row['NAMA'];
			$tgl_lahir		= $row['TGL_LAHIR'];
			$kelamin		= $row['KELAMIN'];
			$cara_bayar		= $row['CARA_BAYAR'];
			$prosedur_masuk	= $row['PROSEDUR_MASUK'];
			$cara_masuk		= $row['CARA_MASUK'];
			$ket_dtl_sub_inst	= $row['POLI_TUJUAN'];
			$diagnosa_awal	= $row['DIAGNOSA_AWAL'];
			$tgl_sep		= $row['TGL_SEP'];
			$no_rujukan		= $row['NO_RUJUKAN'];
			$tgl_rujukan	= $row['TGL_RUJUKAN'];
			$asal_rujukan	= $row['ASAL_RUJUKAN'];
			$kode_ppk		= $row['KODE_PPK'];
			$diagnosa_pusk	= $row['DIAGNOSA_PUSK'];
			$identitas_kunj	= $row['IDENTITAS_KUNJUNGAN'];
			$asal_peserta	= $row['ASAL_PESERTA'];
			$no_bukti_sep	= $row['NO_BUKTI_SEP'];
			$no_kartu		= $row['NO_KARTU'];
			$no_antrian		= $row['NO_ANTRIAN'];
			$alamat			= $row['ALAMAT'];
			$no_hp			= $row['NO_HP'];
			$cob			= $row['COB'];
			$jenis_peserta	= $row['NM_JENIS_PESERTA'];
			$jenis_rawat	= $row['JENIS_RAWAT'];
			$kelas_rawat	= $row['KELAS'];
			$penjamin		= $row['PENJAMIN'];
			$catatan		= $row['CATATAN'];
			$jml_cetak		= $row['JML_CETAK'];
			$hub_kel		= $row['HUB_KEL'];
			
		}
		
		//---Untuk update jml cetakan pada list sjp
		if($jml_cetak == '' || $jml_cetak == null ) {
			$sql_sjp = "UPDATE LIST_SJP
						   SET JML_CETAK = 1
						WHERE KD_INST = '$kd_inst' 
							AND KD_SUB_INST = '$kd_sub_inst'
							AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst' 
							AND NO_PENGUNJUNG = '$no_pengunjung' 
							AND NO_KUNJUNGAN = '$no_kunjungan' 
							AND NORM = '$norm' 
							AND NO_PESERTA = '$no_kartu' 
							AND HUB_KEL = '$hub_kel' 
							AND NO_SURAT_JAMINAN = '$no_bukti_sep'
						";
			$query_sjp = sybase_query($sql_sjp);
		}else{
			$sql_sjp = "UPDATE LIST_SJP
						   SET JML_CETAK = $jml_cetak + 1
						WHERE KD_INST = '$kd_inst' 
							AND KD_SUB_INST = '$kd_sub_inst'
							AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst' 
							AND NO_PENGUNJUNG = '$no_pengunjung' 
							AND NO_KUNJUNGAN = '$no_kunjungan' 
							AND NORM = '$norm' 
							AND NO_PESERTA = '$no_kartu' 
							AND HUB_KEL = '$hub_kel' 
							AND NO_SURAT_JAMINAN = '$no_bukti_sep'
						";
			$query_sjp = sybase_query($sql_sjp);
		}
		
		$sql_sjp = "SELECT JML_CETAK 
					   FROM LIST_SJP
					WHERE KD_INST = '$kd_inst' 
						AND KD_SUB_INST = '$kd_sub_inst'
						AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst' 
						AND NO_PENGUNJUNG = '$no_pengunjung' 
						AND NO_KUNJUNGAN = '$no_kunjungan' 
						AND NORM = '$norm' 
						AND NO_PESERTA = '$no_kartu' 
						AND HUB_KEL = '$hub_kel' 
						AND NO_SURAT_JAMINAN = '$no_bukti_sep'
						";
		$query_sjp = sybase_query($sql_sjp);
		while($row = sybase_fetch_array($query_sjp)){
			$jml_cetak_sep		= $row['JML_CETAK'];
		}
		
		$sql_kd_inst_asal = "SELECT KD_INST_ASAL_IRNA
						  FROM RUJUKAN_BPJS
						 WHERE NO_RUJUKAN = '$no_rujukan'
							AND NORM = '$norm'
							AND noKartu = '$no_kartu' ";
		$query_kd_inst_asal = sybase_query($sql_kd_inst_asal);
		
		while($row_kd_inst_asal = sybase_fetch_array($query_kd_inst_asal)) {
			$kd_inst_asal_irna = $row_kd_inst_asal['KD_INST_ASAL_IRNA'];
		}
			
		$date = new DateTime();
		$tgl_cetak_sep = $date->format('m/d/Y H:i:s A');
		
		$tgl_replace = str_replace('/', '-', $tgl_rujukan);
		$timestamp = date('Y-m-d', strtotime($tgl_replace));
		
		$tgl_rujukan_awal = $tgl_rujukan;
		$tgl_rujukan_akhir = strtotime(date('Y/m/d', strtotime($timestamp)) . "+89 day"); //0036382
		$tgl_rujukan_akhir = date('d/m/Y', $tgl_rujukan_akhir);
		
		
		$tgl_berlaku_rujukan = '';
		if($kd_inst_asal_irna == '01'){
			
			// cari noreg irna
			$sql_irna = "SELECT TOP 1 KD_INST, 
						KD_SUB_INST, 
						KD_DTL_SUB_INST, 
						NO_PENGUNJUNG, 
						NO_KUNJUNGAN 
					  FROM LIST_SJP
					 WHERE NO_SURAT_JAMINAN = '$no_rujukan'
						AND NORM = '$norm'
						AND NO_PESERTA = '$no_kartu'";
			$query_irna = sybase_query($sql_irna);
			
			while($row_irna = sybase_fetch_array($query_irna)) {
				$kd_inst_irna = $row_irna['KD_INST'];
				$kd_sub_inst_irna = $row_irna['KD_SUB_INST'];
				$kd_dtl_sub_inst_irna = $row_irna['KD_DTL_SUB_INST'];
				$no_pengunjung_irna = $row_irna['NO_PENGUNJUNG'];
				$no_kunjungan_irna = $row_irna['NO_KUNJUNGAN'];
			}
			
			// cari noreg asal rujukan irna
			$sql_asal = "SELECT KD_INST_ASAL, 
							KD_SUB_INST_ASAL, 
							KD_DTL_SUB_INST_ASAL, 
							NO_PENGUNJUNG_ASAL, 
							NO_KUNJUNGAN_ASAL 
						  FROM RUJUKAN_MASUK
						WHERE KD_INST = '$kd_inst_irna'
							AND KD_SUB_INST = '$kd_sub_inst_irna'
							AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst_irna'
							AND NO_PENGUNJUNG = '$no_pengunjung_irna'
							AND NO_KUNJUNGAN = '$no_kunjungan_irna'";
			$query_asal = sybase_query($sql_asal);
			
			while($row_asal = sybase_fetch_array($query_asal)) {
				$kd_inst_asal = $row_asal['KD_INST_ASAL'];
				$kd_sub_inst_asal = $row_asal['KD_SUB_INST_ASAL'];
				$kd_dtl_sub_inst_asal = $row_asal['KD_DTL_SUB_INST_ASAL'];
				$no_pengunjung_asal = $row_asal['NO_PENGUNJUNG_ASAL'];
				$no_kunjungan_asal = $row_asal['NO_KUNJUNGAN_ASAL'];
			}
			
			//cari tgl rujukan ppk1
			$sql_tgl_rujuk = "SELECT TGL_RUJUK = convert(VARCHAR(10), RUJUKAN_MASUK.TGL_RUJUK, 103)
								  FROM RUJUKAN_MASUK
								WHERE KD_INST = '$kd_inst_asal'
									AND KD_SUB_INST = '$kd_sub_inst_asal'
									AND KD_DTL_SUB_INST = '$kd_dtl_sub_inst_asal'
									AND NO_PENGUNJUNG = '$no_pengunjung_asal'
									AND NO_KUNJUNGAN = '$no_kunjungan_asal'";
			$query_tgl_rujuk = sybase_query($sql_tgl_rujuk);
			
			while($row_tgl_rujuk = sybase_fetch_array($query_tgl_rujuk)) {
				$tgl_rujuk_ppk = $row_tgl_rujuk['TGL_RUJUK'];
			}
			
			$tgl_replace = str_replace('/', '-', $tgl_rujuk_ppk);
			$timestamp = date('Y-m-d', strtotime($tgl_replace));
			$cek_tgl_rujuk_ppk = strtotime(date('Y-m-d H:i:s', strtotime($timestamp)) . "+89 day"); //0036382
			$cek_tgl_rujuk_ppk = date('Y-m-d H:i:s', $cek_tgl_rujuk_ppk);
			$hari_ini = date('Y-m-d H:i:s');
			
			if($cek_tgl_rujuk_ppk > $hari_ini){
				$tgl_rujukan_awal = $tgl_rujuk_ppk;
				$tgl_rujukan_akhir = strtotime(date('Y/m/d', strtotime($timestamp)) . "+89 day"); //0036382
				$tgl_rujukan_akhir = date('d/m/Y', $tgl_rujukan_akhir);
				$tgl_berlaku_rujukan = $tgl_rujukan_awal.' s.d '.$tgl_rujukan_akhir;
			}else{
				$tgl_berlaku_rujukan = '-';
			}
			
		}else if($kd_inst_asal_irna == '03'){
			$tgl_berlaku_rujukan = '-';
		}else{
			$tgl_berlaku_rujukan = $tgl_rujukan_awal.' s.d '.$tgl_rujukan_akhir;
		}
		
	}
?>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!DOCTYPE html>
<html lang="en" class="uk-height-1-1">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
		
			<title>RSUD BAYU ASIH</title>
		<!--<link rel="stylesheet" href="css/uikit.min.css"   type="text/css">
		-->
		<link rel="stylesheet" href="css/style.css"   type="text/css">
		<link href="css/style_cetak.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="css/print.css"   type="text/css">
		
		<script src="js/jquery-1.10.2.js"></script>
		<script src="js/jQuery.print.js"></script>
		<!--<script src="js/uikit.min.js"></script>-->
		<script src="js/daftar.js"></script>
		<script>
			
			//jam
			var currenttime = '<?php echo date("F d, Y H:i:s"); ?>' //PHP method of getting server date   
			var serverdate=new Date(currenttime)
			
			function padlength(what){
				var output=(what.toString().length==1)? "0"+what : what
				return output
			}
			
			function displaytime(){
				serverdate.setSeconds(serverdate.getSeconds()+1)
				var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
				document.getElementById("txt").innerHTML=timestring
			}
			
			setInterval("displaytime()", 1000);
			
			setTimeout(function() {
			// window.location = 'daftar_bpjs.php';
			window.location = 'index.php';
			}, <?php echo $waktu_tunggu * 1000?>);
			
			<?php if(!$no_sep){ ?>
				$(document).ready(function() {
					$('#print').print();
				});
				<?php } else { ?>
				$(document).ready(function() {
					$('#print_sep').print();
				});
			<?php } ?>
			
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
					$(this).remove(); 
				});
			}, 3000);
			
		</script>
	</head>
	
	<body class="uk-height-1-1 bg_index">
		<div class= "uk-height-1-1">
			<!--
			<div id="home">
				<a href="index.php"></a>
					<div class="icon_home"></div>
			</div>
			-->
			<br>
			<div class="dm-link">
				<div class="uk-float-left uk-text-left" style="padding-right:100px;">
					<a href="index.php" class="icon_home_2"></a>
				</div>
				<div class="uk-float-right uk-text-right" style="padding-left:100px;">
					<?php
						if(!$no_sep) {
							if(isset($_SESSION['kd_dtl_sub_inst'])) {
								echo '<a href="poli.php" class="icon_back"></a>';
							}
						}
					?>
				</div>
				<div class="uk-clearfix"></div>
			</div>
			<div class="uk-vertical-align uk-text-center uk-height-1-1" style="height:87%; margin-top:4%">
				<div class="uk-vertical-align-middle" style="width: 70%;margin-top:3%">
					<div class="uk-vertical-align uk-text-center">
						<div class="uk-vertical-align-middle uk-width-1-1  bg_sukses">
							<!-- display sukses reg -->
							<div  class="uk-width-1-1 " style="padding-top:85px;">
								<h1 style="color:#FEDF0F" ><strong>Registrasi Sukses</strong></h1>
								<br><br>
						
								<h1 class="gray_text" ><strong>RSUD BAYU ASIH</strong></h1>
								<br>
								<?php 
									echo '<h2 class="gray_text"><strong>'.$nama_pasien.' </strong>  </h2>';
									echo '<h2 class="gray_text"><strong>No.RM : '.$norm.' </strong> </h2>';
									echo '<br>';
									echo '<h2 class="gray_text"><strong>'.$ket_dtl_sub_inst.'</strong> </h2>';
									echo '<br>';
									if($no_antrian != '') {
										echo '<h3 class="gray_text"><strong>Nomor Antrian : </strong></h3>';
										echo '<h2 class="gray_text"><strong>'.$no_antrian.'</strong></h2>';
									}
									if($kd_dokter_rsf != ''){
										echo '<br>';
										echo '<h3 class="gray_text"><strong>Dokter: </strong></h3>';
										echo '<h2 class="gray_text"><strong>'.$nm_dokter_rsf.'</strong></h2>';
									}
									
								?>
															
								<br>
								<h3 class="gray_text"><strong>Tanggal : </strong> </h3>
								<h2 class="gray_text"><strong><?php echo  date("d")." ".$namaBulan[date("n")]." ".date("Y");?> </strong> </h2>
								<br>
								<h3 class="gray_text"><strong>Jam : </strong> </h3>
								<h2 class="gray_text"><strong><?php echo date('H:i');?> WIB</strong> </h2>
								<br>
								<?php
								if($no_sep){
								?>
									<h1 class="alert" style="color:#20733D;" ><strong>Sedang proses cetak SEP...</strong></h1>
								<?php }else{ ?>
									<h1 class="alert" style="color:#20733D;" ><strong>Sedang proses cetak...</strong></h1>
								<?php } ?>
								<!--
									<a href="cetak.php" type="submit" class="uk-button button_cetak_sks uk-button-sucess">Cetak</a>
								-->
							</div>
						</div>
						
					</div>
					<div class="uk-grid uk-text-center">
						<div class="uk-width-1-10" style="padding-left:10px;">
						</div>
					</div>
				</div>
			</div>
			<div class="copy_right">
				<div class="uk-h5" style="color:#60807C; float:left; font-weight:bold;">&copy; <?php echo date("Y"); ?>&nbsp;&nbsp;&nbsp;&nbsp;PT. BUANA VARIA KOMPUTAMA &nbsp;&nbsp;-&nbsp;&nbsp; ALL RIGHTS RESERVED</div>
			</div>
			<!-- print -->
			<!--
			<div  class="">
			-->
			
			<div  class="uk-hidden">	
				<div id="print" class="uk-vertical-align uk-text-center uk-height-1-1">
					<div class="uk-vertical-align-middle">
						<div style="height:auto; width:200px; padding:5px; border:1px solid black;">
							<div>
								<table  border="0" style="width:200px; font-family:arial; font-size:13px; font-weight:bold; text-align:center;">
									<img class="dm-cetak-logo" alt="" src="image/logo_cetak.png">
									<tr><td>----------------------------------------</td></tr>
									<?php
										echo '<tr><td> '.$nama_pasien.' </td></tr>';
										echo '<tr><td>No.RM : '.$norm.'</td></tr>';
										echo '<tr><td>Tanggal Lahir :</td></tr>';
										echo '<tr><td>'.$tgl_lahir.'</td></tr>';
										echo '<tr><td>Umur : '.$umur.'</td></tr>';
										if(!$no_sep && $kd_dokter_rsf != ''){
											echo '<tr><td>Dokter :</td></tr>';
											echo '<tr><td>'.$nm_dokter_rsf.'</td></tr>';
										}
										echo '<tr><td>'.$ket_dtl_sub_inst.'</td></tr>';
										if($no_antrian != '') {
											echo '<tr><td>No Antrian :</td></tr>';
											echo '<tr><td>'.$no_antrian.'</td></tr>';
										}
									?>
									<tr><td>Tanggal :</td></tr>
									<tr><td ><?php echo  date("d")." ".$namaBulan[date("n")]." ".date("Y");?></td></tr>
									<tr><td>Jam :</td></tr>
									<tr><td><?php echo date('H:i'); ?> WIB</td></tr>
									<tr><td>----------------------------------------</td></tr>
								</table>
								<table  border="0" style="width:200px; font-family:arial; font-size:8px; font-style:italic; font-weight:bold; text-align:left">
									<tr><td >CATATAN :</td></tr>
									<tr><td>Dokter sewaktu waktu dapat berubah atas </td></tr>
									<tr><td>kebijakan poli</td></tr>
								</table>
							</div>				
						</div>
					</div>
				</div>
				<div id="print_sep" class="container">
				<?php
					for($i=0; $i < 3; $i++) {
					if($i == 0){
						echo '<div class="content">';
					}else{
						echo '<div class="content" style="border-top:dashed 1px;">';
					}
				?>
					
					<?php
						if($i == 0 ) {
					?>
							<div class="kiri" style="height:99%; padding-top:2%; padding-bottom:2%; border-right:dashed 1px;">
					<?php
						} elseif($i == 1 ) {
					?>
							<div class="kiri" style="height:99%;  padding-top:2%; padding-bottom:2%; border-right:dashed 1px;">
					<?php
						} elseif($i == 2 ) {
					?>
						<div class="kiri" style="height:99%; padding-top:2%; padding-bottom:2%; border-right:dashed 1px;">
					<?php
						}
					?>
							<!--
							<div class="judul_kiri"><img src="image/rs_blank.png"  width="190mm" height="44.55mm"></div>
							-->
							<div class="judul_kiri"><img src="image/logo_rs.png"  width="190mm" height="44.55mm"></div>
							<div class="data_kiri"> 
								<table class="table_data_kiri">
									<tr>
										<td>NO. SEP</td><td>:</td><td><?php echo $no_sep;?></td>
									</tr>
									<tr>
										<td>TGL. SEP</td><td>:</td><td><?php echo $tgl_sep;?></td>
									</tr>
									<tr>
										<td>NO. KARTU</td><td>:</td><td><?php echo $no_kartu;?></td>
									</tr>
									<tr>
										<td valign="top">NAMA PESERTA</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $nama_pasien;?></td>
									</tr>
									<tr>
										<td>No. RM</td><td>:</td><td><?php echo $norm;?></td>
									</tr>
									<tr>
										<td>TGL. LAHIR</td><td>:</td><td><?php echo $tgl_lahir;?></td>
									</tr>
									<tr>
										<td valign="top">ALAMAT PASIEN</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $alamat;?></td>
									</tr>
									<tr>
										<td>NO.REGISTRASI RS</td><td>:</td><td><?php echo $no_registrasi;?></td>
									</tr>
									<tr>
										<td>TGL.REGISTRASI RS</td><td>:</td><td><?php echo $tgl_registrasi;?></td>
									</tr>
									<tr>
										<td>POLI TUJUAN</td><td>:</td><td><?php echo $kd_inst = '01' ? $ket_dtl_sub_inst : ' ';?></td>
									</tr>
									<tr>
										<td>TGL. BERLAKU RUJUKAN</td><td>:</td><td><?php echo $tgl_berlaku_rujukan; ?></td>
									</tr>
									
								</table>
							</div>
							<div class="footer_kiri">
								<div class="barcode_kiri"><?php echo "<img src='$urlRelativeFilePath' />"; ?></div>
								
								<div class="no_antri_kiri">
									<table class="nama_no_antri" style="width:100%">
										<tr>
											<th class="nama_no_antri">NOMOR ANTRIAN</th>
										</tr>
										<tr>
											<td class="nama_no_antri no_antri"><?php echo $no_antrian;?></td>
										</tr>
									</table>
								</div>
								
							</div>
						</div>
					<?php
							if($i == 0 ) {
					?>
							<div class="kanan" style="height:99%; padding-top:2%; padding-bottom:2%;">
					<?php
						} elseif($i == 1 ) {
					?>
						<div class="kanan" style="height:99%;  padding-top:2%; padding-bottom:2%;">
					<?php
						} elseif($i == 2 ) {
					?>
						<div class="kanan" style="height:99%; padding-top:2%; padding-bottom:2%;">
					<?php
						}
					?>
							<div class="judul_sep">
							
								<div class="icon_bpjs"><img src="image/logo_bpjs.png"  width="110mm" height="35mm"></div>
								<div class="judul_kanan">SURAT ELEGIBILITAS PESERTA <br> RSUD BAYU ASIH
								</div>
							<!--
							<div class="icon_bpjs"><img src="image/bpjs_blank.png"  width="110mm" height="35mm"></div>
							-->
							<div class="judul_kanan"></div>					
							<!--
							<div class="icon_rs"><img src="image/icon_rs.png"  width="35mm" height="35mm"></div>
							-->
							<div class="icon_rs"><img src="image/bpjs_blank.png"  width="35mm" height="35mm"></div>
							</div>
							<div class="data_kanan">
								<div class="data_kanan_satu">
									<table  class="table_data_kanan">
										<tr>
											<td>No. SEP</td><td>:</td><td><?php echo $no_sep;?></td>
										</tr>
										<tr>
											<td>Tgl. SEP</td><td>:</td><td><?php echo $tgl_sep;?></td>
										</tr>
										<tr>
											<td>No.Kartu</td><td>:</td><td><?php echo $no_kartu.'&nbsp;&nbsp;&nbsp;&nbsp;MR.&nbsp;'.$norm;?></td>
										</tr>
										<tr>
											<td valign="top">Nama Peserta</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $nama_pasien;?></td>
										</tr>
										<tr>
											<td>Tgl. Lahir</td><td>:</td><td><?php echo $tgl_lahir;?></td>
										</tr>
										<tr>
											<td>Jns.Kelamin</td><td>:</td><td><?php echo $kelamin;?></td>
										</tr>
										<tr>
											<td>Poli Tujuan</td><td>:</td><td><?php echo $kd_inst = '01' ? $ket_dtl_sub_inst : ' ';?></td>
										</tr>
										<tr>
											<td valign="top">Faskes Perujuk</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $asal_rujukan;?></td>
										</tr>
										<tr>
											<td valign="top">Diagnosa Awal</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $diagnosa_pusk;?></td>											
										</tr>
										<tr>
											<td valign="top">Catatan</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $catatan; ?></td>
										</tr>
										
									</table>
									
								</div>
								
								
								
								
								
								<div class="data_kanan_dua">
									<table  class="table_data_kanan">
										<tr>
											<td></td><td></td><td></td>
										</tr>
										
										<tr>
											<td>Peserta</td><td>:</td><td><?php echo $jenis_peserta;?></td>
										</tr>
										
										<tr>
											<td valign="top">COB</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-break:brak-all;"><?php echo $cob;?></td>
										</tr>
										<tr>
											<td>Jns.Rawat</td><td>:</td><td><?php echo $jenis_rawat;?></td>
										</tr>
										<tr>
											<td>Kls.Rawat</td><td>:</td><td><?php echo $kelas_rawat;?></td>
										</tr>
										<tr>
											<td valign="top">Penjamin</td><td valign="top">:</td><td  style="font-size:8px; white-space:normal; word-wrap:normal;"><?php echo $penjamin; ?></td>
										</tr>
										
										
									</table>
								</div>
							</div>
							
							<div class="data_tengah_1">
								<table>
									<tr>
										<td style= "font-size:8px;padding-top:12px"><i>* Saya menyetujui BPJS Kesehatan menggunakan informasi medis pasien jika diperlukan</i></td>
										<td style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pasien/Keluarga Pasien</td>
									</tr>
									<tr>
										<td style="font-size:8px;"><i>* SEP bukan sebagai bukti penjaminan peserta</i></td>
										<td style="font-size:10px;"></td>
									</tr>
									<tr>
										<td style= "font-size:10px;"><?php echo "Cetakan Ke ".$jml_cetak_sep."&nbsp;&nbsp;-&nbsp;&nbsp;".$tgl_cetak_sep;?></td>
										<td style="font-size:10px;"></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td></td>
										<td>&nbsp;&nbsp;&nbsp;-----------------</td>
									</tr>
								</table>
							</div>
							
							<div class="footer_kanan">
								<div class="barcode_kanan"><?php echo "<img src='$urlRelativeFilePath' />"; ?></div>
								<div class="note">
									<div class="petugas_nama">
									</div>
									<div class="petugas_sign" >
									<br>
										
									</div>
									<div class="teks_kiri">
										
									</div>
									<div class="teks_kanan" style="font-size:16px;"></div>
								</div>
							</div>
						
						</div>
					</div>
				<?php } ?>
				</div>
			</div>
			<?php
				include "footer.php";
			?>
		</div>
	</body>
	
	
</html>			
