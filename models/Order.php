<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $order_id
 * @property string $customer_id
 * @property string $creation_date
 * @property string $delivery_address
 * @property double $total
 *
 * @property Customer $customer
 * @property OrderDetail[] $orderDetails
 */
class Order extends \yii\db\ActiveRecord {

    const SCENARIO_CREATE = 'create';
    const SCENARIO_LIST = 'list';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'order';
    }
    public $start_date;
    public $end_date;
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['customer_id', 'creation_date', 'delivery_address', 'total'], 'required'],
                [['customer_id'], 'integer'],
                [['creation_date'], 'safe'],
                [['total'], 'number'],
                [['delivery_address'], 'string', 'max' => 191],
                [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'customer_id']],
                [['start_date','end_date'], 'safe'],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['customer_id', 'creation_date', 'delivery_address', 'total'];
        $scenarios['list'] = ['customer_id', 'start_date', 'end_date'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'order_id' => 'Order ID',
            'customer_id' => 'Customer ID',
            'creation_date' => 'Creation Date',
            'delivery_address' => 'Delivery Address',
            'total' => 'Total',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails() {
        return $this->hasMany(OrderDetail::className(), ['order_id' => 'order_id']);
    }

}
