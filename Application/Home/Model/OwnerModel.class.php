<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2
 * Time: 19:10
 */

namespace Home\Model;


use Think\Model;

class OwnerModel extends Model
{
    protected $_validate = array(
        array('name', 'require', '姓名不能为空'),
        array('tel', 'unique', '电话号码已经存在'),
    );
}