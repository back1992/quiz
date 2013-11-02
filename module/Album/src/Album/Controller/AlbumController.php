<?php
namespace Album\Controller;
use Zend\Mvc\Controller\AbstractActionController,
Zend\View\Model\ViewModel, 
Album\Form\AlbumForm,
Album\Form\UploadForm,
Album\Form\CommentForm,
Album\Form\AudioForm,
// Doctrine\ORM\EntityManager,
Album\Document\Album;
use Album\Document\User;
use Album\Document\UserRepository;
use Album\Document\Product;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;

use Mongo;
use MongoId;
use MongoDate;
use Zend\Session\SaveHandler\MongoDB;
use Zend\Session\SaveHandler\MongoDBOptions;
use Zend\Session\SessionManager;
use Album\Entity\DBconnection;

use Zend\EventManager\EventManagerInterface;
use Zend\Http\Request;

class AlbumController extends AbstractActionController
{

    public function indexAction()
    {
        $mongo = new Mongo(); 
        $databases = $mongo->listDBs();
        return array('databases'=>$databases);
    }
    public function deleteAction()
    {
        ini_set('display_errors', '1');
        $mongo = DBConnection::instantiate();
        $gridFS = $mongo->database->getGridFS();
        
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        if($id == 'all') {
            $gridFS->remove();
        } else {
            $gridFS->remove(array('_id' => new MongoId($id)));
        }
        $this->redirect()->toRoute('album', array(
            'action' => 'mp3indb'
            ));
    }

    public function processmp3Action()
    {
        ini_set('display_errors', '1');

        $id = $this->getEvent()->getRouteMatch()->getParam('id');
    // $id =  ($id) ? $id : '526e2c707f8b9aa60d8b459d';
        $id =  ($id) ? $id : '526e67687f8b9a490f8b457e';
        $mongo = DBConnection::instantiate();
        $gridFS = $mongo->database->getGridFS();
        $mp3 = $gridFS->findOne(array('_id' => new MongoId($id)));
    // $article = $collection->findOne(array('_id' =>new MongoId($id)));
        var_dump($mp3->file);
        $form = new Mp3Form();
        $form->setBindOnValidate(false);
        $form->bind((object)$mp3->file);
    // $form->get('submit')->setAttribute('label', 'Edit');
        $request = $this->getRequest();
        return array(
            'id' => $id, 
            'mp3' => $mp3, 
            'mp3path' => basename($mp3->file['filename'], ".mp3"), 
            'form' => $form
            );
    }


    public function mongoAction(){
        ini_set('display_errors', '1');
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
    // $id =  ($id) ? $id : '526e2c707f8b9aa60d8b459d';
        $id =  ($id) ? $id : '526e67687f8b9a490f8b457e';
        $mongo = DBConnection::instantiate();
        $gridFS = $mongo->database->getGridFS();
        $object = $gridFS->findOne(array('_id' => new MongoId($id)));
        $output = shell_exec('pwd');
        echo "<pre>$output</pre>";
        if($object){
            $audiofile = $object->file['filename'];
            $path_parts = pathinfo($audiofile);
            shell_exec('mongofiles -d quiz -l ./data/mp3/'. $audiofile .' get '.$audiofile);
            if ($path_parts['extension'] = 'mp3'){
             shell_exec('ffmpeg -i ./data/mp3/'. $audiofile . ' '.$path_parts['filename'].'.ogg');
         }else if  ($path_parts['extension'] = 'ogg') {
             shell_exec('ffmpeg -i ./data/mp3/'. $audiofile . ' '.$path_parts['filename'].'.mp3');
         }
     }
 }

