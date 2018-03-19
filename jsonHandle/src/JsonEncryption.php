<?php
/**
 * Created by PhpStorm.
 * User: billpap
 * Date: 3/18/2018
 * Time: 8:06 PM
 */

namespace Freedom\JsonHandler;


class JsonEncryption
{
    private $encryptComponents;
    static private $pass;

    public function set_components($combo)
    {
        $this->encryptComponents = $combo;
    }

    public function get_components()
    {
        return $this->encryptComponents;
    }

    public function set_pass($pass)
    {
        self::$pass = $pass;
    }

    public function encryptJson($json)
    {
        $pass = self::$pass;
        $salt = sha1(mt_rand());
        $i = substr(sha1(mt_rand()), 0, 16);

        $encryptedJson = openssl_encrypt(
            "$json", 'aes-256-cbc', "$salt:$pass", null, $i
        );

        $combo = new \stdClass();
        $combo->salt = $salt;
        $combo->i = $i;
        $combo->encryptedJson = $encryptedJson;
        $this->set_components($combo);
        return "$salt:$i:$encryptedJson";
    }

    public function decryptJson($json)
    {
        $combo = explode(':', $json);
        $pass = self::$pass;
        $decryptedJson = openssl_decrypt(
            "$combo[2]", 'aes-256-cbc', "$combo[0]:$pass", null, $combo[1]
        );
        return $decryptedJson;
    }
}