<!DOCTYPE html>
<html>
<head>
	<title>Barcode Produk <?=$row->barcode?></title>
</head>
<body>
        <?php
       $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row->barcode, $generator::TYPE_CODE_128)) . '" style= "width: 250px" >';
        ?>
        <br><br>
        <?=$row->barcode?>
</body>
</html>