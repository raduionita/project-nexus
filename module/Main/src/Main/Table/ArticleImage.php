<?php
  
  namespace Main\Table;
  
  use Nexus\ORM\Table as Table;
  
  class ArticleImage extends Table
  {
    public $table = 'article_image';
    public $links = array('image' => 'Main\Table\Image');
  }