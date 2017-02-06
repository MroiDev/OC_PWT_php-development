<?php

define ("PAR_PER_PAGE", "10");

class Model
{
	private $data;
	private $value;
	
	public function setData()
    {
		include 'text.php';
		$this->data = iconv("Windows-1251", "UTF-8", $text);
	}
	
	public function getData($pageNumber)
	{
		$start = ($pageNumber - 1) * PAR_PER_PAGE;
		$end = PAR_PER_PAGE;
		
		$this->data = explode("\r\n", $this->data);
		$this->data = array_slice($this->data, $start, $end);
		
		return $this->data;
	}
}

class View
{
	private $data;
	
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function viewData()
	{
		foreach($this->data as $key=>$value) {
			echo "Позиция в массиве: {$key} || Строка: {$value}<br>";
		}
	}
}

class Controller
{
	private $pageNumber;
	private $model;
	private $view;
	private $data;
	
	public function __construct()
	{
		$this->pageNumber = $_GET['page_number'];
	}
	
	public function run()
	{
		$this->model = new Model();
		$this->model->setData();
		$this->data = $this->model->getData($this->pageNumber);
		$this->view = new View($this->data);
		$this->view->viewData();
	}
}

$controller = new Controller;
$controller->run();