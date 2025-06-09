<?php
   session_start();

   header('Access-Control-Allow-Origin: *');
   header('Access-Control-Allow-Methods: GET');

   if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      http_response_code(405);
      echo json_encode(['message' => 'Only GET requests are allowed.']);
      exit;
   }

   $user_id = $_SESSION['user_id'] ?? null;

   if ($user_id) {
      http_response_code(200);
   } else {
      http_response_code(404);
   }

   echo json_encode(['userId' => $user_id]);
   exit;
?>