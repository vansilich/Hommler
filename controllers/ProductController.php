<?php

namespace app\controllers;

use app\models\Country;
use app\models\Product;
use app\models\ProductSearch;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProductController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ]
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost && $model->load($this->request->post()) ) {

            if ( UploadedFile::getInstance($model, 'image') !== null ) {
                $image = UploadedFile::getInstance($model, 'image');
                $model->image = $image;
                $model->save();

                $model->uploadImage();
                $model->image = time() .'_'.$image->baseName . '.' . $image->extension;
            } else {
                $model->image = '';
            }
            $model->save();

            return $this->redirect(['view', 'id' => $model->sku]);
        }
        else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) ) {

            if ( ($model->oldAttributes['image'] !== '') && (UploadedFile::getInstance($model, 'image') === null) ) {
                $model->image = $model->oldAttributes['image'];
            }
            else {
                $image = UploadedFile::getInstance($model, 'image');
                $model->image = $image;
                $model->save();

                $timestamp = time();
                $model->uploadImage($timestamp);
                $model->image = $timestamp .'_'. $image->baseName . '.' . $image->extension;
            }

            $model->save();

            return $this->redirect(['view', 'id' => $model->sku]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $code
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     * @throws \yii\db\StaleObjectException
     *
     * @return void
     */
    public function actionMultipleDelete() :void
    {

        if (!$this->request->isPost) {
            throw new InvalidArgumentException();
        }

        $post_data = $this->request->post();
        if (isset($post_data['product_ids']) && $post_data['product_ids'] !== []) {
            foreach ($post_data['product_ids'] as $id) {
                $model = $this->findModel( Html::encode($id) );
                $model->delete();
            }
        }

    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}