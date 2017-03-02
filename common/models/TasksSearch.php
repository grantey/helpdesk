<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tasks;

/**
 * TasksSearch represents the model behind the search form about `common\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    public $statusLabel;
    public $companyLabel;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [            
            [['author', 'companyLabel', 'message', 'date_get', 'date_start', 'date_finish', 'statusLabel'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Tasks::find();

        $query->joinWith(['company', 'status']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['date_get' => SORT_DESC]]
        ]);
        
        $this->load($params);
        file_put_contents("test.txt", $this->date_finish === NULL ? "1" : "0");

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $finish = $this->date_finish === NULL ? "3000-01-01" : $this->date_finish === '' ? $this->date_finish : $this->date_finish."23:23:23";
        
        // grid filtering conditions
        $query->andFilterWhere(['>=', 'date_get', $this->date_get])
            ->andFilterWhere(['>=', 'date_start', $this->date_start])
            ->andFilterWhere(['<=', 'date_finish', $finish])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['companyId' => $this->companyLabel])
            ->andFilterWhere(['statusId' => $this->statusLabel]);
  
        return $dataProvider;
    }
 
    /**     
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function exportSearch($params)
    {
        $query = Tasks::find();

        $query->joinWith(['company', 'status']);        
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query->all();
        }
        
        // grid filtering conditions
        $query->andFilterWhere(['>=', 'date_get', $this->date_get])
            ->andFilterWhere(['>=', 'date_start', $this->date_start])
            ->andFilterWhere(['<=', 'date_finish', $this->date_finish."23:23:23"])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['companyId' => $this->companyLabel])
            ->andFilterWhere(['statusId' => $this->statusLabel]);
        
        $query->orderBy(['date_get' => SORT_ASC]);
  
        return $query->all();
    }    
    
}
