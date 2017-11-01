<?php
namespace App\Cli\Tasks;

use App\Index\Models\BaseArea;

class AreaTask extends \Phalcon\Cli\Task
{

    /**
     * @brief initAreaDbAction 
     * 初始化Area DB
     *
     * @return 
     */
    public function initAreaDbAction() 
    {
        die("请勿随意初始化数据. \n");
        $provinces = $this->_initProvinceData();
        if ( $provinces ) {
            foreach($provinces as $val) {
                $this->_initStreeData($val['adcode'], $val['area_id']);
            }
        }
        echo "数据初始化完成\n";
    }

    /**
     * @brief _initProvince 
     *
     * @return 
     */
    private function _initProvinceData() 
    {
        $ad_code = '100000'; // 中华人民共和国
        $data = $this->_getBaiduDists($ad_code, 1);
        if ( $data['infocode'] == '10000' ) {
            if ( isset($data['districts']) && !empty($data['districts']) ) {
                $districts = array_shift($data['districts']);
                if ( !empty($districts['districts']) ) {
                    foreach($districts['districts'] as &$val) {
                        @list($longitude, $latitude) = explode(',', $val['center']);
                        $area_id = $this->_writeDb('0', $val['adcode'], $val['name'], $longitude, $latitude,  $val['level']);
                        if ( ! $area_id ) echo "写入数据库失败,area_name:". $val['name']."\n";
                        $val['area_id'] = $area_id;
                    }
                }
                return $districts['districts'];
            }
        }
        echo "获取省份信息失败\n";
    }


    /**
     * @brief _initStreeData 
     *
     * @param $province_ad_code
     * @param $parent_area_id
     *
     * @return 
     */
    public function _initStreeData($province_ad_code, $parent_area_id)
    {
        if ( !$province_ad_code || !$parent_area_id ) return false;
        $data = $this->_getBaiduDists($province_ad_code, 3); // 返回下三级行政区
        if ( $data['infocode'] == '10000' ) {
            if ( isset($data['districts']) && !empty($data['districts']) ) {
                $districts = array_shift($data['districts']);
                if ( isset($districts['districts']) && $districts['districts'] ) {
                    $this->_loopDistricts($districts['districts'], $parent_area_id);
                }
            }
        } else {
            echo "获取街道信息失败\n";
        }
    }

    /**
     * @brief _loopDistricts 
     *
     * @param $districts
     * @param $parent_area_id
     *
     * @return 
     */
    private function _loopDistricts($districts, $parent_area_id) 
    {
        if ( isset($districts) && $districts ) {
            foreach($districts as $k=>$v) {
                @list($longitude, $latitude) = explode(',', $v['center']);
                $area_id = $this->_writeDb($parent_area_id, $v['adcode'], $v['name'], $longitude, $latitude,  $v['level']);
                if ( ! $area_id ) echo "写入数据库失败,area_name:". $v['name']."\n";
                if ( !empty($v['districts'] )) {
                    $this->_loopDistricts($v['districts'], $area_id);
                }
            }
        }
    }


    /**
     * @brief _getBaiduDists 
     *
     * @param $ad_code
     * @param $subdistrict
     *
     * @return 
     */
    private function _getBaiduDists($ad_code, $subdistrict = 1) 
    {
        $url = 'http://restapi.amap.com/v3/config/district';
        $params = [];
        $params['key'] = 'bd832d1817cfbcbd534dddc3693ad6dd';
        $params['subdistrict'] = $subdistrict;
        $params['keywords'] = $ad_code;
        $result = $this->di->getUtils()->curlGet($url, $params);
        return !empty($result) ? json_decode($result, true) : [];
    }

    /**
     * @brief _writeDb
     *
     * @param $parent_id
     * @param $area_code
     * @param $area_name
     * @param $longitude
     * @param $latitude
     * @param $level
     *
     * @return 
     */
    private function _writeDb($parent_id, $area_code, $area_name, $longitude, $latitude, $level) 
    {
        if ( ! $area_code || ! $area_name ) return false;
        $data = [];
        $data['area_id'] = $this->di->getGid()->getId();
        $data['parent_id'] = $parent_id ;
        $data['area_code'] = $area_code;
        $data['area_name'] = $area_name;
        $data['longitude'] = $longitude;
        $data['latitude'] = $latitude;
        $data['level'] = $level;
        $data['status'] = 1;
        $data['is_deleted'] = 0;
        $obj = new BaseArea();
        $obj->assign($data);
        if ( $obj->create() == false ) {
            echo "DB写入失败, area_code: $area_code , area_name:$area_name \n";
            /*
            foreach($obj->getMessages() as $val) {
                print_r($val->getMessage());
                die;
            }
            */
            return false;
        }
        return $data['area_id'];
    }

}
