<?php
namespace Prova\Model;

use Zend\Db\Sql\Sql;

use Zend\Authentication\Storage\Session;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Prova\Model;

class AutoTable extends AbstractTableGateway
{
	protected $table ='auto';
	//protected $adapter;

	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		
		$this->resultSetPrototype->setArrayObjectPrototype(new Auto());
		$this->initialize();
		
	}
	public function fetchAvailableCars(){
		$adapter = $this->getAdapter();
		$sql = new Sql($this->getAdapter());
		$sql = new Sql($this->getAdapter());
		$select2 = $sql->select()->from('auto_user')->columns(array('Id_Auto'));
		
		$select = $sql->select()->from($this->table)->order(array('Marca'))
					->where(array('Id_Auto NOT IN ('. ($sql->getSqlStringForSqlObject($select2)) . ')'));
		$selectString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		return $results;
	}
	public function fetchMyCars(Adapter $adapter)
	{
		//Dati dell'utente
		$session = new Session();
		$userLogged = $session->read()->Id_User;
		//Costruzione delle query
		$sql = new Sql($this->getAdapter());
		$select2 = $sql->select()->from('auto_user')->columns(array('Id_Auto'))
								->where(array('Id_User' => $userLogged));
		$select = $sql->select()->from($this->table)
						->where(array('Id_Auto IN ('. 
						($sql->getSqlStringForSqlObject($select2)) . ')'))->order(array('Marca'));
		$statement = $sql->prepareStatementForSqlObject($select);
		$selectString = $sql->getSqlStringForSqlObject($select);
		
		$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		if($results->count() < 1){
			$results = null;
		}
		return $results;
	}
	public function notInsurancedCars()
	{
		//Dati dell'utente
		$session = new Session();
		$userLogged = $session->read()->Id_User;
		//Costruzione delle query
		$adapter = $this->adapter;
		$sql = new Sql($adapter);
		$select3 = $sql->select()->from('insurance')->columns(array('Id_Auto'));
		$select2 = $sql->select()->from('auto_user')->columns(array('Id_Auto'))
		->where(array('Id_User' => $userLogged));
		$select = $sql->select()->from($this->table)
		->where(array('Id_Auto IN ('.
				$sql->getSqlStringForSqlObject($select2) . ')'))
		->where(array('Id_Auto NOT IN ('. $sql->getSqlStringForSqlObject($select3) . ')'));
		$statement = $sql->prepareStatementForSqlObject($select);
		$selectString = $sql->getSqlStringForSqlObject($select);
		//\Zend\Debug\Debug::dump($selectString);
		
		$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		if($results->count() < 1){
			$results = null;
		}
		return $results;
	}
	public function operationCar($id, $tableName){
		//inserimento nel DB
		$adapter = $this->adapter;
		$session = new Session();
		$userLogged = $session->read()->Id_User;
		$sql = new Sql($this->adapter);
		$select = $sql->insert()->into($tableName)
								->columns(array('Id_Auto', 'Id_User'))
								->values(array($id, $userLogged));
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
	}
	public function sellCar($id){
		$adapter = $this->adapter;
		$sql = new Sql($this->adapter);
		$select = $sql->delete()->from('auto_user')->where(array('Id_Auto' => $id));
		$selectString = $sql->getSqlStringForSqlObject($select);
		$adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		$select = $sql->delete()->from('insurance')->where(array('Id_Auto' => $id));
		$selectString = $sql->getSqlStringForSqlObject($select);
		$adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
	}
	
	public function saveAuto($auto = array()){
		$this->insert($auto);
	}

}