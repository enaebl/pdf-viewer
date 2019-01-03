<?php

namespace frontend\controllers;

use common\models\LoginForm;
use Exception;
use frontend\models\Annotation;
use frontend\models\Item;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller {

    public function init() {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'allow' => true
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'sign-in' => ['post'],
                    'sign-out' => ['post'],
                    'update-annotations' => ['post'],
                ],
            ],
        ];
    }

    /* public function actionSearch($criteria, $current_page, $elems_per_page) {
      $result = ['page' => 1, 'products' => []];
      $clean_criteria = strtolower(trim($criteria));
      $sql = "select * from v_search_terms where criteria like '%$clean_criteria%'";
      $items_count = VSearchTerms::findBySql($sql)->count();

      if ($items_count > 0) {
      $offset = $elems_per_page * $current_page - $elems_per_page;
      if ($offset < 0 || $offset + 1 > $items_count) {
      $current_page = 1;
      $offset = 0;
      }
      $products = VSearchTerms::findBySql("select * from v_search_terms where criteria like '%$clean_criteria%' order by name limit $offset, $elems_per_page")->all();
      foreach ($products as $product) {
      $prod_aux = $product->getAttributes(['id', 'ps', 'name', 'scientific_name', 'description', 'price', 'image', 'in_stock', 'water', 'sun', 'product_type', 'fixture_type']);
      $product_id = $prod_aux['id'];
      $back_url = Yii::$app->urlManagerBack->createUrl('/');
      $image = $prod_aux['image'];
      $thumbnail = ($image) ? $back_url . "imgs/productos/$product_id/$image" : $back_url . "imgs/product.png";
      $prod_aux['thumbnail'] = $thumbnail;
      $result['products'][] = $prod_aux;
      }
      $result['page'] = intval($current_page);
      $result['pages_count'] = ceil($items_count / $elems_per_page);
      }
      return $result;
      }

      public function actionProductsPerType($product_type_id, $current_page, $elems_per_page = 6, $fixture_type_id = 0) {
      $result = ['page' => 1, 'products' => []];
      if ($fixture_type_id != 0) {
      $models = Product::find()->where(['product_type_id' => $product_type_id, 'fixture_type_id' => $fixture_type_id]);
      } else {
      $models = Product::find()->where(['product_type_id' => $product_type_id]);
      }
      $items_count = $models->count();
      if ($items_count > 0) {
      $offset = $elems_per_page * $current_page - $elems_per_page;
      if ($offset < 0 || $offset + 1 > $items_count) {
      $current_page = 1;
      $offset = 0;
      }
      $products = $models->orderBy(['name' => SORT_ASC])->limit($elems_per_page)->offset($offset)->all();
      $i = 0;
      foreach ($products as $product) {
      $prod_aux = $product->getAttributes(['id', 'name', 'scientific_name', 'description', 'price', 'in_stock', 'image', 'water', 'sun']);
      $product_id = $prod_aux['id'];
      $back_url = Yii::$app->urlManagerBack->createUrl('/');
      $image = $prod_aux['image'];
      $thumbnail = ($image) ? $back_url . "imgs/productos/$product_id/$image" : $back_url . "imgs/product.png";
      $prod_aux['thumbnail'] = $thumbnail;
      $result['products'][] = $prod_aux;
      }
      $result['page'] = intval($current_page);
      $result['pages_count'] = ceil($items_count / $elems_per_page);
      }
      return $result;
      } */

    public function actionFilesList($id) {
        $models = Item::findAll(['user_id' => $id]);
        $res = [];
        foreach ($models as $value) {
            $full_file_path = Yii::$app->getBasePath() . "/../items/$id/$value->generic_file_name";
            if (file_exists($full_file_path)) {
                $res[] = $value;
            }
        }
        return $res;
    }

    public function actionUpdateAnnotations() {
        $res = [];
        if (Yii::$app->user->isGuest) {
            $res = ['status' => 0, 'msg' => 'Your session has expired. Please, log in again.'];
        } else {
            try {
                $params = Yii::$app->request->post();
                $document_id = $params['document_id'];
                $annotations = $params['annotations'];
                $document = Item::findOne(['generic_file_name' => $document_id]);
                if ($document) {
                    if ($document->user_id == Yii::$app->user->identity->id) {
                        $annotation = Annotation::findOne(['item_id' => $document_id]);
                        if (!$annotation) {
                            $annotation = new Annotation();
                            $annotation->item_id = $document_id;
                        }
                        $annotation->value = $annotations;
                        $annotation->save(false);
                        $res = ['status' => 1, 'msg' => 'Annotations updated'];
                    }
                    else {
                        $res = ['status' => 0, 'msg' => 'You are not allowed to annotate this document'];
                    }
                } else {
                    $res = ['status' => 0, 'msg' => 'Document not found'];
                }
                return $res;
            } catch (Exception $exc) {
                $res = ['status' => 0, 'msg' => $exc->getMessage()];
            }
        }
        return $res;
    }

    public function actionGetAnnotations($document_id) {
        $res = null;
        $item = Item::findOne(['generic_file_name' => $document_id]);
        if ($item && $item->user_id == Yii::$app->user->identity->id) {
            $annotation = Annotation::findOne(['item_id' => $document_id]);
            if ($annotation) {
                $res = $annotation->value;
            }
        }
        return $res;
    }

    public function actionAnnotations($document_id) {
        $res = null;
        $item = Item::findOne(['generic_file_name' => $document_id]);
        $annotation = Annotation::findOne(['item_id' => $document_id]);
        if ($annotation) {
            $res = $annotation->value;
        }
        return $res;
    }

    public function actionClearAnnotations($document_id) {
        $annotation = Annotation::findOne(['item_id' => $document_id]);
        if ($annotation) {
            $annotation->delete();
        }
    }

    public function actionSignOut() {
        Yii::$app->user->logout();
        return ['guest' => true, 'data' => []];
    }

    public function actionSignIn($username, $password) {
        $auth_info = [];
        if (Yii::$app->user->isGuest) {
            $model = new LoginForm(['username' => $username, 'password' => $password]);
            if ($model->login()) {
                $auth_info = ['guest' => false, 'data' => Yii::$app->user->identity->getAttributes(['id', 'username'])];
            } else {
                $auth_info = ['guest' => true, 'data' => []];
            }
        } else {
            $auth_info = ['guest' => false, 'data' => Yii::$app->user->identity->getAttributes(['id', 'username'])];
        }
        return $auth_info;
    }

}
