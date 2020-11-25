<?php

header('Access-Control-Allow-Origin: *', true);

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // return only the headers and not the content
    // only allow CORS if we're doing a GET - i.e. no saving for now.
    header('Access-Control-Allow-Headers: Content-Type, Authorization', true);
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS', true);
    echo json_encode(['status' => true]);
    exit(0);
}
