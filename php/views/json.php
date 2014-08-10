<?php header('Content-Type: application/json'); ?>
<?= json_encode(['request' => $request, 'result' => $result, 'status' => $status], JSON_PRETTY_PRINT); ?>
