<?php

namespace app\models;

use app\models\Tasks;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;
/**
 * TasksSearch represents the model behind the search form of `app\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tasks_id', 'tasks_city_id', 'tasks_status_number', 'tasks_category_number', 'tasks_photo_id', 'tasks_user_id'], 'integer'],
            [['tasks_title', 'tasks_body', 'tasks_date_upload'], 'safe'],
            [['tasks_price'], 'number'],
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
        $query = Tasks::find()->select(['tasks_title','tasks_price','tasks_date_upload','tasks_photo_id'])->where(['tasks_status_number' => 1])->orderBy(['tasks_date_upload' => SORT_DESC,]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                // Размер выводимых элементов на страницу.
                // Беру из настроек своего модуля blog
                'pageSize' => '20',
                // Размер эл-тов на страницу по умолчанию. Зачем нужен - поясню после кода
                'defaultPageSize' => '20',
                // Так подавляется ссылка на первую страницу вида /category-name-х/1/
                // Вместо неё выведется  /category-name-х/
                'forcePageParam' => false,
            ]
        ]);

        $this->load($params,'');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tasks_id' => $this->tasks_id,
            'tasks_city_id' => $this->tasks_city_id,
            'tasks_price' => $this->tasks_price,
            'tasks_date_upload' => $this->tasks_date_upload,
            'tasks_status_number' => $this->tasks_status_number,
            'tasks_category_number' => $this->tasks_category_number,
            'tasks_photo_id' => $this->tasks_photo_id,
            'tasks_user_id' => $this->tasks_user_id,
        ]);

        $query->andFilterWhere(['ilike', 'tasks_title', $this->tasks_title])
            ->andFilterWhere(['ilike', 'tasks_body', $this->tasks_body]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
}
