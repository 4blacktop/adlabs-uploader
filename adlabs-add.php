<?php
// скрипт создает по 20 тизеров в каждой кампании
// прайс засасывать из массива
// $proxy="222.74.212.66:808";
// 14:31 15.11.2012 добавлена возможность загружать по одному тизеру, если не пуста переменная $teaserNumUpload, то будет загружен именно тизер с этой строки
// 23:51 15.11.2012 в массив добавлена возможность указывать принудительно номер кампании для загрузки по одному тизеру, но еще не реализовано полностью

header("Content-Type: text/html; charset=utf-8");
// header("Content-Type: text/html; charset=windows-1251");
set_time_limit(0);
ini_set('memory_limit', '1024M');
$mtime = microtime(true);
include_once('inc.php');

// настройки
// номер строки для загрузки тизера
$teaserNumUpload = 0;

// данные для авторизации
$login = 'login@jk.com';
$pass = 'pass';


// массив с каталогами и URL кампаний

// $campsURLArray = array(
// array ('sims4','sims4','http://rfregions.ru/sims4/?xid=HbxG0MHv', '1.31','131904'),
// );
// array ('2033','2033','http://rfregions.ru/metro2033/?xid=HbxG0MHv', '1.31','63051'),
// array ('2034','2034','http://rfregions.ru/metro2034/?xid=HbxG0MHv', '1.31','63052'),
// array ('assa','assa','http://rfregions.ru/assassin/?xid=HbxG0MHv', '1.31','63053'),
// array ('cod2','cod2','http://rfregions.ru/cod2/?xid=HbxG0MHv', '1.31','63054'),
// array ('cosm','cosm','http://rfregions.ru/cosmowars/?xid=HbxG0MHv', '1.31','63055'),
// array ('cstr','cstr','http://rfregions.ru/cs2/?xid=HbxG0MHv', '1.31','63056'),
// array ('dbl4','dbl4','http://rfregions.ru/diablo4/?xid=HbxG0MHv', '1.31','63057'),
// array ('dota','dota','http://rfregions.ru/dota2/?xid=HbxG0MHv', '1.31','63058'),
// array ('dom2','dom2','http://rfregions.ru/dom2/?xid=HbxG0MHv', '1.31','63059'),
// array ('dum3','dum3','http://rfregions.ru/doom3/?xid=HbxG0MHv', '1.31','63060'),
// array ('farm','farm','http://rfregions.ru/ferma/?xid=HbxG0MHv', '1.31','63061'),
// array ('fifa','fifa','http://rfregions.ru/fifa/?xid=HbxG0MHv', '1.31','63062'),
// array ('frsg','frsg','http://rfregions.ru/forsazh/?xid=HbxG0MHv', '1.31','63063'),
// array ('gta5','gta5','http://rfregions.ru/gta/?xid=HbxG0MHv', '1.31','63064'),
// array ('intn','intn','http://rfregions.ru/interns/?xid=HbxG0MHv', '1.31','63065'),
// array ('mfia','mfia','http://rfregions.ru/rusmafia/?xid=HbxG0MHv', '1.31','63066'),
// array ('mk','mk','http://rfregions.ru/mortalkombatvk/?xid=HbxG0MHv', '1.31','63067'),
// array ('mstl','mstl','http://rfregions.ru/mstiteli/?xid=HbxG0MHv', '1.31','63068'),
// array ('nfs','nfs','http://rfregions.ru/nfs/?xid=HbxG0MHv', '1.31','63069'),
// array ('pacn','pacn','http://rfregions.ru/pacani/?xid=HbxG0MHv', '1.31','63070'),
// array ('rusr','rusr','http://rfregions.ru/racing/?xid=HbxG0MHv', '1.31','63071'),
// array ('spdr','spdr','http://rfregions.ru/spiderman/?xid=HbxG0MHv', '1.31','63072'),
// array ('spnz','spnz','http://rfregions.ru/specnaz/?xid=HbxG0MHv', '1.31','63073'),
// array ('stlk','stlk','http://rfregions.ru/stalker/?xid=HbxG0MHv', '1.31','63074'),
// array ('sumr','sumr','http://rfregions.ru/sumerki/?xid=HbxG0MHv', '1.31','63075'),
// array ('tank','tank','http://rfregions.ru/panzer/?xid=HbxG0MHv', '1.31','63076'),
// array ('trns','trns','http://rfregions.ru/transformers/?xid=HbxG0MHv', '1.31','63077'),
// array ('unvr','unvr','http://rfregions.ru/univer/?xid=HbxG0MHv', '1.31','63078'),
// array ('wow','wow','http://rfregions.ru/wow/?xid=HbxG0MHv', '1.31','63079'),
// array ('zshk','zshk','http://rfregions.ru/shkola/?xid=HbxG0MHv', '1.31','63080'),



