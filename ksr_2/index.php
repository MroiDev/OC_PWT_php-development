<?php

define ("PAR_PER_PAGE", "10");
define ("PAGE_STEP", "3");

class Model
{
	private $data;
	private $subpage;
	private $pageNumber;

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
		if ($pageNumber > $this->subpage) {
			$this->pageNumber = $this->subpage;
		} else {
			$this->pageNumber = $pageNumber;
		}

		$start = ($this->pageNumber - 1) * PAR_PER_PAGE;
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
			$words = explode(" ", preg_replace('/[^a-zа-яё0123456789]+/iu', ' ', $value));
			$words = count($words);
			
			$arrayToSearch = array('HTML', 'PHP', 'ASP', 'ASP.NET', 'Java');
			$arrayForReplasing = array('<span style="color:#f25322">HTML</span>', '<span style="color:#f25322">PHP</span>', '<span style="color:#f25322">ASP</span>', '<span style="color:#f25322">ASP.NET</span>', '<span style="color:#f25322">Java</span>');
			$value = str_ireplace($arrayToSearch, $arrayForReplasing, $value);

			$pattern = '/(^|[.!?]\s+)(<.*>)?([0-9,A-Z,a-z,А-Я,а-я,Ёё])/Uu';
			$replace = '$1$2<b>$3</b>';
			$value = preg_replace($pattern, $replace, $value);

			echo "<b>Символов в абзаце:</b> " . iconv_strlen($value) . "<br>"
				. "<b>Слов в абзаце:</b> {$words}<br>"
				. "<b>Абзац:</b> {$value}<hr>";
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
		if (isset($_GET['page_number'])) {
			$this->pageNumber = intval($_GET['page_number']);
		} else {
			$this->pageNumber = 1;
		}
		
		if ($this->pageNumber <= 0) {
			$this->pageNumber = 1;
		}
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

$controller = new Controller();
$controller->run();