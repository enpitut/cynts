<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Note that '*' is set to true, which allows all unspecified fields to be
     * mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * @param string $password
     * @return bool|string
     */
    public static function hashPassword($password)
    {
        return (new DefaultPasswordHasher())->hash($password);
    }
    
        public $name = 'User';
    
    //保存前にパスワードのハッシュ化
    public function beforeSave($options = array()) {
        if(!$this->id){
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        return true;
    }
    
     //バリデーション
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '必須入力です',
                'required' => true,
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => '半角英数字のみ入力してください',
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'このユーザ名は既に登録されています'
            ),
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '必須入力です',
                'required' => true,
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => '半角英数字のみ入力してください',
            ),
        ),
    );
    
}




//App::uses('AppModel', 'Model');
//App::uses('SimplePasswordHasher','Controller/Component/Auth');
/*
class User_HushPass extends AppModel {
    public $name = 'User';
    
    //保存前にパスワードのハッシュ化
    public function beforeSave($options = array()) {
        if(!$this->id){
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        return true;
    }

 }
 */