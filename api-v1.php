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

echo($_SERVER['DOCUMENT_ROOT'] . "<br />" . $_SERVER['REQUEST_URI'] . "<br />");

$hh = new HittaHjalpenCore();
$hh->getParams();

switch ($hh->param) {
	case "ping" :
		$result = $hh->ping();
		break;
	case "getcity" :
		$result = $hh->getCity();
		break;
	
	default :
		$result = array('status'=>'error','error'=>'unknown command given');
		break;
}

unset($hh);
if(version_compare(PHP_VERSION, '5.3.0', '>=')) {
	$json_result = json_encode($result,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
} else {
	$json_result = json_encode($result);
}
die($json_result);

// die(json_encode($result,JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP));


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

	public function getParams() {
		$uri = $_SERVER['REQUEST_URI'];
		header('X-uri: ' . $uri);
		$cleaned = preg_replace('/^(\x2fapi\x2fv\d{1,}|\x2fapi\x2dv1\x2ephp)/six',"",$uri);
		$cleaned = preg_replace('/^\x2f/six',"",$cleaned);
		if(preg_match('/\x2f/',$cleaned)) {
			$this->params = preg_split('/\x2f/',$cleaned);
			$result = $this->params[0];
		} else {
			// $this->params[0] = $cleaned;
			$result = array($cleaned);
		}
		
		switch ($result) {
			case "getcity" :
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
		$query = "";
		$stmt = $this->pdh->prepare($query);
		$stmt->bindParam(":lat_pos_1", double ( $this->params[1] ));
		$stmt->execute();
		$distances_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		$this->DBdisconnect();
		return array('status'=>'success','list'=>$this->utf8_encode_all($distances_list));
	}
		
	
	public function getCity() {
		$this->DBconnect();
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
		$stmt->closeCursor();
		$this->DBdisconnect();
		return array('status'=>'success','list'=>$this->utf8_encode_all($distances_list));
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
	
	
}