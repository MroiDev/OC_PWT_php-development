<?php
/**
 * КСР №4. Написать страницу отзывов c использованием ООП.
 *
 * На странице должны выводиться отзывы, начиная с самого нового, предусмотреть постраничный просмотр по n отзывов на странице.
 * Обеспечить хранение отзывов в текстовом файле. Для каждого отзыва должны храниться: имя автора, сообщение, дата и время написания
 * Предоставить возможность пользователям добавлять отзывы через форму
 * Обеспечить проверку корректности вводимых пользователем данных (пустые строки, наличие тегов в тексте и т.д.)
 *
 * Желательно обеспечить всю функциональность одним скриптом (можно несколькими).
 */

define("DB_URI", "./_db.txt");
define("FORM_URI", "./form.html");
define("NAME_LENGTH", "10");
define("POST_LENGTH", "250");
define("FEEDBACK_PER_PAGE", "5");
define("PAGE_STEP", "3");


class Model
{
	private $action;
	private $name;
	private $feedback;
	private $datetime;
	private $fileData;
	private $data;
	private $subpage;
	private $pageNumber;
	
	public function __construct()
	{
		// Получаем данные из файла (база данных отзывов)
		$this->fileData = file(DB_URI);
	}

	// Функция отрабатывает, если заполнена форма на странице
	// Controller передает очищенные данные, принимаем их для обработки
	public function setValue($action, $name, $feedback)
	{
		$this->action 	= $action;
		$this->name 	= $name;
		$this->feedback = $feedback;
		$this->datetime = date("Y-m-d H:i:s");
	}
	
	// Проверяем скрытое поле формы "action" и вызываем необходимую фунцию
	// которая добавит отзыв, отредактирует отзыв или удалит отзыв
	public function checkAction()
	{
		switch($this->action) {
			case 'add':
				$this->addFeedback();
				break;
			case 'upd':
				$this->updFeedback();
				break;
			case 'del':
				$this->delFeedback();
				break;
			default:
				$this->addFeedback();
				break;
		}
	}

	// Функция добавляет отзыв в базу данных (файл)
	private function addFeedback()
	{
		$file = DB_URI;
		$str = "{$this->name}\t{$this->datetime}\t{$this->feedback}\r\n";
		file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
		header("Location: index.php");
	}

	// Функция редактирует отзыв в базе данных (файле)	
	private function updFeedback()
	{
		// будет описана, когда дойдем до этого
	}

	// Функция удаляет отзыв из базы данных (файла)	
	private function delFeedback()
	{
		// будет описана, когда дойдем до этого
	}

	// Функция просчитывает количество подстраниц, в зависимости от того
	// сколько отзывов для вывода на страницу было установлено в константе
	public function countSubpage()
	{
		$this->subpage = ceil(count($this->fileData) / FEEDBACK_PER_PAGE);
		return $this->subpage;
	}

	// Чтобы два раза не обрабатывать данные о подстраницах - 
	// функция отдает готовые данные из Model во View
	public function modelPageNumber()
	{
		return $this->pageNumber;
	}

	// Функция отдает из базы данных (файла) необходимое количество контента
	// для отображения, в зависимости от текущей страницы, получаемой в $_GET
	public function getData($pageNumber)
	{
		if ($pageNumber > $this->subpage) {
			$this->pageNumber = $this->subpage;
		} else {
			$this->pageNumber = $pageNumber;
		}

		$start = ($this->pageNumber - 1) * FEEDBACK_PER_PAGE;
		$end = FEEDBACK_PER_PAGE;
		$this->data = array_slice(array_reverse($this->fileData), $start, $end);

		return $this->data;
	}
}


class View
{
	private $data;
	private $subpage;
	private $thispage;
	private $pageNumber;

	// Получаем из Model необходимое количество контента
	// и информацию о количестве подстраниц для отображения
	public function __construct($subpage, $data)
	{
		$this->data = $data;
		$this->subpage = $subpage;
	}

	// Функция выводит на страницу отзывы по n-штук
	public function viewData()
	{
		foreach ($this->data as $key => $value) {
			if (mb_strlen($value) < 2) {
				exit();
			}
			
			list($_name, $_date, $_feedback) = explode("\t", $value);
			
			echo "<p style='font-size: 12px;'>"
				. "<span style='font-weight: bold; color: #161816;'>{$_name}</span> ||"
				. " <span style='font-style: italic;'>{$_date}</span><br>"
				. "<span style='font-size:14px;'>{$_feedback}</span>";
		}
	}

	// Фнукция выводит постраничную навигацию по отзывам
	public function viewPagination($pageNumber)
	{
		if ($pageNumber > $this->subpage) {
			$this->pageNumber = $this->subpage;
		} else {
			$this->pageNumber = $pageNumber;
		}

		$this->thispage = $this->pageNumber;
		
		$start = $this->thispage - PAGE_STEP;
		if ($start < 1) {
			$start = 1;
		}
		
		$end = $this->thispage + PAGE_STEP;
		if ($end > $this->subpage) {
			$end = $this->subpage;
		}

		echo "<hr>";
		for($i = $start; $i <= $end; $i++) {
			if($i == $this->thispage) {
				echo $i . "&nbsp;&nbsp;";
			} else {
				echo '<a href="' . basename(__FILE__) . '?page_number=' . $i . '">' . $i . '</a>&nbsp;&nbsp;';
			}
		}
		echo "<hr>";
	}

	// Функция подключает на страницу форму для добавления отзывов
	public function addForm()
	{
		echo "<h3>Добавить отзыв</h3>";
		
		include FORM_URI;
	}
}


class Controller
{
	private $action;
	private $name;
	private $feedback;
	private $pageNumber;
	private $model;
	private $view;

	// Получаем информацию о текущей странице из $_GET
	// и производим предварительную валидацию данных
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

	// Функция производит валидацию данных из $_POST.
	// Производим очистку данных и присвоение значений переменным
	public function getForm($postArray)
	{
		if (mb_strlen($postArray['name']) > NAME_LENGTH) {			
			exit('Имя не может быть длиннее 10 символов');
		} elseif (mb_strlen($postArray['feedback']) > POST_LENGTH) {		
			exit('Сообщение не может быть длиннее 250 символов.');
		} elseif (trim($postArray['feedback']) == '' || trim($postArray['name']) == '') {
			exit('Имя/отзыв не могу быть пустой строкой.');
		} else {
			$this->action 	= $this->cleaningContent($postArray['action']);
			$this->name 	= $this->cleaningContent($postArray['name']);
			$this->feedback = $this->cleaningContent($postArray['feedback']);
		}
	}

	// Функция производит очистку данных, получаемых из формы
	public function cleaningContent($value)
	{
		$value = trim($value);
		$value = stripslashes($value);
		$value = htmlspecialchars($value);
		$value = strip_tags($value);		
		$value = str_replace("\r\n", " ", $value);

		return $value;
	}

	// Функция производит управление процессом работы скрипта
	public function runController()
	{	
		if (!empty($_POST['action']) && !empty($_POST['name']) && !empty($_POST['feedback'])) {
			$this->getForm($_POST);
			$this->model = new Model();
			$this->model->setValue($this->action, $this->name, $this->feedback);
			$this->model->checkAction();
		} else {
			$this->model = new Model();
		}

		$this->view = new View($this->model->countSubpage(), $this->model->getData($this->pageNumber));
		$this->view->viewData();
		$this->view->viewPagination($this->pageNumber);
		$this->view->addForm();
	}
}

$controller = new Controller;
$controller->runController();
