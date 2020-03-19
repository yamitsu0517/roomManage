<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class RoomsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);
        $this->table('Rooms');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->hasMany('Reservations', [
            'foreignKey' => 'room_id'
        ]);
    }

    public function validationDefault(Validator $validator) {
        
        $validator
            ->integer('id')
            ->allowEmpty('id','create' );
        
        $validator  
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', [
              //  'rule' => 'validateUnique',
              //  'provider' => 'table',
                'message' => '登録できません'
            ]);
        
        return $validator;
    }

  //  public function buildRules(RulesChecker $rules) {
    //    $rules->add($rules->isUnique(['name'], ['message' => '登録できません']));
    //}
}