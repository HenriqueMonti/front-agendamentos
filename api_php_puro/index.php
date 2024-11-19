<?php

require 'crudOperations/medicoCrud.php';
require 'crudOperations/pacienteCrud.php';
require 'crudOperations/consultaCrud.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = explode('/', $uri);

if ($uri[1] !== 'api' || !isset($uri[2])) {

  header("HTTP/1.1 404 Not Found");

  exit();
}

if ($uri[2] === 'pacientes' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  
  if (isset($uri[3])) {
      getPacienteById($uri[3]);
  } else {
      getAllPacientes();
  }
} elseif ($uri[2] === 'pacientes' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  $input = json_decode(file_get_contents('php://input'), true);
  createPaciente($input);
} elseif ($uri[2] === 'pacientes' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {

  deletePaciente($uri[3]);
} elseif ($uri[2] === 'pacientes' && $_SERVER['REQUEST_METHOD'] === 'PUT') {

  $input = json_decode(file_get_contents('php://input'), true);

  updatePaciente($input, $uri[3]);
} elseif ($uri[2] === 'medicos' && $_SERVER['REQUEST_METHOD'] === 'GET') {

  getAllMedicos();
} elseif ($uri[2] === 'medicos' && $uri[3] === 'especialidade' && $_SERVER['REQUEST_METHOD'] === 'GET') {

  if ($uri[4]) {

    getEspecialidadeById($uri[4]);
  } else {

    getEspecialidades();
  }
} elseif ($uri[2] === 'medicos' && $uri[3] === 'especialidade' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $input = json_decode(file_get_contents('php://input'), true);
  createEspecialidade($input);
} elseif ($uri[2] === 'medicos' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  $input = json_decode(file_get_contents('php://input'), true);

  createMedico($input);
} elseif ($uri[2] === 'medicos' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {

  deleteMedico($uri[3]);
} elseif ($uri[2] === 'medicos' && $_SERVER['REQUEST_METHOD'] === 'PUT') {

  $input = json_decode(file_get_contents('php://input'), true);

  updateMedico($input, $uri[3]);
} elseif ($uri[2] === 'consultas' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  getAllConsultas();
} elseif ($uri[2] === 'consultas' && $_SERVER['REQUEST_METHOD'] === 'POST') {

  $input = json_decode(file_get_contents('php://input'), true);

  createConsulta($input);
} elseif ($uri[2] === 'consultas' && $_SERVER['REQUEST_METHOD'] === 'DELETE') {

  deleteConsulta($uri[3]);
} elseif ($uri[2] === 'consultas' && $_SERVER['REQUEST_METHOD'] === 'PUT') {

  $input = json_decode(file_get_contents('php://input'), true);

  updateConsulta($input, $uri[3]);
} else {
  header("HTTP/1.1 405 Method Not Allowed");
}

error_reporting(E_ALL);
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}
