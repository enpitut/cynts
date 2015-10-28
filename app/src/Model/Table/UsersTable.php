<?php
namespace App\Model\Table;
use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
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
            ->notEmpty('name', 'Username is required');

        $validator
            ->requirePresence('mail', 'create')
            ->notEmpty('mail', 'E-mail is required')
            ->add('mail',  [
                'emailValid'=>[
                    'rule' => ['email', true],
                    'message' => 'E-mail must be valid',
                ],
                'emailUnique'=>[
                    'message'=>'This email is already registered',
                    'rule' => 'validateUnique', 'provider' => 'table'
                ],
            ]);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'Password is required')
            ->add('password',[
                'Length' => [
                    'rule' => ['minLength', 4],
                    'message' => 'Your password must be at least 4 characters long'
                ],
            ]);
        $validator
            ->add('retype_password', 'compare', [
                'rule' => ['compareWith', 'password'],
                'message'=>'Passwords do not match'])
            ->requirePresence('retype_password', 'create')
            ->notEmpty('retype_password', 'Retype password is required');
        $validator
            ->add('created_at', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('created_at');
        $validator
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');
        return $validator;
    }
}