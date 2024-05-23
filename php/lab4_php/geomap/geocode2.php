<?php

$address = $_POST['address'];
$apiKey = '0e88d23d-e728-4c8b-b380-152555ebc218';

$apiUrl = 'https://geocode-maps.yandex.ru/1.x/?format=json&apikey=' . urlencode($apiKey) . '&geocode=' . urlencode($address);

$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

$structuredAddress = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
$coordinates = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];

$coord = str_replace(" ", ",", $coordinates);
$parameters = array(
    'apikey' => $apiKey,
    'geocode' => $coord,
    'kind' => 'metro',
    'format' => 'json'
);

$response = file_get_contents('https://geocode-maps.yandex.ru/1.x/?'. http_build_query($parameters));
$obj = json_decode($response, true);

if (!isset($obj['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'])) {

 $result = [
 'address' => $structuredAddress,
 'coordinates' => $coordinates,
 'nearest_metro' => 'Не найдено',
 ];
} else {
 $nearestMetro = $obj['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['name'];
 $result = [
 'address' => $structuredAddress,
 'coordinates' => $coordinates,
 'nearest_metro' => $nearestMetro,
 ];
}

echo json_encode($result);