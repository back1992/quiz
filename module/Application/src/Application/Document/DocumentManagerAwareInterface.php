<?php  
  
namespace Application\Document;  
  
use Doctrine\ODM\MongoDB\DocumentManager;  
  
interface DocumentManagerAwareInterface  
{  
    public function setDocumentManager(DocumentManager $dm);  
}  