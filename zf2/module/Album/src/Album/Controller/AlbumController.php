<?php
// module/Album/src/Album/Controller/AlbumController.php:
namespace Album\Controller;

use Album\Form\AlbumFindForm;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;         
use Album\Form\AlbumForm;

class AlbumController extends AbstractActionController
{
	protected $albumTable;
	public function indexAction()
	{
		$albums = $this->getAlbumTable()->fetchAll();
	
		/*return new ViewModel(array(
				'albums' => $this->getAlbumTable()->fetchAll(),
		));*/
		return new ViewModel(array(
				'albums' => $albums,
		));
	}
	
	public function findAction(){
		$form = new AlbumFindForm();
		$form->get('submit')->setValue('Find');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$album = new Album();
			$form->setInputFilter($album->getInputFilterSearch());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$artist = $form->getData();
				$artist = $artist['artist'];
				$albums = $this->getAlbumTable()->searchAlbum($artist);
				var_dump($albums);
				return new ViewModel(array( 'form' => $form, 'albums' => $albums));
				// Redirect to list of albums
				//$this->redirect()->toRoute(array('view' => 'artist'));
			}
		}else {
				return array(
						'form' => $form
				);
			}
		
		
	}

	public function addAction()
	{
		$form = new AlbumForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$album = new Album();
			$form->setInputFilter($album->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$album->exchangeArray($form->getData());
				$this->getAlbumTable()->saveAlbum($album);
		
				// Redirect to list of albums
				return $this->redirect()->toRoute('album');
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('album', array(
					'action' => 'add'
			));
		}
		$album = $this->getAlbumTable()->getAlbum($id);
		
		$form  = new AlbumForm();
		$form->bind($album);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($album->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$this->getAlbumTable()->saveAlbum($album);
		
				// Redirect to list of albums
				return $this->redirect()->toRoute('album');
			}
		}
		
		return array(
				'id' => $id,
				'form' => $form,
		);
	}

	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('album');
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
		
			if ($del == 'Yes') {
				$id = (int) $request->getPost('id');
				$this->getAlbumTable()->deleteAlbum($id);
			}
		
			// Redirect to list of albums
			return $this->redirect()->toRoute('album');
		}
		
		return array(
				'id'    => $id,
				'album' => $this->getAlbumTable()->getAlbum($id)
		);
	}
	
	public function getAlbumTable()
	{
		if (!$this->albumTable) {
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('Album\Model\AlbumTable');
		}
		return $this->albumTable;
	}
}