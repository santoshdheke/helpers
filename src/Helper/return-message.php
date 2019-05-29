<?php

use \Illuminate\Http\Response;

function message($error, $message, $status)
{
    $response['error'] = $error;
    $response['message'] = $message;
    $response['status_code'] = $status;

    return $response;
}

function serverErrorMessage()
{
    return message(true, 'Something Went Wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
}

function notFoundErrorMessage()
{
    return message(true, 'Data Not Found', Response::HTTP_NOT_FOUND);
}

function badRequestErrorMessage()
{
    return message(true, 'Bad Request', Response::HTTP_BAD_REQUEST);
}

function useOtherErrorMessage($module)
{
    return message(true, $module . 'use on child.', Response::HTTP_FORBIDDEN);
}

function createMessage($module)
{
    return message(false, $module . ' Create Successful', Response::HTTP_CREATED);
}

function updateMessage($module)
{
    return message(false, $module . ' Update Successful', Response::HTTP_RESET_CONTENT);
}

function deleteMessage($module)
{
    return message(false, $module . ' Delete Successful', Response::HTTP_OK);
}

function returnResponse($result)
{
    $status = $result['status_code'];
    unset($result['status_code']);
    return response()->json($result, $status);
}

function dataResponse($data, $arr = null)
{
    $result['error'] = false;
    $result['data'] = $data;
    if (isset($arr) && count($arr) > 0) {
        foreach ($arr as $key => $item) {
            $result[$key] = $item;
        }
    }
    $status = Response::HTTP_OK;

    return response()->json($result, $status);
}


