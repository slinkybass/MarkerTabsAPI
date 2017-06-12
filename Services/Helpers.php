<?php

namespace MarkerTabsBundle\Services;

class Helpers {

    public $jwt_auth;
    private $paginator_itemsperpage = 10;

    public function __construct($jwt_auth) {
        $this->jwt_auth = $jwt_auth;
    }

    public function authCheck($token, $getIdentity = false) {
        if (!is_null($token)) {
            if (!$getIdentity) {
                $check_token = $this->jwt_auth->checkToken($token);
                return $check_token ? $check_token : false;
            } else {
                $check_token = $this->jwt_auth->checkToken($token, true);
                return is_object($check_token) ? $check_token : false;
            }
        }
        return false;
    }

    public function serializeOBJ($data, $status = 200, $type = 'json', $groups = array()) {
        $classMetadataFactory = new \Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory(new \Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader(new \Doctrine\Common\Annotations\AnnotationReader()));

        $normalizers[] = new \Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer($classMetadataFactory);
        $encoders[] = new \Symfony\Component\Serializer\Encoder\JsonEncoder();
        $encoders[] = new \Symfony\Component\Serializer\Encoder\XmlEncoder();

        $callback_date = function ($datetime) {
            return $datetime instanceof \DateTime ? $datetime->format('Y-m-d') : $datetime;
        };
        $callback_datetime = function ($datetime) {
            return $datetime instanceof \DateTime ? $datetime->format('Y-m-d\TH:i:sO') : $datetime;
        };

        foreach ($normalizers as $normalizer) {
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });
            $normalizer->setCallbacks(array(
                'fecha' => $callback_date,
                'fecha-hora' => $callback_datetime
            ));
        }

        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, $encoders);

        $array_groups = count($groups) ? array('groups' => $groups) : array();
        $data_normalized = $serializer->normalize($data, null, $array_groups);
        $data_serialized = $serializer->serialize($data_normalized, $type);

        $response = new \Symfony\Component\HttpFoundation\Response;
        $response->setContent($data_serialized);
        $response->setStatusCode($status);
        $response->headers->set("Content-Type", "application/" . $type);

        return $response;
    }

    public function paginate($paginator_obj, $data, $actual_page) {
        $pagination = $paginator_obj->paginate($data, $actual_page, $this->paginator_itemsperpage);

        return array(
            "actual_page" => $actual_page,
            "total_pages" => ceil($pagination->getTotalItemCount() / $this->paginator_itemsperpage),
            "total_items" => $pagination->getTotalItemCount(),
            "data" => $pagination
        );
    }

}
