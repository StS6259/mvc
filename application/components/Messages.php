<?php

namespace application\components;

class Messages
{
    const ERROR = 'error';
    const SUCCESS = 'success';
    const WARNING = 'warning';

    public static function displayError()
    {
        return self::display(self::getError());
    }

    public static function displayWarning()
    {
        return self::display(self::getWarning());
    }

    public static function displaySuccess()
    {
        return self::display(self::getSuccess());
    }

    public static function error(array $messages)
    {
        self::set(self::ERROR, $messages);
    }

    public static function success(array $messages)
    {
        self::set(self::SUCCESS, $messages);
    }

    public static function warning(array $messages)
    {
        self::set(self::WARNING, $messages);
    }

    public static function getError()
    {
        return self::get(self::ERROR);
    }

    public static function getSuccess()
    {
        return self::get(self::SUCCESS);
    }

    public static function getWarning()
    {
        return self::get(self::WARNING);
    }

    public static function hasError()
    {
        return self::has(self::ERROR);
    }

    public static function hasSuccess()
    {
        return self::has(self::SUCCESS);
    }

    public static function hasWarning()
    {
        return self::has(self::WARNING);
    }

    private function has($type)
    {
        return isset($_SESSION[$type]);
    }

    private function set($type, array $messages)
    {
        $_SESSION[$type] = $messages;
    }

    private function get($type)
    {
        $messages = $_SESSION[$type];
        unset($_SESSION[$type]);
        return $messages;
    }

    private function display($messages)
    {
        $response = '';
        foreach ($messages as $message) {
            if (is_array($message)) {
                foreach ($message as $item) {
                    if (!is_array($item)) {
                        $response .= '<li>' . $item . '</li>';
                    } else {
                        foreach ($item as $i) {
                            $response .= '<li>' . $i . '</li>';
                        }
                    }
                }
            } else {
                $response .= '<li>' . $message . '</li>';
            }
        }

        return $response;
    }
}