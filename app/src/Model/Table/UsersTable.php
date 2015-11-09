<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $Coordinates
 * @property \Cake\ORM\Association\HasMany $Favorites
 */
class UsersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('users');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->hasMany('Coordinates', [
            'foreignKey' => 'user_id'
        ]);

        $this->hasMany('Favorites', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name', '名前を入力してください')
            ->add(
                'name',
                'custom',
                [
                    'rule' => function($value) {
                        if (mb_strlen($value) > 100) {
                            return false;
                        }
                        return true;
                    },
                    'message' => '名前は100文字以下で設定してください',
                ]
            );

        $validator
            ->requirePresence('mail', 'create')
            ->notEmpty('mail', 'メールアドレスを入力してください')
            ->add('mail',
                [
                    'emailValid' => [
                        'rule' => ['email', true],
                        'message' => '正しいメールアドレスを入力してください',
                    ],
                    'emailUnique' => [
                        'message' => 'このメールアドレスは既に登録されています',
                        'rule' => 'validateUnique',
                        'provider' => 'table',
                    ],
                ]
            );

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'パスワードを入力してください')
            ->add(
                'password',
                'custom',
                [
                    'rule' => function($value) {
                        if (strlen($value) < 4) {
                            return false;
                        }
                        return true;
                    },
                    'message' => 'パスワードは4文字以上で設定してください',
                ]
            );

        $validator
            ->add(
                'retype_password',
                'compare',
                [
                    'rule' => ['compareWith', 'password'],
                    'message' => 'パスワードが違います'
                ]
            )
            ->requirePresence('retype_password', 'create')
            ->notEmpty('retype_password', 'パスワードを再入力してください');

        $validator
            ->add('created_at', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('created_at');

        $validator
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

        return $validator;
    }
}
