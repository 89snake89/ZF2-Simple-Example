<?php
namespace Prova\Controller;

use Prova\Model\Auto;
use Prova\Model\AutoTable;
use Zend\View\Model\ViewModel;

use Prova\Form\ProvaFormInserisciAuto;

use Zend\Mvc\Controller\AbstractActionController;

class AutoController extends AbstractActionController
{
	protected $autoTable;
	public function indexAction(){
		$MyCars = $this->getAutoTable()
						->fetchMyCars($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		//\Zend\Debug\Debug::dump($MyCars);
		
		$carInsurance = $this->getAutoTable()->notInsurancedCars();
		return new ViewModel(array('MyCars' => $MyCars, 'carInsurance' => $carInsurance));
	}
	public function inserisciAction(){
		$form = new ProvaFormInserisciAuto();
		$request = $this->getRequest();
		if($request->isPost()){
			//Creazione new auto e inserimento nel DB
			$auto = new Auto();
			$form->setInputFilter($auto->getInputFilterInserisci());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$params = $form->getData();
				$auto->setData($params);
				$this->getAutoTable()->saveAuto($auto->getArray());
			}
		}
		return new ViewModel(array('form' => $form));
	}
	public function acquistoAction(){
		$cars = $this->getAutoTable()->fetchAvailableCars();
		return new ViewModel(array('cars' => $cars));
	}
	public function vendiAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		$this->getAutoTable()->sellCar($id);
		return $this->forward()->dispatch('Prova\Controller\Auto',array('action' => 'index'));
	}
	public function compraAction(){
		//Inserimento in tabella auto_user
		$id = (int) $this->params()->fromRoute('id', 0);
		$this->getAutoTable()->operationCar($id, 'auto_user');
		return $this->forward()->dispatch('Prova\Controller\Auto',array('action' => 'index'));
	}
	public function assicuraAction(){
		$id = (int) $this->params()->fromRoute('id', 0);
		$this->getAutoTable()->operationCar($id, 'insurance');
		return $this->forward()->dispatch('Prova\Controller\Auto',array('action' => 'index'));
	}
	public function getAutoTable()
	{
		if (!$this->autoTable) {
			$sm = $this->getServiceLocator();
			$this->autoTable = $sm->get('Prova\Model\AutoTable');
		}
		return $this->autoTable;
	}
}