 public function mp3indbAction(){
    ini_set('display_errors', '1');

    $mongo = DBConnection::instantiate();
    $gridFS = $mongo->database->getGridFS();
    $objects = $gridFS->find();
    return array('objects' => $objects);
}

public function questions(){
    ini_set('display_errors', '1');
    $objects = array_slice(scandir('./data/img/shandong'), 2);
    // var_dump($objects);
    $mp3Tag = file_get_contents('./mp3splt.log');
    $pattern = '/\d*\.\d{4,}/';
    preg_match_all($pattern, $mp3Tag, $matches);
    asort($matches);
    foreach (array_unique($matches[0]) as $matches_value) {
        $mp3TagArrayTmp[] = $matches_value;
    }
    // asort($mp3TagArrayTmp);
    // var_dump($this->basePath());
    return array(
        'objects' => $objects, 
        'mp3TagArrayTmp' => $mp3TagArrayTmp
        );
}

public function uploadAction(){
    ini_set('display_errors', '1');
    $id = 0;
    $flag = 0;
    $mongo = DBConnection::instantiate();
//get a MongoGridFS instance
    $gridFS = $mongo->database->getGridFS();

    $form = new UploadForm('upload-form');

    $request = $this->getRequest();
    if ($request->isPost()) {
        // Make certain to merge the files info!
        $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
            );

        $form->setData($post);
        if ($form->isValid()) {
            $data = $form->getData();
            // Form is valid, save the form!

            $filetype = $data['image-file']['type'];
            $tmpfilepath = $data['image-file']['tmp_name'];
            $caption = $data['caption'];
            var_dump($data['image-file']['name']);
            $mp3file = $tmpfilepath;
            $oggfile = $tmpfilepath;

            if($filetype == 'audio/mp3') {
                $filename = basename($data['image-file']['name'], '.mp3');
                $oggfile = $tmpfilepath.'.ogg';
                shell_exec('ffmpeg -i ' . $tmpfilepath . ' ' .$oggfile);

            } elseif ($filetype == 'audio/ogg') {
                $filename = basename($data['image-file']['name'], '.ogg');
                $mp3file = $tmpfilepath.'.mp3';
                shell_exec('ffmpeg -i ' . $tmpfilepath . '  '.$mp3file);
            }
            var_dump($filename );
            $idmp3 = $gridFS->storeFile($mp3file,
                array('audioname' => $filename.'.mp3',
                    'filetype' => 'mp3',
                    'caption' => $caption
                    ));

            $idogg = $gridFS->storeFile($oggfile,
                array('audioname' => $filename.'.ogg',
                    'filetype' => 'ogg',
                    'caption' => $caption
                    ));
            $flag = 1;
        // $this->redirect()->toRoute('album', array(
        //     'action' => 'mp3indb'
        //     ));
        }
    }

    return array('form' => $form, 'flag' => $flag, 'id' => $id);
}

public function spltAction()
{
    $audioDir =  './data/audio/';
    $audiofile = $this->params()->fromRoute('id', 0);
    // $audiofile = $audioDir.$this->params()->fromRoute('id', 0);
    $mp3file = $audioDir.$audiofile.'.mp3';
    $oggfile = $audioDir.$audiofile.'.ogg';
    var_dump($oggfile);
    if (!file_exists($mp3path) && !file_exists($oggfile)){
        return $this->redirect()->toRoute('album', array(
            'action' => 'mp3indb'
            ));
    }
    var_dump($mp3file);
    var_dump($oggfile);
    // $spltlog = shell_exec('mp3splt -s  -p th=-25,min=2.5 ' . $audioDir . $mp3path .'.mp3  -d '.$audioDir . $mp3path);
    // $spltlog = shell_exec('mp3splt -s -p th=-25,nt=10,min=0.17 ' . $audioDir . $mp3path.'.mp3');
    // sleep(10);
    // return $this->redirect()->toRoute('mp3', array(
    //     'action' => 'questions'
    //     ));
    // return array(
    //     'spltlog' => $spltlog
    //     );
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
        'audiofile' => $audiofile,
        );
}

public function scanAction()
{
    $audioDir = './data/audio';
    $audioArray = scandir($audioDir);
     array_splice($audioArray,  0, 3);   
        return array(
        'audioArray' => $audioArray,
        );
}

public function fetchaudioAction()
{
    ini_set('display_errors', '1');
    
    $id = $this->getEvent()->getRouteMatch()->getParam('id');
    $mongo = DBConnection::instantiate();
    $gridFS = $mongo->database->getGridFS();
    $audio = $gridFS->findOne(array('_id' => new MongoId($id)));
    // var_dump($audio->file);
    $form = new audioForm();
    $form->setBindOnValidate(false);
    $form->bind((object)$audio->file);
    // $form->get('submit')->setAttribute('label', 'Edit');
    if($audio){
        $res = shell_exec('mongofiles -d quiz -l ./data/audio/'. $audio->file['audioname'] .' get '.$audio->file['filename']);
        echo $res.'<br />';
        $tmp = explode(' ', $res);
        $audiopath = $tmp[count($tmp)-1];
        echo $audiopath.'<br />';
    }
    $form->get('submit')->setValue('Splt Audio');
    $request = $this->getRequest();
    $spltDir = './data/audio/splt/';
    $command = 'mp3splt -s  -p th=-25,min=2.5 ' . $audiopath .' -d '.$spltDir;
    echo $command.'<br />';
    var_dump($command);
    if ($request->isPost()) {
        $spltlog = shell_exec($command);
        var_dump($spltlog);
        // return $this->redirect()->toRoute('album/mp3indb');
    }
    $patterns = array();
    $patterns[0] = '/\.mp3$/';
    $patterns[1] = '/\.ogg$/';
    $audiopath = preg_replace($patterns, $audio->file['audioname'], '');
    return array(
        'id' => $id, 
        'audio' => $audio, 
        'audiopath' => $audiopath, 
        'form' => $form
        );
}
}