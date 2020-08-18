<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Review;

/**
 * ReviewSearch represents the model behind the search form of `frontend\models\Review`.
 */
class ReviewSearch extends Review
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'is_visible'], 'integer'],
            [['author', 'text'], 'safe'],
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
        $query = Review::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_visible' => $this->is_visible,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
