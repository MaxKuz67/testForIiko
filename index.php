<?php
include_once 'classes/InvoiceClass.php';
include_once 'classes/DbClass.php';


$db = new Db("localhost",'root','','testForIiko');

$invoices = Invoice::findByCondition($db,
	[
		"status" => [
			"value" => 1, // выбираем олпаченный счета
			"condition" => "="
		],
		"date" => [
			"value" => strtotime("01.01.2020 00:00"), // выбираем где дата больше 1 января
			"condition" => ">="
		]
	]);



$str = '<table border="1" cellspasing="0" style="width: 100%">';

foreach ($invoices as $invoice) {

	// Пример добавления позиции
	// $invoice->addPosition("Фуагра",1,1200);

	// Пример удаления позиции
	// $invoice->deletePosition(3);
	
	 $invoice->save($db);

	$str .= '<tr><td colspan="3">Счет №'.$invoice->getNumber().' ('.$invoice->getSum().'р.) ['.$invoice->getStatusText().'] '.$invoice->getDate().'</td></tr>';
	foreach ($invoice->getPositions() as $position) {
		$str .= '<tr><td>'.$position->getName().'</td><td>'.$position->getCounts().'шт.</td><td>'.$position->getPrice().'руб.</td></tr>';
	}
	$str .= '<tr><td></td><td><b>Итого:</b></td><td><b>'.$invoice->getSum().'руб.</b></td></tr>';
}

$str .= "<table>";

?>


<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Счета</title>
</head>
<body>
	<?=$str?>
</body>
</html>



