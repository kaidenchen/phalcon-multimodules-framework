<?php

namespace App\Library;

class Utils 
{

    /**
     * @brief dbExecInfo 
     *
     * @return 
     */
    public function getSqls( $bTime = false ) 
    {
        $DI = \phalcon\DI\FactoryDefault::getDefault();

        $profiles = $DI->getProfiler()->getProfiles();
        foreach ($profiles as $profile) {
            echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
            if ( $bTime ) {
                echo "Start Time: ", $profile->getInitialTime(), "\n";
                echo "Final Time: ", $profile->getFinalTime(), "\n";
                echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
            }
        }
        return true;
    }

    /**                                
     * @brief dd 打印调试函数          
     *                                 
     * @param $data                    
     *                                 
     * @return                         
     */                                
    public function dd($data) 
    {                                  
        echo "<pre>";                  
        print_r($data);                
        echo "</pre>";                 
        if ( is_array($data) ) {       
            $data = json_encode($data);
        }                              
        error_log($data);              
        die;                           
    }                                  


}
