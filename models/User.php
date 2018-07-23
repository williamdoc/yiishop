<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $uid 用户uid
 * @property string $nickname 用户名
 * @property string $moblie 手机号码
 * @property string $email 邮箱地址
 * @property int $sex 性别1.男2.女0.保密
 * @property string $avatar 头像
 * @property string $login_name 登录用户名
 * @property string $login_pwd 登录密码
 * @property string $login_salt 登录密码的随机秘钥
 * @property int $status 1.有效2.无（ 默认有效）
 * @property string $update_time 最后一次更新时间
 * @property string $create_time 插入时间
 */
class User extends \yii\db\ActiveRecord
{
    public function setPassword($password)
    {
        $this->login_pwd = $this->getSaltPassword($password);
    }

    public function setSalt($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
        $salt = "";
        for ($i=0;$i<$length;$i++) {
            $salt .= $chars[mt_rand(0,strlen($chars)-1)];
        }

        $this->login_salt = $salt;

    }
    //生成加密密码
    public function getSaltPassword($password)
    {
        return md5($password.md5($this->login_salt));
    }

    //校验密码是否一致
    public function verifyPassword($password)
    {
        return $this->login_pwd == $this->getSaltPassword($password);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['update_time', 'create_time'], 'safe'],
            [['nickname'], 'string', 'max' => 100],
            [['moblie', 'login_name'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 50],
            [['sex', 'status'], 'string', 'max' => 1],
            [['avatar'], 'string', 'max' => 64],
            [['login_pwd', 'login_salt'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'moblie' => 'Moblie',
            'email' => 'Email',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'login_name' => 'Login Name',
            'login_pwd' => 'Login Pwd',
            'login_salt' => 'Login Salt',
            'status' => 'Status',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
}
