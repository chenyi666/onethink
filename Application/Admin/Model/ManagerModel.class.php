<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26
 * Time: 12:54
 */

namespace Admin\Model;


use Think\Model;

class ManagerModel extends Model
{
    protected $_validate = array(
        array('name','require','姓名必须填写'),
        array('tel','require','电话必须填写'),
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('name', 'htmlspecialchars', self::MODEL_BOTH, 'function'),
        array('status', '0', self::MODEL_INSERT),
    );
}