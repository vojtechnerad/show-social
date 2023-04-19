<?php
require_once 'dbh.class.php';
class TmdbApi extends Dbh {
    //
    protected $base_url = 'https://api.themoviedb.org/3/';
    protected $api_key = 'api_key=24d519ba38eaacef95f5c46bc71f2996';
    protected $resultItemsNumber = 10;
}