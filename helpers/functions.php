<?php 

// dump information

use App\Config\Config;

function dump($item) {
    echo '<pre style="font-size:1.3rem;">';
        var_dump($item);
    echo '</pre>';
    return;
}
// Simple page redirect
function redirect($page)
{
    header('Location: ' . Config::URL_BASE . '/' . $page);
}