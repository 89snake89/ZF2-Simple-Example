<?php
namespace Prova\Model;

use Zend\Json\Json;

use Zend\Db\Sql\Sql;

use Zend\Db\Sql\Where;

use Zend\Authentication\Storage\Session;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Prova\Model;

class UserTable extends AbstractTableGateway
{
	protected $table ='user';

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		
		$this->resultSetPrototype->setArrayObjectPrototype(new User());
		//die("Sono passato");
		$this->initialize();
		
	}
	public function fetchUser($id){
		$user = $this->select(array("Id_User" => $id));
		//\Zend\Debug\Debug::dump($user);
		foreach ($user as $us){
			$params = array(
						"Id_User" => $us->Id_User,
						"Mail" => $us->Mail,
						"Psw" => "",
						"Nome" => $us->Nome,
						"Cognome" => $us->Cognome,
						"Tipo_Patente" => $us->Tipo_Patente,
						"Sesso" => $us->Sesso
					);
			//\Zend\Debug\Debug::dump($params);
		}
		$user = new User();
		$user->setData($params);
		//$jsonFile = json_encode($user->getArray());
		//$json = new Json($user->getArray());
		//\Zend\Debug\Debug::dump($json);
		//\Zend\Debug\Debug::dump(json_decode($jsonFile, true));
		//die();
		return $user;
	}
	public function fetchAll()
	{
		$session = new Session();
		$userLogged = $session->read()->Id_User;
		$adapter = $this->adapter;
		$sql = new Sql($adapter);
		$where = new Where();
		$where = $where->notEqualTo('Id_User ?', $userLogged);
		$select = $sql->select()->from($this->table)->columns(array('Id_User', 'Nome'))
								->where("Id_User != $userLogged");
		
		$selectString = $sql->getSqlStringForSqlObject($select);
		$resultSet = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);

		//$resultSet = $this->select($where);
		$keys = array();
		$values = array();
		//\Zend\Debug\Debug::dump($resultSet);
		foreach ($resultSet as $row){
			//Zend\Debug\Debug::dump($row);
			//echo $row['Id_User'];
			array_push($keys, $row->Id_User);
			array_push($values, $row->Nome);
		}
		$ret = array_combine($keys, $values);
		//\Zend\Debug\Debug::dump($ret);
		return $ret;
	}
	
	public function saveUser($user = array()){
		
		$this->insert($user);
	}

}