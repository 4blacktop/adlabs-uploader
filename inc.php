<?php


function _login($login, $pass)
    {
		$post = "act=login&ppxx=53e84f4c4777b77aa1b6d620bfe43a14&redirect=&email=4blacktop%40gmail.com&pass=vVv19071958";
		$page = postsend('http://medianet.adlabs.ru/site/CampaignList/', $post);
		// echo 'page: ' . $page;
		if(stristr($page, 'true'))
		    return true;
	    return false;
	}
	
	
	
function load_page($host, $headers = false, $reff =''){
global $cookie_file, $user_agent, $proxy;
$ch=curl_init();
  curl_setopt($ch, CURLOPT_URL, $host);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_ENCODING,'gzip,deflate');
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_TIMEOUT,        30);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  if ($reff)
    curl_setopt($ch, CURLOPT_REFERER, $reff);
  curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
  if($proxy)
    curl_setopt($ch, CURLOPT_PROXY, $proxy);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
  if ($headers)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  
  $ok = curl_exec($ch);
  // $ok = str_ireplace ('/css/style.css','https://visitweb.com/css/style.css',$ok);
  // $ok = str_ireplace ('src="','src="https://visitweb.com/',$ok);
	curl_close($ch);
  return $ok;

}

function postsend($host, $post, $headers = false,  $reff = ''){
global $cookie_file, $user_agent, $proxy;
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_ENCODING,'gzip,deflate');
    curl_setopt($ch, CURLOPT_TIMEOUT,        30);
	if ($reff)
      curl_setopt($ch, CURLOPT_REFERER, $reff);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    if($proxy)
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file);
    curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
	  if ($headers)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	#curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Expect:' ) );
		$ok = curl_exec($ch);
		// $ok = str_ireplace ('/css/style.css','https://visitweb.com/css/style.css',$ok);
		// $ok = str_ireplace ('src="','src="https://visitweb.com/',$ok);
		curl_close($ch);
		//$reff=$host;
 return $ok;
}

 
 
function postsendMultipart($host, $post, $headers = false,  $reff = ''){
global $cookie_file, $user_agent, $proxy;
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL, $host);
 
 
 
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_ENCODING,'gzip,deflate');
    curl_setopt($ch, CURLOPT_TIMEOUT,        30);
	if ($reff)
      curl_setopt($ch, CURLOPT_REFERER, $reff);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    if($proxy)
      curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file);
    curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
	  if ($headers)
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	#curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Expect:' ) );
		$ok = curl_exec($ch);
		// $ok = str_ireplace ('/css/style.css','https://visitweb.com/css/style.css',$ok);
		// $ok = str_ireplace ('src="','src="https://visitweb.com/',$ok);
		curl_close($ch);
		//$reff=$host;
 return $ok;
}



function truncate_words($text, $limit=200)
{
	$text=mb_substr($text,0,$limit);
	/*если не пустая обрезаем до  последнего  пробела*/
	if(mb_substr($text,mb_strlen($text)-1,1) && mb_strlen($text)==$limit)
	{
		$textret=mb_substr($text,0,mb_strlen($text)-mb_strlen(strrchr($text,' '))).'...';
		if(!empty($textret))
		{
			return $textret;
		}
	}
	return $text;
}




  /* 
function preg($i, $result)
 {
  preg_match ('|'.$i.'|is' , $result, $r);
  return $r[1];
 }


 function wr($data)
  {
    $fg = fopen("html.html", "w+");
	fputs($fg, $data);
	fclose($fg);
	return 1;
  }
 
 function w_log($str)
  {
    $fg = fopen("log.txt", "a+");
	fputs($fg, "[".$_SERVER['SCRIPT_NAME']."] ".date("H:i:s")." >> ".$str."\n");
	fclose($fg);
	return 1;
  }
  
 */
	$h_2 = array(
'Accept:text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
'Accept-Language:ru-RU,ru;q=0.9,en;q=0.8',
'Accept-Charset:iso-8859-1, utf-8, utf-16, *;q=0.1',
'Accept-Encoding:deflate, identity, *;q=0',
'Connection:Keep-Alive',
'Content-Type:application/x-www-form-urlencoded',
'Expect:'
);

	   $h_1 = array(
'Accept:text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
'Accept-Language:ru-RU,ru;q=0.9,en;q=0.8',
'Accept-Charset:iso-8859-1, utf-8, utf-16, *;q=0.1',
'Accept-Encoding:deflate, identity, *;q=0',
'Connection:Keep-Alive'
);

	   $h_ajax_post = array(
'Accept:text/html, application/xml;q=0.9, application/xhtml+xml, image/png, image/jpeg, image/gif, image/x-xbitmap, */*;q=0.1',
'Accept-Language:ru-RU,ru;q=0.9,en;q=0.8',
'Accept-Charset:iso-8859-1, utf-8, utf-16, *;q=0.1',
'Accept-Encoding:deflate, identity, *;q=0',
'Connection:Keep-Alive',
'Content-Type:application/x-www-form-urlencoded',
'X-Requested-With:XMLHttpRequest'  
  );
  

?>