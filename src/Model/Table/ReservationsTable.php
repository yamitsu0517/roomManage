<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ReservationsTable extends Table{

    public function initialize(array $config) {
        parent::initialize($config);
        $this->table('reservations');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('users', [
            'foreignKey' => 'user_id',
            'joinType'   => 'INNER'
        ]);

        $this->belongsTo('rooms', [
            'foreignKey' => 'room_id',
            'joinType'   => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {
        
        $validator
            ->integer('id')
            ->allowEmpty('id','create');
        
        $validator
            ->integer('user_id');
        
        $validator
            ->integer('room_id')
            ->notEmpty('room_id');
        
        $validator  
            ->requirePresence('start_time', 'create')
            ->notEmpty('start_time');

        $validator  
        ->requirePresence('end_time', 'create')
        ->notEmpty('end_time');
        
        
        return $validator;
    }
}