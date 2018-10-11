<?php

namespace MarkerTabsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TabController extends Controller
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
                $tab = $em->getRepository('MarkerTabsBundle:Tab')->getOne($id);
				$user = $em->getRepository('MarkerTabsBundle:User')->getUserIDLogged($auth, $helpers);
				
				if ($requestData->position > $tab->getPosition()) {
					$query = $em->getRepository('MarkerTabsBundle:Tab')->createQueryBuilder('tab');
					$query->where('tab.user = :user')->setParameter('user', $user);
					$query->andWhere('tab.position > :pos_1')->setParameter('pos_1', $tab->getPosition());
					$query->andWhere('tab.position <= :pos_2')->setParameter('pos_2', $requestData->position);
					$tabsAffected = $query->getQuery()->getResult();
					foreach($tabsAffected as $tabAffected) {
						$tabAffected->setPosition($tabAffected->getPosition()-1);
						$em->persist($tabAffected);
						$em->flush();
					}
					$tab->setPosition($requestData->position);
					$em->persist($tab);
					$em->flush();
				} elseif ($requestData->position < $tab->getPosition()) {
					$query = $em->getRepository('MarkerTabsBundle:Tab')->createQueryBuilder('tab');
					$query->where('tab.user = :user')->setParameter('user', $user);
					$query->andWhere('tab.position < :pos_1')->setParameter('pos_1', $tab->getPosition());
					$query->andWhere('tab.position >= :pos_2')->setParameter('pos_2', $requestData->position);
					$tabsAffected = $query->getQuery()->getResult();
					foreach($tabsAffected as $tabAffected) {
						$tabAffected->setPosition($tabAffected->getPosition()+1);
						$em->persist($tabAffected);
						$em->flush();
					}
					$tab->setPosition($requestData->position);
					$em->persist($tab);
					$em->flush();
				}
				
                $data['data'] = $tab;
                return $helpers->serializeOBJ($data, 200, $responseType, array('id', 'tab'));
            }
            $data['msg'] = "ID is required.";
            return $helpers->serializeOBJ($data, 401, $responseType);
        }
        $data['msg'] = "Unauthorized.";
        return $helpers->serializeOBJ($data, 401, $responseType);
    }
}
