<?php

namespace app\modules\Admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\Admin\models\OrderItem;

/**
 * OrderItemSearch represents the model behind the search form of `app\modules\admin\models\OrderItem`.
 */
class OrderItemSearch extends OrderItem
{
    /**
     * {@inheritdoc}
     */
    public $globalSearch, $from_date, $to_date;
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'color', 'qty', 'size'], 'integer'],
            [['globalSearch', 'from_date', 'to_date'], 'safe'],
            [['price', 'discount', 'total'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OrderItem::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['between', 'DATE(created_date)', $this->from_date, $this->to_date])
            ->andFilterWhere([
                'OR',
                ['like', 'product_id', $this->globalSearch],
            ]);
        return $dataProvider;
    }
}
