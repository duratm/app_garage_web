<?php
require_once "autoload.php";

$modelBDD = new ModelDAO(MaBD::getInstance());
$models = $modelBDD->getAllModel();

echo json_encode($models);