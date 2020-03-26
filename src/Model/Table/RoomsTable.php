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
            ->notEmpty('name');
        
        return $validator;
    }

}