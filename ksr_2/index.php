<?php

define ("PAR_PER_PAGE", "10");
define ("PAGE_STEP", "3");

class Model
{
	private $data;
	private $subpage;
	
	public function setData()
    {
		include 'text.php';
		$this->data = iconv("Windows-1251", "UTF-8", $text);
		$this->data = explode("\r\n", $this->data);
	}	
	public function countSubpage()
	{
		$this->subpage = ceil(count($this->data) / PAR_PER_PAGE);
		
		return $this->subpage;
	}	
	public function getData($pageNumber)
	{
		$start = ($pageNumber - 1) * PAR_PER_PAGE;
		$end = PAR_PER_PAGE;
		
		$this->data = array_slice($this->data, $start, $end);
		
		return $this->data;
	}
}

class View
{
	private $data;
	private $subpage;
	private $thispage;
	
	public function __construct($data, $subpage)
	{
		$this->data = $data;
		$this->subpage = $subpage;
	}	
	public function viewData()
	{
		foreach($this->data as $key=>$value) {
			echo "Позиция в массиве: {$key} || Строка: {$value}<br>";
		}
	}	
	public function viewPagination($pagenumber)
	{
		$this->thispage = $pagenumber;
		$start = $this->thispage - PAGE_STEP;
		if($start < 1) $start = 1;
		
		$end = $this->thispage + PAGE_STEP;
		if($end > $this->subpage) $end = $this->subpage;
		
		for($i = $start; $i <= $end; $i++) {
			if($i == $this->thispage) {
				echo $i . "&nbsp;&nbsp;";
			} else {
				echo '<a href="' . basename(__FILE__) . '?page_number=' . $i . '">' . $i . '</a>&nbsp;&nbsp;';
			}
		}
	}
}

class Controller
{
	private $pageNumber;
	private $subpage;
	private $data;
	private $model;
	private $view;

	public function __construct()
	{
		$this->pageNumber = intval($_GET['page_number']);
	}	
	public function run()
	{
		$this->model = new Model();
		$this->model->setData();
		
		$this->subpage = $this->model->countSubpage();
		$this->data = $this->model->getData($this->pageNumber);
		
		$this->view = new View($this->data, $this->subpage);
		$this->view->viewData();
		$this->view->viewPagination($this->pageNumber);
	}
}

$controller = new Controller;
$controller->run();