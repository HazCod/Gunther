<?php

date_default_timezone_set('Europe/Brussels');

$settings = array(
    'CP_API' => 'http://localhost:5053/api/API-KEY-HERE/',
    'SB_API' => 'http://localhost:8083/api/API-KEY-HERE/?cmd=',
    'TVDB_API' => 'TVDB-API-KEY-HERE',      #Your TheTvDB API key

    'MEDIA_LOC' => '/mnt/media/',

    'TVDB_URL' => 'http://thetvdb.com',
    'CACHE_DIR' => 'cache/',    #cache directory for TheTvDB/IMDB
    'CACHE_TTL' => 86400,        #Cache time-to-live in seconds, default 1 day
    'DEFAULT_LANG' => 'en',     #default language

   'AUTH_DIGEST_FILE' => '/etc/nginx/webdav.auth',
   'LOG' => '/var/log/nginx/error.log',
   'LAST_LOG' => 10,  #get last 10 logs
);

$db_config = array(
    'driver' => 'sqlite',
    'username' => 'gunther',
    'password' => 'amdew3rowl2!2',
    'dsn' => array(
        'host' => '/etc/nginx/db.sq3',
        'dbname' => 'gunther',
    )
);
