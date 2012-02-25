<?php
error_reporting(E_ALL);
session_start();
ob_start("ob_gzhandler");

header('HTTP/1.1 200 OK');
header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
// header('Content-Type: application/json;charset=UTF-8');
header('Content-Type: text/plain;charset=UTF-8');
header('Age: 0');

$hh = new HittaHjalpenCore();
$hh->getParams();

switch ($hh->param) {
	case "ping" :
		$result = $hh->ping();
		break;
	case "getcities" :
		$result = $hh->getCities();
		break;
	case "gettags" :
		$result = $hh->getTags();
		break;
	case "getuserrate" :
		$result = $hh->getUserRate();
		break;
	case "getuserratelist" :
		$result = $hh->getUserRateList();
		break;
	case "getadvertslatest" :
		$result = $hh->getAdvertsLatest();
		break;
		
	case "gettagssearch" :
		$result = $hh->getTagsSearch();
		break;
	case "gethelpersfromtag" :
		$result = $hh->getHelpersFromTag();
		break;
	
	case "testmail" :
		$result = $hh->testmail();
		break;
		
	default :
		$result = $hh->getCities();
		
		//$result = array('status'=>'error','error'=>'unknown command given');
		break;
}

unset($hh);
if(version_compare(PHP_VERSION, '5.3.0', '>=')) {
	$json_result = json_encode($result,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
} else {
	$json_result = json_encode($result);
}
die($json_result);


class HittaHjalpenCore {
	public $user_id = null;
	public $user_name = null;
	public $user_email = null;
	
	public $param = null;
	public $params = array();
	
	
	function __construct() {
	}
	
	function __destruct() {
	}

	public function testmail() {
		ini_set("SMTP","smtp34.webbpost.se" ); 
		ini_set('sendmail_from', 'info@xn--hittahjlpen-r8a.se');
		$r = $this->doTehMailz("HittaHjälpen<info@xn--hittahjlpen-r8a.se>","christopher.isene@gmail.com","DO Y U HEAR ME?!","msgbody... <b>bold</b> .. <i>italic</i> .. <blink>blink</blink>");
		return array('status'=>'fuckyeah!','mail says'=>$r);
	}
	
	public function getParams() {
		$uri = $_SERVER['REQUEST_URI'];
		$cleaned = preg_replace('/^\x2fapi\x2fv\d{1,}/six',"",$uri);
		$cleaned = preg_replace('/^\x2fapi\x2ephp/six',"",$cleaned);
		$cleaned = preg_replace('/^\x2f/six',"",$cleaned);
		
		if(preg_match('/\x2f/',$cleaned)) {
			$this->params = preg_split('/\x2f/',$cleaned);
			$result = $this->params[0];
		} else {
			$result = $cleaned;
		}
		
		switch ($result) {
			case "testmail" :
			case "getadvertslatest" : 
			case "getuserratelist" : 
			case "getuserrate" :
			case "gettags" :
			case "gethelpersfromtag" :
			case "gettagssearch" :
			case "getcities" :
			case "ping" :
				$this->param = $result;
				break;
			default :
				$this->param = "unknown";
				break;
		}
		return;
	}
	
	public function ping() {
		$result = array(
			'ip'	=>	$_SERVER['REMOTE_ADDR'],
			'time'	=>	time('i'),
		);
		return $this->utf8_encode_all($result);
	}
		
	public function getTags() {
		$this->DBconnect();
		$query = "SELECT tag_id AS id, tag_value AS name FROM tags WHERE tag_approved = 1 ORDER BY tag_value ASC";
		$stmt = $this->pdh->prepare($query);
		$stmt->execute();
		$tags_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		return array('status'=>'success','list'=>$this->utf8_encode_all($tags_list));
	}
	
	public function getCities() {
		$this->DBconnect();
		if(isset($this->params[1]) && isset($this->params[2])) {
			$query = "
				SELECT
					location_id AS id,
					location_name AS name,
					location_county AS county,
					ROUND((fnDistance(:lat_pos_1,:lon_pos_1,location_latitude,location_longitude) / 1000),1) AS dist
				FROM
					locations
				WHERE
					fnDistance(:lat_pos_2,:lon_pos_2,location_latitude,location_longitude) <= 25000
				ORDER BY
					dist ASC,
					location_county ASC,
					location_name ASC
			";
			$stmt = $this->pdh->prepare($query);
			$stmt->bindParam(":lat_pos_1", floatval( $this->params[1] ));
			$stmt->bindParam(":lon_pos_1", floatval( $this->params[2] ));
			$stmt->bindParam(":lat_pos_2", floatval( $this->params[1] ));
			$stmt->bindParam(":lon_pos_2", floatval( $this->params[2] ));
			$stmt->execute();
			$distances_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$query = "
				SELECT
					location_id AS id,
					location_name AS name,
					location_county AS county,
					'0.0' AS dist
				FROM
					locations					
				ORDER BY
					dist ASC,
					location_county ASC,
					location_name ASC
			";
			$stmt = $this->pdh->prepare($query);
			$stmt->execute();
			$distances_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		$stmt->closeCursor();
		$this->DBdisconnect();
		return array('status'=>'success','list'=>$this->utf8_encode_all($distances_list));
	}

	public function getHelpersFromTag() {
		$this->DBconnect();
		$result = array();
		$query = "
			SELECT
				a.advert_id AS id,
				a.advert_text AS text,
				u.user_id AS user_id,
				u.user_name AS user_name,
				t.tag_value AS value,
				l.location_county AS county,
				l.location_municipality AS municipality,
				l.location_name AS location,
				ROUND(fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) / 1000,1) AS dist
			FROM
				adverts a
			LEFT JOIN users u ON u.user_id = a.user_id
			LEFT JOIN tags t ON t.tag_id = a.tag_id
			LEFT JOIN locations l ON l.location_id = a.location_id
			LEFT JOIN locations sl ON sl.location_id = :location_id
			WHERE
				a.tag_id = :tag_id
			AND
				u.user_name IS NOT NULL
			AND
				fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) <= 25000
			ORDER BY
				fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) ASC
			LIMIT 250
		";
		$stmt = $this->pdh->prepare($query);
		$stmt->bindParam(":location_id", intval( $this->params[1] ));
		$stmt->bindParam(":tag_id", intval( $this->params[2] ));
		$stmt->execute();
		$hitlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		foreach($hitlist as $hit) {
			$result[] = array(
				'id'			=>	$hit['id'],
				'text'			=>	$hit['text'],
				'user_id'		=>	$hit['user_id'],
				'user_name'		=>	$hit['user_name'],
				'value'			=>	$hit['value'],
				'county'		=>	$hit['county'],
				'municipality'	=>	$hit['municipality'],
				'location'		=>	$hit['location'],
				'dist'			=>	$hit['dist'],
			);
		}
		return $this->utf8_encode_all($result);
		
		
	}
	
	public function getTagsSearch() {
		$this->DBconnect();
		$result = array();
		$tags = array();
		$query = "
			SELECT
				tag_id AS id,
				tag_value AS label,
				tag_value AS value
			FROM
				tags t
			WHERE
				t.tag_value LIKE :term
			AND
				t.tag_approved = 1
			ORDER BY
				t.tag_value ASC
			LIMIT 1000
		";
		$query = preg_replace('/\x3aterm/six',"'%" . trim(preg_replace('/\x3f(.*)$/six','',$this->params[1])) . "%'",$query);
		
		// echo($this->params[1]);
		
		// $query = preg_replace('/\x3alocation\x5fid/six',intval($this->params[2]),$query);

		$stmt = $this->pdh->prepare($query);
		$stmt->execute();
		$taglist = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		
		/* Rewrite array to get rid of pesky wrapping in another array (from db-object) */
		foreach($taglist as $tag) {
			$tags[] = array(
				'id'=>$tag['id'],
				'label'=>$tag['label'],
				'value'=>$tag['value'],
			);
		}
		return $this->utf8_encode_all($tags);
	}
	
	public function getAdvertsLatest() {
		$this->DBconnect();
		$result = array();
		$tags = array();
		$query = "
			SELECT
				t.tag_id AS id,
				CASE WHEN fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) < 1000 THEN CONCAT(t.tag_value,' i ', l.location_name) ELSE t.tag_value END AS label,
				t.tag_value AS value,
				ROUND(fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) / 1000,1) AS dist
			FROM
				adverts a
			LEFT JOIN tags t ON t.tag_id = a.tag_id AND t.tag_approved = 1
			LEFT JOIN locations l ON l.location_id = a.location_id
			LEFT JOIN locations sl ON sl.location_id = :location_id
			WHERE
				t.tag_value LIKE :term
			AND
				fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) <= 20000
			ORDER BY
				fnDistance(l.location_latitude,l.location_longitude,sl.location_latitude,sl.location_longitude) ASC,
				t.tag_value ASC
			LIMIT 1000

        ";
		$query = preg_replace('/\x3aterm/six',"'%" . trim($this->params[1]) . "%'",$query);
		$query = preg_replace('/\x3alocation\x5fid/six',intval($this->params[2]),$query);
		// echo($query . "\n");

		$stmt = $this->pdh->prepare($query);
		// $stmt->bindParam(":term", trim($this->params[1]));
		// $stmt->bindParam(":location_id", intval( $this->params[2] ));
		$stmt->execute();
		$taglist = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		
		foreach($taglist as $tag) {
			$tags[] = array(
				'id'=>$tag['id'],
				'label'=>$tag['label'],
				'value'=>$tag['value'],
			);
		}
		return $this->utf8_encode_all($tags);
		return array('status'=>'success','list'=>$this->utf8_encode_all($tags));
	}

	public function getUserRate() {
		$this->DBconnect();
		$query = "
			SELECT
				ROUND(AVG(rated),1) AS rate
			FROM
				users_rates
			WHERE
				user_id = :user_id
		";
		$stmt = $this->pdh->prepare($query);
		$stmt->bindParam(":user_id", intval( $this->params[1] ));
		$stmt->execute();
		$user_rate = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		return array('status'=>'success','user_rate'=>$this->utf8_encode_all($user_rate));
	}

	public function getUserRateList() {
		$this->DBconnect();
		$query = "
			SELECT
				ur.row_id AS id,
				ur.comment AS rate_comment,
				IFNULL(u.user_id,0) AS ratee_id,
				IFNULL(u.user_name,'Unknown') AS ratee_name,
				CASE WHEN ur.rated = 1 THEN '/images/happyface.jpg' ELSE '/images/sadface.jpg' END AS rate_indicator
			FROM
				users_rates ur
			LEFT JOIN users u ON u.user_id = ur.rated_by_user_id
			WHERE
				ur.user_id = :user_id
			ORDER BY
				ur.row_id DESC
			LIMIT 50
		";
		$stmt = $this->pdh->prepare($query);
		$stmt->bindParam(":user_id", intval( $this->params[1] ));
		$stmt->execute();
		$user_rate = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		return array('status'=>'success','rated_list'=>$this->utf8_encode_all($user_rate));
	}
	
	private function utf8_encode_all($data) { 
		if (is_string($data)) return utf8_encode($data); 
		if (!is_array($data)) return $data; 
		$ret = array(); 
		foreach($data as $i=>$d) $ret[$i] = $this->utf8_encode_all($d); 
		return $ret; 
	}	

	private function DBconnect() {
		if(!preg_match('/^127\x2e0\x2e0\x2e1$/',$_SERVER['REMOTE_ADDR'])) {
		  $this->pdh = new PDO("mysql:host=mysql34.kontrollpanelen.se;dbname=web36942_hittahjalpen", "web36942_stoffe", "HKjH23nixEfter17");
		} else {
			try {
				$this->pdh = new PDO("mysql:host=mysql34.kontrollpanelen.se;dbname=web36942_hittahjalpen", "web36942_stoffe", "HKjH23nixEfter17",array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_TIMEOUT => 15));
			}
			catch(Exception $e) {
				die("Could not connect to database");
			}
		}
	}
	
	private function DBdisconnect() {
		unset($this->pdh);
	}
	
	private function doTehMailz($sender,$receiver,$subject,$messagebody) {
		/* Add headers */
		$emailHeaders  = 'MIME-Version: 1.0' . "\r\n";
		$emailHeaders .= 'Content-Type: text/html;charset=UTF-8' . "\r\n";
		$emailHeaders .= 'X-Originating-IP: ' . $_SERVER['REMOTE_ADDR'] . "\r\n";
		$emailHeaders .= 'From: ' . $sender . "\r\n";

		if(!mail($receiver, $subject, $messagebody, $emailHeaders)) {
			return false;
		} else {
			return true;
		}
	}
}