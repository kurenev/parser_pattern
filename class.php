<?
error_reporting(E_ALL^E_NOTICE^E_STRICT);
session_start();
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_pass = 'ghCCVn333OOrt';
$mysql_db = 'tools_parser_pattern';

mysql_connect($mysql_host, $mysql_user, $mysql_pass);
mysql_select_db($mysql_db);
mysql_query('SET NAMES `utf-8`');

if($_POST['check_inserts'])
{
	$string = $_POST['title'].$_POST['description'].$_POST['keywords'];
	preg_match_all('#\{([^\}]+)\}#', $string, $ar_insert);
	$ar_insert = array_slice($ar_insert, 1);
	$ar_insert = array_unique($ar_insert[0]);
	echo json_encode($ar_insert);
}

if($_POST['our_site'])
{
	$arAnswer = get_headers(trim($_POST['our_site']), 1);
	preg_match('#^HTTP/1\.\d (\d\d\d)#',$arAnswer[0], $matches);
	$status = $matches[1];
	switch (substr($status, 0, 1))
	{
		case '2':
			/*$query = 'SELECT `ID` FROM `sites` WHERE `site`="'.$_POST['our_site'].'"';
			$res = mysql_query($query);
			if($res and mysql_num_rows($res)<1)
			{
				$query = 'INSERT INTO `sites` (`timestamp`, `sessid`, `site`) values ('.time().', "'.session_id().'", "'.$_POST['our_site'].'")';
				if(!mysql_query($query))
					echo mysql_error();
			}
			$query = 'SELECT `ID` FROM `sites` WHERE `site`="'.$_POST['our_site'].'" ORDER BY `id` desc LIMIT 1';
			$res = mysql_query($query);
			$result = mysql_fetch_assoc($res);*/
			$_SESSION['site'] = $_POST['our_site'];
			echo '1';
			break;
		case '3':
			echo $arAnswer['Location'];
			break;
		default:
			echo $status;
	}
}

if($_POST['copy_sitemap'])
{
	if(substr($_POST['copy_sitemap'], -1)=='/')
		$site = $_POST['copy_sitemap'];
	else
		$site = $_POST['copy_sitemap'].'/';
	$domain = $_SESSION['site'];
	if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/'))
		mkdir($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/', 0777, 1);
	copy($site.'sitemap.xml', $_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/'.'sitemap.xml');

	/*$query = 'DELETE FROM `pages` WHERE `site_id`='.$_SESSION['site_id'];
	mysql_query($query);
	$query = 'ALTER TABLE `pages` AUTO_INCREMENT=1';
	mysql_query($query);*/
}

if($_POST['get_50link_from_sitemap'])
{
	$count = -1;
	$min_number_link = (int)$_POST['num'] * 50;
	$max_number_link = $min_number_link + 50;
	
	$return['links'] = Array();
	
	$domain = str_replace(Array('http', ':', '/', 'www.'), Array('', '', '', ''), $_POST['get_50link_from_sitemap']);

	if(is_file($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/sitemap.xml'))
	{
		$res = fopen($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/sitemap.xml', 'r');
		while($res and !feof($res))
		{
			$str = fgets($res);
			if(preg_match('#<loc>([^<]+)</loc>#i', $str, $matches))
			{
				$uri = explode('/', $matches[1], 4);
				$uri = '/'.$uri[3];
				$count ++;
				if($count >= $min_number_link and $count < $max_number_link )
				{
					$return['links'][] = $matches[1];
					$arLinks[] = Array(
						'link' => $uri,
						'hash' => myHash($uri),
					);
					
					/*$query = 'INSERT INTO `pages` (`site_id`, `uri`, `hash`) values ("'.$_SESSION['site_id'].'", "'.$uri.'", "'.myHash($uri).'")';
					if(!mysql_query($query))
						echo mysql_error();*/
				}
				elseif($count >= $max_number_link)
				{
					$arFileLink = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/links.dat'));
					if(!is_array($arFileLink))
						$arFileLink = Array();
					$arLinks = serialize(array_merge($arFileLink, $arLinks));
					file_put_contents($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/links.dat', $arLinks);
					die(json_encode(array_merge($return, Array('count'=>($min_number_link+count($return['links']))))));
				}
			}
		}
	}
	$arFileLink = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/links.dat'));
	if(!is_array($arFileLink))
		$arFileLink = Array();
	if(!is_array($arLinks))
		$arLinks = Array();
	
	$arLinks = serialize(array_merge($arFileLink, $arLinks));
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/links.dat', $arLinks);
	die(json_encode(array_merge($return, Array('count'=>($min_number_link+count($return['links']))))));
}

if($_POST['check_page'])
{
	$arAnswer = get_headers(trim($_POST['check_page']), 1);
	preg_match('#^HTTP/1\.\d (\d\d\d)#',$arAnswer[0], $matches);
	$status = $matches[1];
	if(substr($status, 0, 1)=='2')//первый символ от "200 OK"
		echo '1';
}

if($_POST['select_type_links']=='Y')
{
	/*$query = 'SELECT
				s.`site`,
				p.`uri`,
				p.`hash`
			FROM
				`pages` AS p
			LEFT JOIN
				`sites` AS s
			ON p.`site_id`=s.`id`
			WHERE
				p.`site_id` = '.$_SESSION['site_id'].' AND
				p.`hash`!="0000"
			GROUP BY
				`hash`';
	$res = mysql_query($query);
	while($result = mysql_fetch_assoc($res))
		$unique_links[] = Array('hash'=>$result['hash'], 'link'=>trim($result['site'], '/').$result['uri']);*/
	$arFileLink = unserialize(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/parser_meta_pattern/user_data/'.$_COOKIE['PHPSESSID'].'/'.$domain.'/links.dat'));
	$past_hash = Array();
	foreach($arFileLink as $arLink)
	{
		if(!in_array($arLink['hash'], $past_hash))
		{
			$unique_links[] = Array('hash'=>$arLink['hash'], 'link'=>trim($result['site'], '/').$arLink['link']);
			$past_hash[] = $arLink['hash'];
		}
	}
	echo json_encode($arFileLink);
	//echo '<pre>'.print_r( $unique_links , true).'</pre>';
}

function myHash($uri){
	$dictionary = Array(
		'',
		'catalog',
		'category',
		'product',
		'detail',
		'shop',
	);
	$pregMask = Array(
		'',
		"^\d+$",
		"\.html$",
		"\.php$",
	);
	
	$arUri = explode('?', $uri);
	$arUri = explode('/', trim($arUri[0], '/'));
	$hash = '';
	foreach($arUri as $uriItem)
	{
		$hash .= sprintf("%02u", array_search($uriItem, $dictionary));
		foreach($pregMask as $key => $maskItem)
			if(preg_match('#'.$maskItem.'#i', $uriItem))
				$maskKey = $key;
		$hash .= sprintf("%02u", $maskKey);
	}

	return $hash;
}
?>
