<?php
date_default_timezone_set('asia/bangkok');

define("DB_TYPE", "MySQL");
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "stadium_booking");




define("DB_DNS_MYSQL", "mysql:host=" . DB_HOST . "; dbname=" . DB_NAME);

class DB
{
    private static $link = null;
    public static function getLink()
    {
        if (self::$link) {
            return self::$link;
        }
        self::$link = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USERNAME, DB_PASSWORD);
        self::$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$link;
    }

    public static function __callStatic($name, $args)
    {
        $callback = array(self::getLink(), $name);
        return call_user_func_array($callback, $args);
    }

    public static function Cancel_DB()
    {
        self::getLink() == null;
    }
}

function uploadeImageBase64($data): stdClass
{
    $result = new stdClass();
    $result->nameImge = generateRandomStringIM(2) . date("Y_m_d_H_i_s") . generateRandomStringIM(3) . generateRandomStringIM(3) . ".png";
    try {
        if (file_put_contents($data->path . $result->nameImge, base64_decode($data->base64_code))) {
            $result->msg =  "success";
            $result->msg_text = 'บันทึกรูปภาพสำเร็จ';
        } else {
            $result->msg =  "error";
            $result->msg_text = 'กรุณาลองใหม่อีกครั้ง';
        }
    } catch (Exception $e) {
        $result->msg =  "error";
        $result->msg_text = $e->getMessage();
    }


    return $result;
}


function getOutputJson($result)
{
    echo json_encode($result);
    // exit;
}


function generateRandomString($length = 10)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomStringIM($length = 10)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdfghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
