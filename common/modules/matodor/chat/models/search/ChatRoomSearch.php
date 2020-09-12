<?php

namespace matodor\chat\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use matodor\chat\models\ChatRoom;

/**
 * ChatRoomSearch represents the model behind the search form of `matodor\chat\models\ChatRoom`.
 */
class ChatRoomSearch extends ChatRoom
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['business_id', 'token', 'title'], 'safe'],
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
        $query = ChatRoom::find();

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
        ]);

        $query->andFilterWhere(['like', 'business_id', $this->business_id])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
