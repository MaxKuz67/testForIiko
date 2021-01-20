<?php

class InvoicePosition
{
	private $id;
	public $name;
	public $counts;
	public $price;

	// Конструктор класса
	function __construct($id = NULL,$name = NULL,$price = NULL, $counts = NULL) {
	   $this->id = $id;
       $this->name = $name;
       $this->price = $price;
       $this->counts = $counts;
   	}

	// Получить имя позиции
	public function getName(){
		return $this->name;
	}

	// Получить количество позиции
	public function getCounts(){
		return $this->counts;
	}

	// Получить цену позиции
	public function getPrice(){
		return $this->price;
	}

	// Установить название позиции
	public function setName($name){
		$this->name = $name;
	}

	// Установить цену позиции
	public function setPrice($price){
		$this->price = $price;
	}

	// Установить количество позиции
	public function setСounts($counts){
		$this->counts = $counts;
	}

	// Поиск по ID счета
	public static function findByInvoiceId($db,$invoice_id) {
        $sql = 'SELECT * FROM invoices_positions WHERE invoice_id = '.$invoice_id;

        // Массив счетов
        $positions = [];
        
        foreach ($db->fetch_object($db->query($sql)) as $row) {
        	$positions[] = new self($row->id,$row->position_name,$row->price,$row->counts);
        }

        return $positions;
    }

	




}