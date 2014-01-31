<?php

  class ArticleLang extends \Table
  {
    public $type  = \Table::TYPE_CHILD;
    public $table = 'article_lang';
    public $links = array('lang' => '\Table\Lang');
  }  