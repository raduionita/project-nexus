<?php

  namespace Main\Table
  
  use Nexus\ORM\Table as Table
  
  class Article extends 
  {
    public $type  = Table::TYPE_PARENT;
    public $table = 'article';
    public $links = array('langs' => 'Main\Table\ArticleLang', 'users' => 'Main\Table\ArticleUser', 'images' => 'Main\Table\ArticleImage');
  }