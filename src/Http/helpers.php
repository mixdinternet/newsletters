<?php

function getQueryString($string){
    #dd($string);
    $url = explode('?',$string);
    if(isset($url[1])) {
        return '?'.$url[1];
    }else{
        return '';
    }
}