<?php
require 'Obligatory.php';

/**
*  Make a new Factory Instance
*/
$obligator = Obligatory::newFactoryInstance();
$values = $_REQUEST;

// Magic set your parameters with name & TRUE / FALSE
$obligator->user_name = true;
$obligator->email = true;
$obligator->password = true;
$obligator->role_id = true;
$obligator->created_on = true;
$obligator->first_name = true;
$obligator->last_name = true;
$obligator->cell_no = true;
$obligator->changed_on = false;

// Give all your paramtere values. Should be an array.

$obligator->setCollection($values);

try {
// This will throw Exception with desc. of missing arguments.
    $obligator->validate();

} catch (Exception $ex) {
    echo $ex->getTrace();
}