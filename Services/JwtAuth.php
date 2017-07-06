<?php

namespace MarkerTabsBundle\Services;

use Firebase\JWT\JWT;

class JwtAuth {

    public $manager;
    public $key;
    public $encodeType;

    public function __construct($manager) {
        $this->manager = $manager;
        $this->key = "clave-secreta";
        $this->encodeType = "HS256";
    }

    public function signUp($username, $pass) {
        $user = $this->manager->getRepository('MarkerTabsBundle:User')
                ->findOneBy(array("username" => $username, "pass" => $pass));
        if (is_object($user)) {
            $token = array(
                "sub" => $user->getId(),
                "iat" => time(),
                "exp" => time() + strtotime('+1 year')
            );
            return JWT::encode($token, $this->key, $this->encodeType);
        }
        return false;
    }

    public function checkToken($token, $getIdentity = false) {
        try {
            $decoded = JWT::decode($token, $this->key, array($this->encodeType));
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }
        $auth = isset($decoded->sub) ? true : false;
        return $getIdentity ? $decoded : $auth;
    }

}
