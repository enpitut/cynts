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
    
    //�ۑ��O�Ƀp�X���[�h�̃n�b�V����
    public function beforeSave($options = array()) {
        if(!$this->id){
            $passwordHasher = new SimplePasswordHasher();
            $this->data['User']['password'] = $passwordHasher->hash($this->data['User']['password']);
        }
        return true;
    }
 /**
    //�o���f�[�V����
    public $validate = array(
        'mail' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '�K�{���͂ł�',
                'required' => true,
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => '���p�p�����̂ݓ��͂��Ă�������',
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => '���̃A�h���X�͊��ɓo�^����Ă��܂�'
            ),
        ),
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '�K�{���͂ł�',
                'required' => true,
            ),
            'alphaNumeric' => array(
                'rule' => array('alphaNumeric'),
                'message' => '���p�p�����̂ݓ��͂��Ă�������',
            ),
        ),
        'password' => array(
            'notEmpty' => array(
                'password_rule1'=> array(
                    'rule' => array('notEmpty'),
                    'message' => '�K�{���͂ł�',
                ),
                'password_rule2'=> array(
                    'rule' => 'alphaNumeric',
                    'message' => '�A���t�@�x�b�g�܂��͐����݂̂ł�',
                 ),
                'password_rule3'=> array(
                    'rule' => array('minLength', '4'),
                    'message' => '4�����ȏ�',
                 ),
                 'password_rule4'=> array(
                    'comWith' => array(
                        'rule' => array('compareWith', 'password_re')
                        ),
                    'message' => '�p�X���[�h���Ⴂ�܂�',
                 ),        
                'required' => true,
            ),
        ),
    );
**/
    //���[�U���ƃp�X���[�h���o�^�ς݂��m�F
    public function check($data) {
        $n = $this->find('count', array(
                'conditions' => array(
                        'User.name' => $data['User']['name'],
                        'User.password' => $data['User']['password'],
                        'User.mail' => $data['User']['mail'],
                )
        ));
        return $n > 0 ? true : false;
    }
}
