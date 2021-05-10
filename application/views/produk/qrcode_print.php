<!DOCTYPE html>
<html>
<head>
	<title>QR-code Produk <?=$row->barcode?></title>
</head>
<body>
        <?php 
        $qrCode = new Endroid\QrCode\Qrcode($row->barcode);
        $qrCode->writeFile('upload/qr-code/produk-'.$row->barcode.'.png');
        ?>
        <img src="<?=base_url('upload/qr-code/produk-'.$row->barcode.'.png')?>" style= "width: 200px">
        
</body>
</html>