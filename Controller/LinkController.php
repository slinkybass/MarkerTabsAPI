<?php

namespace MarkerTabsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LinkController extends Controller
{
    public function orderAction(Request $request, $id = null)
    {
        $data = array();
        $helpers = $this->get('app.helpers');
        $em = $this->getDoctrine()->getManager();
        $responseType = $request->query->get('type', 'json');
        $requestData = json_decode($request->getContent());
        $auth = $request->headers->get('Authorization');

        if ($auth) {
            if (!is_null($id)) {
                $link = $em->getRepository('MarkerTabsBundle:Link')->getOne($id);
				
				if ($requestData->position > $link->getPosition()) {
					$query = $em->getRepository('MarkerTabsBundle:Link')->createQueryBuilder('link');
					$query->where('link.tab = :tab')->setParameter('tab', $link->getTab());
					$query->andWhere('link.position > :pos_1')->setParameter('pos_1', $link->getPosition());
					$query->andWhere('link.position <= :pos_2')->setParameter('pos_2', $requestData->position);
					$linksAffected = $query->getQuery()->getResult();
					foreach($linksAffected as $linkAffected) {
						$linkAffected->setPosition($linkAffected->getPosition()-1);
						$em->persist($linkAffected);
						$em->flush();
					}
					$link->setPosition($requestData->position);
					$em->persist($link);
					$em->flush();
				} elseif ($requestData->position < $link->getPosition()) {
					$query = $em->getRepository('MarkerTabsBundle:Link')->createQueryBuilder('link');
					$query->where('link.tab = :tab')->setParameter('tab', $link->getTab());
					$query->andWhere('link.position < :pos_1')->setParameter('pos_1', $link->getPosition());
					$query->andWhere('link.position >= :pos_2')->setParameter('pos_2', $requestData->position);
					$linksAffected = $query->getQuery()->getResult();
					foreach($linksAffected as $linkAffected) {
						$linkAffected->setPosition($linkAffected->getPosition()+1);
						$em->persist($linkAffected);
						$em->flush();
					}
					$link->setPosition($requestData->position);
					$em->persist($link);
					$em->flush();
				}
				
                $data['data'] = $link;
                return $helpers->serializeOBJ($data, 200, $responseType, array('id', 'link'));
            }
            $data['msg'] = "ID is required.";
            return $helpers->serializeOBJ($data, 401, $responseType);
        }
        $data['msg'] = "Unauthorized.";
        return $helpers->serializeOBJ($data, 401, $responseType);
    }
}
