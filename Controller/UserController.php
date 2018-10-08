<?php

namespace MarkerTabsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function loginAction(Request $request)
    {
        $data = array();
        $helpers = $this->get('app.helpers');
        $jwt_auth = $this->get("app.jwt_auth");
        $em = $this->getDoctrine()->getManager();
        $responseType = $request->query->get('type', 'json');
        $requestData = json_decode($request->getContent());

        $username = property_exists($requestData, 'username') ? $requestData->username : null;
        $pass = property_exists($requestData, 'pass') ? $requestData->pass : null;
        if (!is_null($username) && !is_null($pass)) {
            $token = $jwt_auth->signup($username, hash('sha256', $pass));
            if ($token) {
                $data['token'] = $token;
                return $helpers->serializeOBJ($data, 200, $responseType);
            }
            $data['msg'] = "Incorrect username or pass.";
            return $helpers->serializeOBJ($data, 401, $responseType);
        }
        $data['msg'] = "Username and pass are required fields.";
        return $helpers->serializeOBJ($data, 401, $responseType);
    }
	
    public function verifyAction(Request $request)
    {
        $data = array();
        $helpers = $this->get('app.helpers');
        $jwt_auth = $this->get("app.jwt_auth");
        $em = $this->getDoctrine()->getManager();
        $responseType = $request->query->get('type', 'json');
        $requestData = json_decode($request->getContent());
        $auth = $request->headers->get('Authorization');
		$user = $em->getRepository('MarkerTabsBundle:User')->getUserIDLogged($auth, $helpers);
		$user = $em->getRepository('MarkerTabsBundle:User')->find($user);

        $pass = property_exists($requestData, 'pass') ? $requestData->pass : null;
        if (!is_null($pass)) {
            $token = $jwt_auth->signup($user->getUsername(), hash('sha256', $pass));
            if ($token) {
                $data['token'] = $token;
                return $helpers->serializeOBJ($data, 200, $responseType);
            }
            $data['msg'] = "Incorrect pass.";
            return $helpers->serializeOBJ($data, 401, $responseType);
        }
        $data['msg'] = "Username and pass are required fields.";
        return $helpers->serializeOBJ($data, 401, $responseType);
    }

    public function oneAction(Request $request, $id = null)
    {
        $data = array();
        $helpers = $this->get('app.helpers');
        $em = $this->getDoctrine()->getManager();
        $responseType = $request->query->get('type', 'json');
        $auth = $request->headers->get('Authorization');

        if ($em->getRepository('MarkerTabsBundle:User')->getUserIDLogged($auth, $helpers) == $id) {
            if (!is_null($id)) {
                $user = $em->getRepository('MarkerTabsBundle:User')->getOne($id);
                $data['data'] = $user;
                return $helpers->serializeOBJ($data, 200, $responseType, array('id', 'user', 'user_tabs', 'tab', 'tab_links', 'link'));
            }
            $data['msg'] = "ID is required.";
            return $helpers->serializeOBJ($data, 401, $responseType);
        }
        $data['msg'] = "Unauthorized.";
        return $helpers->serializeOBJ($data, 401, $responseType);
    }
}