// представляемся
$user_agent = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/13.0.782.220 Safari/535.1";

// имя файла для хранения кукис
$cookie_file = "cookie.txt";

// счетчик созданных кампаний и тизеров
$campCounter = 0;
$teaserCounter = 0;
 

// ======================================
// авторизация
// ======================================
// echo  _login($login, $pass);
_login($login, $pass);


// ======================================
// запускаем проход для создания игровых кампаний (крутится не все время!) с БЛ и тематикой - просто игры
// ======================================

	// echo '<pre>';
	// print_r($campsURLArray);
	// echo '</pre>';
/* 
foreach ($campsURLArray as $key => $campLine)
	{
	// получим каталог и ссылку для кампании
	$teaserDir = $campLine[0];
	$campNameRu = $campLine[1];
	$teaserLink = $campLine[2];
	$price = $campLine[3];
	$campIDdefault = $campLine[4];
	
	// если добавляем кучу тизеров
	if (isset($teaserNumUpload) == false){
		// создаем имя кампании из каталога и текущей даты
		// $campName = iconv("UTF-8", "Windows-1251", $campNameRu) . '-' . date("dm");
		$campName = iconv("UTF-8", "Windows-1251", $campNameRu);
		echo '<br /><br />Making new camp: ' . $campName;
		// формируем и отправляем POST запрос, после чего получаем ID созданной кампании
		$postNewCamp = 'camp_name=' . $campName . '&terms=29&platform%5B%5D=3&platform%5B%5D=2&platform%5B%5D=1&platform%5B%5D=4&target_places%5B%5D=RU&target_places%5B%5D=RU77&target_places%5B%5D=RU50&target_places%5B%5D=RU78&target_places%5B%5D=RU47&target_places%5B%5D=RU01&target_places%5B%5D=RU04&target_places%5B%5D=RU22&target_places%5B%5D=RU28&target_places%5B%5D=RU29&target_places%5B%5D=RU30&target_places%5B%5D=RU02&target_places%5B%5D=RU31&target_places%5B%5D=RU32&target_places%5B%5D=RU03&target_places%5B%5D=RU33&target_places%5B%5D=RU34&target_places%5B%5D=RU35&target_places%5B%5D=RU36&target_places%5B%5D=RU05&target_places%5B%5D=RU79&target_places%5B%5D=RU75&target_places%5B%5D=RU37&target_places%5B%5D=RU06&target_places%5B%5D=RU38&target_places%5B%5D=RU07&target_places%5B%5D=RU39&target_places%5B%5D=RU08&target_places%5B%5D=RU40&target_places%5B%5D=RU41&target_places%5B%5D=RU09&target_places%5B%5D=RU10&target_places%5B%5D=RU42&target_places%5B%5D=RU43&target_places%5B%5D=RU11&target_places%5B%5D=RU44&target_places%5B%5D=RU23&target_places%5B%5D=RU24&target_places%5B%5D=RU45&target_places%5B%5D=RU46&target_places%5B%5D=RU48&target_places%5B%5D=RU49&target_places%5B%5D=RU12&target_places%5B%5D=RU13&target_places%5B%5D=RU51&target_places%5B%5D=RU83&target_places%5B%5D=RU52&target_places%5B%5D=RU53&target_places%5B%5D=RU54&target_places%5B%5D=RU55&target_places%5B%5D=RU56&target_places%5B%5D=RU57&target_places%5B%5D=RU58&target_places%5B%5D=RU59&target_places%5B%5D=RU25&target_places%5B%5D=RU60&target_places%5B%5D=RU61&target_places%5B%5D=RU62&target_places%5B%5D=RU63&target_places%5B%5D=RU64&target_places%5B%5D=RU14&target_places%5B%5D=RU65&target_places%5B%5D=RU66&target_places%5B%5D=RU15&target_places%5B%5D=RU67&target_places%5B%5D=RU26&target_places%5B%5D=RU68&target_places%5B%5D=RU16&target_places%5B%5D=RU69&target_places%5B%5D=RU70&target_places%5B%5D=RU71&target_places%5B%5D=RU17&target_places%5B%5D=RU72&target_places%5B%5D=RU18&target_places%5B%5D=RU73&target_places%5B%5D=RU27&target_places%5B%5D=RU19&target_places%5B%5D=RU86&target_places%5B%5D=RU74&target_places%5B%5D=RU20&target_places%5B%5D=RU21&target_places%5B%5D=RU87&target_places%5B%5D=RU89&target_places%5B%5D=RU76&cost=' . $price . '&operator%5B%5D=1&operator%5B%5D=2&operator%5B%5D=3&operator%5B%5D=4&operator%5B%5D=5&operator%5B%5D=6&operator%5B%5D=7&operator%5B%5D=0&browser%5B%5D=2&browser%5B%5D=4&browser%5B%5D=3&browser%5B%5D=1&browser%5B%5D=0&buy_alien=1&list=' . $blacklist .'&target_days%5B%5D=2&target_days%5B%5D=3&target_days%5B%5D=4&target_days%5B%5D=5&target_days%5B%5D=6&target_days%5B%5D=7&target_days%5B%5D=1&target_hours%5B%5D=14&target_hours%5B%5D=15&target_hours%5B%5D=16&target_hours%5B%5D=17&target_hours%5B%5D=18&target_hours%5B%5D=19&target_hours%5B%5D=20&target_hours%5B%5D=21&target_hours%5B%5D=22&target_hours%5B%5D=23&limit_day=0&camp_id=&submit=1';
		
		// удаленные часы показов
		// &target_hours%5B%5D=10&target_hours%5B%5D=11&target_hours%5B%5D=12&target_hours%5B%5D=13
		
		
		$newCamp = postsend('https://visitweb.com/camps.php?edit', $postNewCamp);
		preg_match('@href="/ads.php.camp\=(.*?)\&edit">@', $newCamp, $newCampID);
		$campID = $newCampID[1];
		$campCounter++;
		}
	
	// если добавляем по одному тизеру
	else {
		$campID = $campIDdefault;
		echo "<br /><br /><h2>Add to campaign: " . $campName . " ID: " . $campID . '</h2>'; ob_flush(); flush();
		}
	
	// загрузим в массив файл с текстами тизеров и локальными адресами картинок
	$teaserTextArray = file (getcwd() . '\teasers\\' . $teaserDir . '\texts.txt');
	// почистим массив от пустых строк, и строк, кажущимися пустыми
	$teaserTextArray = array_diff($teaserTextArray, array(''));
	$teaserTextArray = array_diff($teaserTextArray, array("\n"));
	$teaserTextArray = array_diff($teaserTextArray, array("\r"));
	$teaserTextArray = array_diff($teaserTextArray, array("\r\n"));
	$teaserTextArray = array_diff($teaserTextArray, array("\n\r"));
	$teaserTextArray = array_unique($teaserTextArray);
	
	// ======================================
	// проход базы тизеров
	// ======================================
	// если задана переменная $teaserNumUpload, обрежем массив тизера до одного 

	if (isset($teaserNumUpload) == true){
	// echo "<h1>$teaserNumUpload</h1>";
		$teaserTextArray = array($teaserTextArray["$teaserNumUpload"]);
		}
		
	// echo '<pre>';
	// print_r($teaserTextArray);
	// echo '</pre>';
	

	foreach ($teaserTextArray as $key => $teaserLine)
		{
		$wait = rand(3,7);
		echo '<br />Pause: ' . $wait;
		sleep($wait);
		$counterWait += $wait;
		// для экстренной остановки скрипта создайте в том же каталоге stop.txt красного цвета!
		if (file_exists("stop.txt")) {	exit();	}
		// получим текст тизера - все после первой точки с запятой
		$textLine = trim(substr($teaserLine, stripos($teaserLine, ';')+1));
		// удалим вторую точку с запятой - в исходном тексте это разделитель заголовка и текста
		$textLine = str_ireplace(';','',$textLine);
		// обрежем текст по словам
		$textLine = truncate_words($textLine, $limit=90);
		// преобразуем кодировку
		$textLine = iconv("UTF-8", "Windows-1251", $textLine);
		// получим адрес локальной картинки
		$imgLine = trim(substr($teaserLine, 0, stripos($teaserLine, ';')));
		$imgPath = '/teasers/' . $teaserDir . '/' . $imgLine;
		$imgPathUpload = getcwd() . '\teasers\\' . $teaserDir . '\\' . $imgLine;
		echo '. Making new teaser: ' . $textLine;
		// создадим POST запрос и отправим его
		$postNewTeaser = array(  
		   'img_file' => '@'.$imgPathUpload,
		   'filename'  => "",
		   'camp'  => $campID,
		   'text'  => $textLine,
		   'url_link'  => $teaserLink,
		   'ad'  => '',
		   'submit'  => '1',
			);
		$newTeaser = postsend('https://visitweb.com/ads.php', $postNewTeaser);
		
		// получим статистику - ID тизера
		preg_match('@<a href="/ads.php.camp=(.*?)edit.(.*?)".title@', $newTeaser, $teaserID);
		$teaserID = $teaserID[2];
		$teaserCounter++;
		ob_flush(); flush();
		}
	ob_flush(); flush();

	}
 */
 
