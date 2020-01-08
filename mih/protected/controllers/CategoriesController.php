<?php

class CategoriesController extends Controller {

    public $layout = 'column2';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            
        );
    }

     /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',  // allow all users to access 'index' and 'view' actions. : update, delete
                'actions' => array('index', 'view','create','update','delete'),
                'users' => array('*'),
            ),
            array(
                'allow',
                'users' => array('@'),
            ),
           
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView()
    {
        $categories = $this->loadModel();

        $this->render('view', array(
            'model' => $categories,
        ));
    }


    public function actionCreate()
    {
        $model = new Categories();

        if(isset($_POST['Categories']))
        {
            $model->attributes = $_POST['Categories'];

            if($model->save())
            {
                $this->redirect(array('view','id' => $model->id));
            }
        }
        $this->render('create',array(
            'model' => $model
        ));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if(isset($_POST['Categories'])) {
            $_POST['Categories']['title'] = $model->title;
            $model->attributes = $_POST['Categories'];

            if($model->save()) {
                $this->redirect(array('view','id'=>$model->id));
            }
        }
        $this->render('update',array(
            'model' => $model
        ));
    }

    public function actionDelete($id)
    {
        if(Categories::model()->findByPk($id)){            // we only allow deletion via POST request
            $this->loadModel($id)->delete();
            
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again. Categories');
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Categories', array(
            'pagination' => array(
                'pageSize' => Yii::app()->params['postsPerPage'],
            ),
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

     /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Categories('search');
        if (isset($_GET['Categories'])) {
            $model->attributes = $_GET['Categories'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    /**
     * Action search.
     */

    public function actionSearch()
    {
        $model = new Categories('search');
        $model->unsetAttributes();
        if (isset($_GET['search_key'])) {
            $model->title = $_GET['search_key'];
        }
        $this->render('search', array(
            'model' => $model,
        ));
    }


    public function loadModel()
    {
        if($this->_model === null) {
            if(isset($_GET['id']))
            {
                $this->_model= Categories::model()->findbyPk($_GET['id']);

            }
            if($this->_model === null) 
            {
				throw new CHttpException(404,'The requested page does not exist.');
                
            } 
        }
        return $this->_model;
    }

}


?>