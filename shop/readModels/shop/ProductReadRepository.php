<?php

namespace shop\readModels\shop;

use shop\entities\shop\Brand;
use shop\entities\shop\Category;
use shop\entities\shop\product\Product;
use shop\entities\shop\product\Value;
use shop\entities\shop\Tag;
use shop\forms\shop\search\SearchForm;
//use shop\forms\shop\search\ValueForm;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class ProductReadRepository
{
    public function getAll(): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')/*->NotEmpty('p')*/->with('mainPhoto');
        return $this->getProvider($query);
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')/*->NotEmpty('p')*/->with('mainPhoto', 'category');
        $ids = ArrayHelper::merge([$category->id], $category->getLeaves()->select('id')->column());
        $query->joinWith(['categoryAssignments ca'], false);
        $query->andWhere(['or', ['p.category_id' => $ids], ['ca.category_id' => $ids]]);
        $query->groupBy('p.id');
        return $this->getProvider($query);
    }

    public function getAllByBrand(Brand $brand): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')/*->NotEmpty('p')*/->with('mainPhoto');
        $query->andWhere(['p.brand_id' => $brand->id]);
        return $this->getProvider($query);
    }

    public function getAllByTag(Tag $tag): DataProviderInterface
    {
        $query = Product::find()->alias('p')->active('p')/*->NotEmpty('p')*/->with('mainPhoto');
        $query->joinWith(['tagAssignments ta'], false);
        $query->andWhere(['ta.tag_id' => $tag->id]);
        $query->groupBy('p.id');
        return $this->getProvider($query);
    }

    public function find($id): ?Product
    {
        return Product::find()->andWhere(['id' => $id])->one();
    }

    public function getFeatured($limit)
    {
        $all = Product::find()->active()->notEmpty()->andWhere(['featured' => true])->all();
        $limit = (count($all) < $limit) ? count($all) : $limit;
        $items =  array_rand($all, $limit);
        $result = [];
        foreach ($items as $item) {
            $result[] = $all[$item];
        }
        return $result;
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => ['id' => SORT_DESC],
                    'attributes' => [
                        'id' => [
                            'asc' => ['p.id' => SORT_ASC], 'desc' => ['p.id' => SORT_DESC],
                        ],
                        'name' => [
                            'asc' => ['p.name' => SORT_ASC], 'desc' => ['p.name' => SORT_DESC],
                        ],
                        'price' => [
                            'asc' => ['p.price_new' => SORT_ASC], 'desc' => ['p.price_new' => SORT_DESC],
                        ],
                        'rating' => [
                            'asc' => ['p.rating' => SORT_ASC], 'desc' => ['p.rating' => SORT_DESC],
                        ],

                    ],
                ],
                'pagination' => [
                    'defaultPageSize' => 15,
                    'pageSizeLimit' => [15, 100],
                ],
            ]
        );
    }

    public function search(SearchForm $form): DataProviderInterface
    {
        $query = Product::find()->alias('p')/*->NotEmpty('p')*/->with('category', 'mainPhoto');
        if ($form->brand) {
            $query->andWhere(['brand_id' => $form->brand]);
        }

        if ($form->category) {
            if ($category = Category::findOne($form->category)) {
                $ids = ArrayHelper::merge([$category->id], $category->getLeaves()->select('id')->column());
                $query->joinWith(['categoryAssignments ca'], false);
                $query->andWhere(['or', ['p.category_id' => $ids], ['ca.category_id' => $ids]]);
                $query->groupBy('p.id');

            } else {
                $query->andWhere(['p.id' => 0]);
            }
        }
        if ($form->values) {
            $productIds = null;
            foreach ($form->values as $value) {
                if ($value->isFilled()) {
                    $q = Value::find()->andWhere(['characteristic_id' => $value->getId()]);
                    $q->andFilterWhere(['>=', 'CAST(value AS SIGNED)', $value->from]);
                    $q->andFilterWhere(['<=', 'CAST(value AS SIGNED)', $value->to]);
                    $q->andFilterWhere(['value' => $value->equal]);
                    $foundIds = $q->select('product_id')->column();
                    $productIds = $productIds === null ? $foundIds : array_intersect($productIds, $foundIds);
                }
            }
            if ($productIds !== null) {
                $query->andWhere(['p.id' => $productIds]);
            }
        }
        /******  Поиск оп тексту ***/
        if (!empty($form->text)) {
            $form->text = trim(htmlspecialchars($form->text));
            $words = explode(' ', $form->text);
            foreach ($words as $word) {
                $query->andWhere(['or', ['like', 'code', $word], ['like', 'name', $word]]);
            }
        }
        $query->groupBy('p.id');
        return $this->getProvider($query);
        /*
        $pagination = new Pagination([
            'pageSizeLimit' => [15, 100],
            'validatePage' => false,
        ]);
        $sort = new Sort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id',
                'name',
                'price',
                'rating',
            ],
        ]);
        $response = $this->client->search([
            'index' => 'shop',
            'type' => 'products',
            'body' => [
                '_source' => ['id'],
                'from' => $pagination->getOffset(),
                'size' => $pagination->getLimit(),
                'sort' => array_map(function ($attribute, $direction) {
                    return [$attribute => ['order' => $direction === SORT_ASC ? 'asc' : 'desc']];
                }, array_keys($sort->getOrders()), $sort->getOrders()),
                'query' => [
                    'bool' => [
                        'must' => array_merge(
                            array_filter([
                                !empty($form->category) ? ['term' => ['categories' => $form->category]] : false,
                                !empty($form->brand) ? ['term' => ['brand' => $form->brand]] : false,
                                !empty($form->text) ? ['multi_match' => [
                                    'query' => $form->text,
                                    'fields' => [ 'name^3', 'description' ]
                                ]] : false,
                            ]),
                            array_map(function (ValueForm $value) {
                                return ['nested' => [
                                    'path' => 'values',
                                    'query' => [
                                        'bool' => [
                                            'must' => array_filter([
                                                ['match' => ['values.characteristic' => $value->getId()]],
                                                !empty($value->equal) ? ['match' => ['values.value_string' => $value->equal]] : false,
                                                !empty($value->from) ? ['range' => ['values.value_int' => ['gte' => $value->from]]] : false,
                                                !empty($value->to) ? ['range' => ['values.value_int' => ['lte' => $value->to]]] : false,
                                            ]),
                                        ],
                                    ],
                                ]];
                            }, array_filter($form->values, function (ValueForm $value) { return $value->isFilled(); }))
                        )
                    ],
                ],
            ],
        ]);
        $ids = ArrayHelper::getColumn($response['hits']['hits'], '_source.id');
        if ($ids) {
            $query = Product::find()
                ->NotEmpty()
                ->with('mainPhoto')
                ->andWhere(['id' => $ids])
                ->orderBy(new Expression('FIELD(id,' . implode(',', $ids) . ')'));
        } else {
            $query = Product::find()->andWhere(['id' => 0]);
        }
        return new SimpleActiveDataProvider([
            'query' => $query,
            'totalCount' => $response['hits']['total'],
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
*/
    }

    public function getWishlist($userId)
    {
        return new ActiveDataProvider([
            'query' => Product::find()
                ->alias('p')->active('p')
                ->joinWith('wishlistItems w', false, 'INNER JOIN')
                ->andWhere(['w.user_id' => $userId]),
            'sort' => false,
        ]);
    }

}
