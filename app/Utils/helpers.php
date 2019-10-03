<?php

function success($data, $message)
{
    return [
        'message' => $message,
        'data' => $data
    ];
}

function fail($errors, $message)
{
    return [
        'message' => $message,
        'errors' => $errors
    ];
}
