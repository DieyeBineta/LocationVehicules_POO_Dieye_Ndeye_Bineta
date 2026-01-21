<?php
session_start();

require_once __DIR__.'/../../models/client.php';

$client = new Client;

$id = intval($_GET["id"]);

$client->delete($id);

header("Location: ../client.php");

?>