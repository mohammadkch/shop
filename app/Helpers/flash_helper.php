<?php

use App\Config\FlashMessages;

function setFlash($key, $customMessage = null)
{
    $message = FlashMessages::get($key, $customMessage);
    session()->setFlashdata('flash_message', $message['message']);
    session()->setFlashdata('flash_type', $message['type']);
}

function getFlash()
{
    if (session()->has('flash_message')) {
        return [
            'message' => session()->get('flash_message'),
            'type' => session()->get('flash_type')
        ];
    }
    return null;
}

function showFlash()
{
    $flash = getFlash();
    if ($flash) {
        echo "<script>showNotification('" . addslashes($flash['message']) . "', '" . $flash['type'] . "');</script>";
    }
}