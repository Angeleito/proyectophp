<?php

function getDBConnection() {
  $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
  }
  return $conn;
}