// адрес загрузки тизеров
// http://medianet.adlabs.ru/site/Tizer/?campaign_id=131904

// удаление тизера
// http://medianet.adlabs.ru/site/TizerList/?fstatus=all&sort=tizer_id&order=asc&interval=day&campaign_id=131904&start_date=26.12.2012&end_date=09.01.2013&redax=y
// redax=y&page=1&campaign_id=131904&fstatus=all&re_url1=&re_url2=&re_comm=&fcontentcat=&item_id%5B2640178%5D=2640178


// получим fliss 87cbd4b4425e12d7b21cc47a4b4aad6d

	// получение fliss
	$mainPage = load_page('http://medianet.adlabs.ru/site/Tizer/?campaign_id=131904', $headers = false, $reff ='');
	
	preg_match('@<input type="hidden" name="fliss" value="(.*)"><fieldset>@', $mainPage, $fliss);
	$fliss = $fliss[1];
	
	preg_match('@<input type="text" class="txt link" id="url" name="tizer\[1\]\[(.*)\]"@', $mainPage, $linkAdlabs);
	$linkAdlabs = $linkAdlabs[1];
	// <p><label for="url">Ссылка:</label><input type="text" class="txt link" id="url" name="tizer[1][Ee1d5ab05]" value=""></p>
	
	
	preg_match('@<input type="text" class="txt link" id="redirect_url" name="tizer\[1\]\[(.*)\]@', $mainPage, $urlAfterRedir);
	$urlAfterRedir = $urlAfterRedir[1];
	// <p class="redirect_url_class" style="display:none"><label for="redirect_url">URL после редиректа:</label><input type="text" class="txt link" id="redirect_url" name="tizer[1][E217cfba5]" value=""></p>
	
	preg_match('@<textarea class="teaser" id="anons" name="tizer\[1\]\[(.*)\]@', $mainPage, $textAdlabs);
	$textAdlabs = $textAdlabs[1];
	// <p><label for="anons">Текст:</label><textarea class="teaser" id="anons" name="tizer[1][E90543697]" onkeyup="crop_input(this, 75);"></textarea></p>
	
	
	echo "<br />fliss: $fliss";
	echo "<br />linkAdlabs: $linkAdlabs";
	echo "<br />urlAfterRedir: $urlAfterRedir";
	echo "<br />textAdlabs: $textAdlabs";

	$imgPathUpload = '41.jpg';
	// ======================================
	// создаем тизер
	// ======================================
	// https://visitweb.com/ads.php
	$header = array('(Request-Line):POST /site/Tizer/save HTTP/1.1',
'Host:medianet.adlabs.ru',
'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0',
'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
'Accept-Encoding:gzip, deflate',
'Referer:http://medianet.adlabs.ru/site/Tizer/?campaign_id=131904',
'Cookie:__utma=251457818.853538359.1358323921.1359616055.1359618445.5; __utmz=251457818.1358323921.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none); __utmc=251457818; ___UID=4f8c6cfac55a168c4dde984b3c432993; start_date=17.01.2013; end_date=31.01.2013; interval=day; __utmb=251457818; PHPSESSID=53d97c860ab98a8399ef9bc5502e68df',
'Connection:keep-alive',
'Content-Type:multipart/form-data; boundary=---------------------------1772866273190',
'Content-Length:18966');

	
	$postNewTeaser = array(  
	   'fliss'  => $fliss,
	   'tizer[1][tizer_id]'  => '',
	   'campaign_id'  => '131904',
	   'tizer[1][targeting_id]'  => '3',
	   'tizer[1][temp_image1]'  => '',
	   'tizer[1][content_cat_type]'  => '1',
	   'tizer[1][absolute_counter]'  => '1',
	   'tizer[1][image1]' => '@'.$imgPathUpload,
	   'tizer[1][' . $linkAdlabs . ']'  => 'http://rfregions.ru/sims4/?xid=HbxG0MHv',
	   'tizer[1][' . $urlAfterRedir . ']'  => '',
	   'tizer[1][' . $textAdlabs . ']'  => 'SIMS4 Forever online!',
	   'old_tizer[1][content_cat_id]'  => '27',
	   'tizer[1][content_cat_id]'  => '29',
	   'tizer[1][cpc]'  => '1.3'
		);
