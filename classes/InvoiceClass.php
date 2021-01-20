<?php

include_once 'InvoicePositionClass.php';

class Invoice
{
	private $number;// Номер счета
	private $status; // Статус счета
	private $id;

	private $statusText = [
		0 => "Не оплачен",
		1 => "Оплачен",
	];

	public $date; // Дата счета
	public $discount; // Скидка счета

	private $positions; // Позиции в счете

	private $hasUpdatePosition = false;

	// Конструктор класса
	function __construct(int $id = NULL,int $number = NULL,int $status = NULL,int $date = NULL, float $discount = NULL, $positions = NULL) {
	   $this->id = $id;
       $this->number = $number;
       $this->status = $status;
       $this->date = $date;
       $this->discount = $discount;
       $this->positions = $positions;
   	}

	// Получить номер счета
	public function getNumber(){
		return $this->number;
	}

	// Получить статус счета
	public function getStatus(){
		return $this->status;
	}

	// Получить статус счета (текстовый)
	public function getStatusText(){
		return $this->statusText[$this->status];
	}

	// Получить дату счета
	public function getDate(){
		return date("d.m.Y H:i:s",$this->date);
	}

	// Получить скидку счета
	public function getDiscount(){
		return $this->discount;
	}

	// Получить позиции счета
	public function getPositions(){
		return $this->positions;
	}

	// Установить номер счета
	public function setNumber($number){
		$this->number = $number;
	}

	// Установить статус счета
	public function setStatus($status){
		$this->status = $status;
	}

	// Установить дату счета
	public function setDate($date){
		$this->date = $date;
	}

	// Установить скидку счета
	public function setDiscount($discount){
		$this->discount = $discount;
	}

	// Функция для добавления позиции в счет
	public function addPosition($name,$count,$price)
	{
		$this->hasUpdatePosition = true;
		$this->positions[] = new InvoicePosition(NULL,$name,$price,$count);
		return 1;
	}

	// Функция для удаления позиции из счета
	public function deletePosition($pos)
	{
		if(isset($this->positions[$pos])){
			$this->hasUpdatePosition = true;
			unset($this->positions[$pos]);
			return 1;
		}
		return 0;
	}

	public function getSum()
	{
		$sum = 0;

		// Не очень понятно, что значит "Сумма" в задании, это цена одной единицы продукта или уже итоговая сумма
		foreach ($this->positions as $positions) {
			$sum += $positions->price;

			// Если это цена одной единицы, то используем код ниже
			// $sum += $positions->price * $positions->counts
		}

		// высчитываем сумму с учетом скидки 
		$sum = $sum - ($sum/100*$this->discount);

		return $sum;
	}

	// Поиск по условию
	public static function findByCondition($db,$condition = []) {
		// Массив для всех условий
        $sql = [];
        foreach ($condition as $key => $value) {
        	$sql[] = '`'.$key.'` '.$value['condition'].' "'.$db->real_escape_string($value['value']).'"';
        }

        $sql = 'SELECT * FROM invoices WHERE '.implode(" AND ", $sql);

        // Массив счетов
        $invoices = [];

        foreach ($db->fetch_object($db->query($sql)) as $row) {
        	$invoices[] = new self($row->id,$row->number,$row->status,$row->date,$row->discount,InvoicePosition::findByInvoiceId($db,$row->id));
        }

        return $invoices;
    }

    // Сохраняем "модель" класса в БД
    public function save($db)
    {
    	$db->update("invoices",[
    		"status" => $this->status,
    		"discount" => $this->discount,
    		"date" => $this->date,
    		"number" => $this->number,
    	],$this->id);

    	if($this->hasUpdatePosition){
	    	$db->delete_row("invoices_positions",$this->id,"invoice_id");

	    	foreach ($this->positions as $position) {
	    		$db->insert("invoices_positions",
					[
						"invoice_id" => $this->id,
						"position_name" => $position->name,
						"counts" => $position->counts,
						"price" => $position->price,
					]
				);
	    	}
	    }
    	return 1;
    }

	




}