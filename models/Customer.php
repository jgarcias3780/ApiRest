<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property string $customer_id
 * @property string $name
 * @property string $email
 *
 * @property CustomerProduct[] $customerProducts
 * @property Product[] $products
 * @property Order[] $orders
 */
class Customer extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['name', 'email'], 'required'],
                [['name', 'email'], 'string', 'max' => 191],
                [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'customer_id' => 'Customer ID',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerProducts() {
        return $this->hasMany(CustomerProduct::className(), ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts() {
        return $this->hasMany(Product::className(), ['product_id' => 'product_id'])->viaTable('customer_product', ['customer_id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders() {
        return $this->hasMany(Order::className(), ['customer_id' => 'customer_id']);
    }

}
