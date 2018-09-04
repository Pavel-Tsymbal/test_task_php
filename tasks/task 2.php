<?php

//Имеется строка:
//https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3
//Напишите функцию, которая:
//1.	удалит параметры со значением “3”;
//2.	отсортирует параметры по значению;
//3.	добавит параметр url со значением из переданной ссылки без параметров (в примере: /test/index.html);
//4.	сформирует и вернёт валидный URL на корень указанного в ссылке хоста.
//В указанном примере функцией должно быть возвращено:
//https://www.somehost.com/?param4=1&param3=2&param1=4&url=%2Ftest%2Findex.html

/**
 * @param string $string
 * @param array $exceptValues
 * @return bool|string
 */
function convertUrl(string $string, array $exceptValues)
{
    if (empty($string)) {
        return false;
    }

    if (!preg_match('~(http.?://.+)\/(.+)/(.+)\?~', $string, $host)) {
        return false;
    }

    if (!preg_match_all('~([^?&=#]+)=([^&#]*)~', $string, $params)) {
        return false;
    }

    $paramsArray = [];
    foreach ($params[1] as $key => $param) {
        if (!in_array($params[2][$key], $exceptValues)) {
            $paramsArray[$param] = $params[2][$key];
        }
    }
    asort($paramsArray);

    $result = $host[1] . '/?';

    foreach ($paramsArray as $param => $value) {
        $result .= $param . '=' . $value . '&';
    }
    $result .= 'url=' . '/' . $host[2] . '/' . $host[3];

    return $result;
}

$string = 'https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3';
$exceptValues = [3];
echo convertUrl($string, $exceptValues); // https://www.somehost.com/?param4=1&param3=2&param1=4&url=/test/index.html