<?php

namespace backend\models;

use common\models\InfoBlock;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ServicePrice;

/**
 * ServicePriceSearch represents the model behind the search form of `frontend\models\ServicePrice`.
 */
class ServicePriceSearch extends ServicePrice
{
    public $service_title;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_id'], 'integer'],
            [['title', 'text', 'service_title'], 'safe'],
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
        $query = ServicePrice::find();
        $query->joinWith('service');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['service_title'] = [
            'asc' => [InfoBlock::tableName().'title' => SORT_ASC],
            'desc' => [InfoBlock::tableName().'title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', InfoBlock::tableName().'title', $this->service_title]);

        return $dataProvider;
    }
}
