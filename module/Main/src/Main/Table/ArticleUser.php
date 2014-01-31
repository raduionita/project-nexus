<?php

  class ArticleUser extends \Table
  {
    public $table = 'article_user';
    public $links = array('user' => '\Table\User');
  }  