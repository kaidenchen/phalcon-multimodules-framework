<?php

namespace App\Home\Controllers;

use App\BaseController; 

class IndexController extends BaseController
{

    /**
     * @AuthMiddleware("App\Base\Middleware\Test")
     */
    public function indexAction()
    {
        if ( $this->request->isGet() == true )  {
            $params = [                                                            
                    [ 'a_id', 'rules'=>'required|int' ], 
                    [ 'sub_system', 'default'=>0 , 'rules'=>'required' ]
                ];                                                           
            $data = $this->getQuery($params);                                          
            unset($params);                                                        
            print_r($data);die;
        }
    }

}

