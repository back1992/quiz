<?php

namespace Audio\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Mongo;
use MongoId;
use MongoDate;
use Album\Entity\DBconnection;
use Album\Form\AudioForm;

class AudioController extends AbstractActionController
{

	public function indexAction()
	{
		return new ViewModel();
	}

	public function scanAction()
	{
		$audioDir = './public/audiodata';
		$audioArray = scandir($audioDir);
		array_splice($audioArray,  0, 2);  
		// var_dump($audioArray); 
		foreach ($audioArray as $audioFile) {
			$tempArr[] = '/audiodata/' . substr($audioFile, 0, -4);
		}
		$audioRes = array_unique($tempArr);

		// var_dump($tempArr);
		// var_dump($audioRes);
		if (count($tempArr) == 2 * count($audioRes)) {

			return array(
				'audioRes' => $audioRes,
				);
		}
		echo 'something wrong';
		return false;
	}

	public function audioindbAction(){
		ini_set('display_errors', '1');

		$mongo = DBConnection::instantiate();
		$gridFS = $mongo->database->getGridFS();
		$objects = $gridFS->find();
		return array(
			'objects' => $objects,
			'flashMessages' => $this->flashMessenger()->getMessages()
			);
	}
	public function fetchaudioAction()
	{
		ini_set('display_errors', '1');

		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		if(!$id) 	{
			$this->flashMessenger()->addMessage('You havn\'t select audio file in database .');
			return $this->redirect()->toRoute('audio', array('action' => 'audioindb'));
		}

		$mongo = DBConnection::instantiate();
		$dbname = DBConnection::DBNAME;
		$gridFS = $mongo->database->getGridFS();
		$object = $gridFS->findOne(array('_id' => new MongoId($id)));
		//view in form 
		$form = new audioForm();
		$form->setBindOnValidate(false);
		$form->bind((object)$object->file);
		$audiofiledir= './public/audiodata/raw/';
		$form->setData(array('audiofiledir' => $audiofiledir));
		// var_dump((object)$object->file);
                //write to raw directory
		
		$audioname = $object->file['audioname'];
		$object->write($audiofiledir. $audioname);
		$this->flashMessenger()->addMessage("You have fetch audio file  '$audioname' into  '$audiofiledir' .");
		return array(
			'form' => $form,
			'flashMessages' => $this->flashMessenger()->getMessages()
			);
	}

	public function spltAction()
	{
		$request = $this->getRequest();
		if ($request->isPost()) {
			$sDir=$request->getPost()->title;
			// $sFiles = $this->dirToArray($sDir);
			var_dump($request->getPost());
		}


		$audioSDir =  $request->getPost()->audiofiledir;
		$audioFile = $request->getPost()->audioname;
		$audioTDir =  $audioSDir.'../'.str_replace('.mp3', '', $audioFile).'/';

		$cmd_splt = " rm -rf $audioTDir* && mp3splt -s  $audioSDir$audioFile  -d $audioTDir  && cp ./mp3splt.log  $audioTDir";
		var_dump($cmd_splt);
		$spltlog = shell_exec($cmd_splt);
		var_dump($spltlog);
    // $spltlog = shell_exec('mp3splt -s  -p th=-25,min=2.5 ' . $audioDir . $mp3path .'.mp3  -d '.$audioDir . $mp3path);
    // $spltlog = shell_exec('mp3splt -s -p th=-25,nt=10,min=0.17 ' . $audioDir . $mp3path.'.mp3');
    // sleep(10);
    // return $this->redirect()->toRoute('mp3', array(
    //     'action' => 'questions'
    //     ));
    // return array(
    //     'spltlog' => $spltlog
    //     );
		return false;
	}


	public function readlogAction()
	{
		$logfile = './mp3splt.log';
		$logArray =  file($logfile);
		array_splice($logArray,  0, 2);     

		for ($i=0; $i<count($logArray); $i++) {
			$logArray[$i] = preg_split("/[\s,]+/", $logArray[$i]);
			array_splice($logArray[$i], 2, 2);
		}
		sort ($logArray);
		return array(
			'logArray' => $logArray,
			);
	}

}
