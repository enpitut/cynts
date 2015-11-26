<?php
namespace App\Model\Table;

use App\Model\Entity\Coordinate;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Coordinates Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Favorites
 * @property \Cake\ORM\Association\BelongsToMany $Items
 */
class CoordinatesTable extends Table
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

        $this->table('coordinates');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Favorites', [
            'foreignKey' => 'coordinate_id'
        ]);
        $this->belongsToMany('Items', [
            'foreignKey' => 'coordinate_id',
            'targetForeignKey' => 'item_id',
            'joinTable' => 'coordinates_items'
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
            ->allowEmpty('photo');

        $validator
            ->add('n_like', 'valid', ['rule' => 'numeric'])
            ->requirePresence('n_like', 'create')
            ->notEmpty('n_like');

        $validator
            ->add('n_unlike', 'valid', ['rule' => 'numeric'])
            ->requirePresence('n_unlike', 'create')
            ->notEmpty('n_unlike');

        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');

        $validator
            ->add('created_at', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('created_at');

        $validator
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

        $validator
            ->add('sex', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sex');

        $validator
            ->add('season', 'valid', ['rule' => 'binary'])
            ->allowEmpty('season');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }
}
