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
            ->notEmpty('name', 'A username is required');
            
        $validator
            ->requirePresence('mail', 'create')
            ->notEmpty('mail', 'A mail is required')
            ->add('mail', 'validFormat', [
                'rule' => 'email',
                'message' => 'E-mail must be valid'
            ]);
        
        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', 'A password is required');

        $validator
            ->add('created_at', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('created_at');

        $validator
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

        return $validator;
    }
}