/* 
		fliss                         b21e9a7abd242d37d6c7930c9b9b86d5                                                             32     
tizer[1][tizer_id]                                                                                                         0      
campaign_id                   131904                                                                                       6      
tizer[1][targeting_id]        3                                                                                            1      
tizer[1][temp_image1]                                                                                                      0      
tizer[1][content_cat_type]    1                                                                                            1      
tizer[1][absolute_counter]    1                                                                                            1      
tizer[1][image1]              <Place Holder for File>                              15.jpg    Content-Type: image/jpeg

  17224  
tizer[1][Ef694c5e8]           http://rfregions.ru/sims4/?xid=HbxG0MHv                                                      39     
tizer[1][E14940db3]                                                                                                        0      
tizer[1][E853f575c]           Ð¡Ð°Ð¼Ð°Ñ Ð·Ð°Ð¿Ñ€ÐµÑ‚Ð½Ð°Ñ Ð¸Ð³Ñ€Ð° Ð² Ð¼Ð¸Ñ€Ðµ!                                          51     
old_tizer[1][content_cat_id]  27                                                                                           2      
tizer[1][content_cat_id]      29                                                                                           2      
tizer[1][cpc]                 1.5                                                                                          3      
 */
		
	// $newTeaser = postsendMultipart('http://medianet.adlabs.ru/site/Tizer/?campaign_id=131904', $postNewTeaser);
	$newTeaser = postsendMultipart('http://medianet.adlabs.ru/site/Tizer/save', $postNewTeaser, $header);
echo $newTeaser;


// вывод статистики по работе скрипта
// echo load_page('http://medianet.adlabs.ru/site/?act=logout', $headers = false, $reff ='');
echo '<br />logout...done: ';
echo '<br /><br />Added new camps: ' . $campCounter;
echo '<br />Added new teasers: ' . $teaserCounter;
echo '<br />Pause time: ' . $counterWait;
echo '<br /><br />Exec time: ' . round((microtime(true) - $mtime) * 1, 4) . ' s.';



// ======================================
// вывод страницу кампаний
// ======================================
// echo load_page('https://visitweb.com/camps.php', $headers = false, $reff ='');

// ======================================
// ставим кампанию на паузу https://visitweb.com/camps.php?pause=55839 или плэй https://visitweb.com/camps.php?play=55842
// ======================================
// load_page('https://visitweb.com/camps.php?pause=' . $campID, $headers = false, $reff ='');

// echo "<pre>";
// print_r($teaserTextArray);
// echo "</pre>";


?>