<?php
  
  namespace Main\Controller;
  
  use Nexus\Mvc\Controller\AbstractActionController;
  
  class IndexActionController extends AbstractActionController
  {
    public function indexAction()
    {
    
      # $records = (new \Table\Article())->where(array('user_id' => 2, 'lang_id' => 1))->order(array('keyword' => 'DESC'))->limit(2)->get();
      
      # $page = empty($_GET['page']) ? 1 : max(1, (int) $_GET['page']);
      
      # $paginator = (new \Paginator((new \Table\Article())->where(array('user_id' => 2, 'lang_id' => 1))->order(array('keyword' => 'DESC'))))->config(array('page' => $page, 'items' => 1));
      # $records   = $paginator->get(); 
      # $meta      = $paginator->meta();
    
      $table  = (new \Main\Table\Article())->order(array('keyword' => 'DESC'))->execute();    
      while($record = $table->fetch())
        print_r($record);
        
      # if(!empty($_POST)) 
      #   $status = (new \Table\Article())->save($_POST);
    }
  }