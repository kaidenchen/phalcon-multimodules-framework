<?php

/**
 * @file routes.php
 * @brief 仅适用于api模式    作用：路由表设置， 请再此维护您的接口地址
 * @author
 * @version
 * @date 2016-11-11
 */

return [

	'index' => [
		'label' => '默认模块',
		'namespace' => 'App\Index\Controllers',
		'list' => [
            #+--------------------------------------------------------------------------- +#
            #+  PDA 地区基础数据接口
            #+--------------------------------------------------------------------------- +#
            # PDA001 查看地区信息
			['label'=>'pda_info', 'url'=>'area/info', 'action' => 'index/area/info', 'disable'=>true],
            # PDA001 获取下级地区列表
			['label'=>'pda_sub_area', 'url'=>'area/subArea', 'action' => 'index/area/subArea', 'disable'=>true],

            #+--------------------------------------------------------------------------- +#
            #+  职员相关接口
            #+--------------------------------------------------------------------------- +#
            # PA001 添加职员
			['label'=>'pa_add', 'url'=>'employee/add', 'action' => 'index/employee/update', 'disable'=>true],
            # PA002 编辑职员
			['label'=>'pa_edit', 'url'=>'employee/edit', 'action' => 'index/employee/update', 'disable'=>true],
            # PA003 删除职员
			['label'=>'pa_del', 'url'=>'employee/del', 'action' => 'index/employee/del', 'disable'=>true],
            # PA004 启用职员
			['label'=>'pa_enable', 'url'=>'employee/enable', 'action' => 'index/employee/enable', 'disable'=>true],
            # PA005 禁用职员
			['label'=>'pa_disable', 'url'=>'employee/disable', 'action' => 'index/employee/disable', 'disable'=>true],
            # PA006 获取职员信息
			['label'=>'pa_info', 'url'=>'employee/info', 'action' => 'index/employee/info', 'disable'=>true],
            # PA007 获取职员列表
			['label'=>'pa_list', 'url'=>'employee/list', 'action' => 'index/employee/list', 'disable'=>true],


            #+--------------------------------------------------------------------------- +#
            #+  组织相关接口
            #+--------------------------------------------------------------------------- +#
            # PO001 添加组织
			['label'=>'org_add', 'url'=>'organization/add', 'action' => 'index/organization/add', 'disable'=>true],
            # PO002 修改组织
			['label'=>'org_update', 'url'=>'organization/update', 'action' => 'index/organization/update', 'disable'=>true],
            # PO003 删除组织
			['label'=>'org_delete', 'url'=>'organization/delete', 'action' => 'index/organization/delete', 'disable'=>true],
            # PO004 启用组织
			['label'=>'org_enable', 'url'=>'organization/enable', 'action' => 'index/organization/enable', 'disable'=>true],
            # PO005 停用组织
			['label'=>'org_disable', 'url'=>'organization/disable', 'action' => 'index/organization/disable', 'disable'=>true],
            # PO006 组织结构
			['label'=>'org_index', 'url'=>'organization/index', 'action' => 'index/organization/index', 'disable'=>true],
            # PO007 获取组织信息
			['label'=>'org_info', 'url'=>'organization/getInfo', 'action' => 'index/organization/getInfo', 'disable'=>true],


            #+--------------------------------------------------------------------------- +#
            #+  用户相关接口
            #+--------------------------------------------------------------------------- +#
            # PU001 sso用户登录接口
			['label'=>'pu_checkIn', 'url'=>'org/user/check/in', 'action' => 'index/user/checkIn', 'disable'=>true],
            # PU002 编辑用户
			['label'=>'pu_edit', 'url'=>'org/user/edit', 'action' => 'index/user/edit', 'disable'=>true],
            # PU003 注册用户
			['label'=>'pu_register', 'url'=>'org/user/register', 'action' => 'index/user/register', 'disable'=>true],
            # PU004 禁用用户
			['label'=>'pu_disable', 'url'=>'org/user/disable', 'action' => 'index/user/disable', 'disable'=>true],
            # PU005 启用用户
			['label'=>'pu_enable', 'url'=>'org/user/enable', 'action' => 'index/user/enable', 'disable'=>true],
            # PU006 删除用户
			['label'=>'pu_del', 'url'=>'org/user/del', 'action' => 'index/user/del', 'disable'=>true],
            # PU007 用户详情
			['label'=>'pu_info', 'url'=>'org/user/info', 'action' => 'index/user/info', 'disable'=>true],
            # PU008 用户列表
			['label'=>'pu_list', 'url'=>'org/user/list', 'action' => 'index/user/list', 'disable'=>true],


            #+--------------------------------------------------------------------------- +#
            #+  组织关联银行账号相关接口
            #+--------------------------------------------------------------------------- +#
            # POB001 组织拥有的银行卡账号列表
			['label'=>'org_bank_index', 'url'=>'organization/bankIndex', 'action' => 'index/organization/bankIndex', 'disable'=>true],
            # POB002 添加组织银行卡账号
			['label'=>'org_bank_add', 'url'=>'organization/addBank', 'action' => 'index/organization/addBank', 'disable'=>true],
            # POB003 修改组织银行卡账号
			['label'=>'org_bank_update', 'url'=>'organization/updateBank', 'action' => 'index/organization/updateBank', 'disable'=>true],
            # POB004 删除组织银行卡账号
			['label'=>'org_bank_delete', 'url'=>'organization/deleteBank', 'action' => 'index/organization/deleteBank', 'disable'=>true],
            # POB005 获取银行卡信息
			['label'=>'org_bank_info', 'url'=>'organization/getBankInfo', 'action' => 'index/organization/getBankInfo', 'disable'=>true],


            #+--------------------------------------------------------------------------- +#
            #+  部门相关接口
            #+--------------------------------------------------------------------------- +#
            # PD001 添加部门
			['label'=>'pd_add', 'url'=>'department/add', 'action' => 'index/department/update', 'disable'=>true],
            # PD002 编辑部门
			['label'=>'pd_edit', 'url'=>'department/edit', 'action' => 'index/department/update', 'disable'=>true],
            # PD003 删除部门
			['label'=>'pd_del', 'url'=>'department/del', 'action' => 'index/department/del', 'disable'=>true],
            # PA004 启用部门
			['label'=>'pd_enable', 'url'=>'department/enable', 'action' => 'index/department/enable', 'disable'=>true],
            # PA005 禁用部门
			['label'=>'pd_disable', 'url'=>'department/disable', 'action' => 'index/department/disable', 'disable'=>true],
            # PA006 部门详情
			['label'=>'pd_info', 'url'=>'department/info', 'action' => 'index/department/info', 'disable'=>true],

            #+--------------------------------------------------------------------------- +#
            #+  供应商相关接口
            #+--------------------------------------------------------------------------- +#
            # PS001 添加供应商
			['label'=>'ps_add', 'url'=>'supplier/add', 'action' => 'index/supplier/add', 'disable'=>true],
            # PS002 修改供应商
			['label'=>'ps_update', 'url'=>'supplier/update', 'action' => 'index/supplier/update', 'disable'=>true],
            # PS003 删除供应商
			['label'=>'ps_delete', 'url'=>'supplier/delete', 'action' => 'index/supplier/delete', 'disable'=>true],
            # PS004 供应商列表
			['label'=>'ps_index', 'url'=>'supplier/index', 'action' => 'index/supplier/index', 'disable'=>true],

            # PSC101 供应商分类列表
			['label'=>'psc_list', 'url'=>'supplier/categoryList', 'action' => 'index/supplier/categoryList', 'disable'=>true],
            # PSC102 添加供应商分类
			['label'=>'psc_add', 'url'=>'supplier/addCategory', 'action' => 'index/supplier/addCategory', 'disable'=>true],
            # PSC103 修改供应商分类
			['label'=>'psc_update', 'url'=>'supplier/updateCategory', 'action' => 'index/supplier/updateCategory', 'disable'=>true],
            # PSC104 删除供应商分类
			['label'=>'psc_delete', 'url'=>'supplier/deleteCategory', 'action' => 'index/supplier/deleteCategory', 'disable'=>true],

		]
	],
];
