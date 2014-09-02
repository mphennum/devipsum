<?php header('Content-Type: application/json; charset=utf-8'); ?>
<?= json_encode(['request' => $request, 'result' => $result, 'status' => $status], JSON_PRETTY_PRINT); ?>
