<?php

// Константа для адреса формы (чтобы не искать ее в длинном коде)
define ("URL", "form.html");
define ("MAX_PARAGRAPHS", "10");


// Model
// Класс отвечает за взаимодействие с данными и подготовку выборки
class Model
{
    private $data;
    private $value;

    public function setData()
    {
        include 'text.php';
        $this->data = iconv("Windows-1251", "UTF-8", $text);
    }
	
	public function structuringData()
	{
		$this->data = explode("\r\n", $this->data);
	}
	
	public function getData()
    {
        return $this->data;
    }
	
	public function all()
	{
		$this->setData();
		$this->structuringData();
		$this->getData();
	}
}


// View
// Класс отвечает за вывод информации на экран
class View
{
	private $form;
	private $formUrl;

	// Функция для добавления формы ввода данных на всех страницах
	public function __construct()
	{
		$this->formUrl = URL;
		$this->form = include($this->formUrl);
	}
	
	public function setParagraph($perpage, $data)
	{
		echo "Номер строки: {$perpage}, а в ней текст: {$data[$perpage]}";
	}
}


// Controller
// Класс отвечает за управление программой
class Controller
{
	private $parOnPage;
	
	// Принимаем данные из формы
	public function paragraphsPerPage()
	{
		$this->parOnPage = $_GET['form'];
		return $this->parOnPage;
	}
}


$model = new Model;
$model->all();
$controller = new Controller;
$view = new View;
$view->setParagraph($controller->paragraphsPerPage(), $model->getData());