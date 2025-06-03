<?php 
   function server_error($error) {
      http_response_code(500);
      echo json_encode(['message' => $error ?? 'Something went wrong...']);
      exit;
   }
?>