<?php

class PostController extends Controller
{
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

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $post = $this->loadModel();
        $comment = $this->newComment($post);

        $this->render('view', array(
            'model' => $post,
            'comment' => $comment,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Post;
        

        if (isset($_POST['Post'])) {

            $model->categories_id = $_POST['Categories']['id'];


            $model->attributes = $_POST['Post'];

            // trigger eventcreate
            $model->onNewPost = array($this, 'sendEmail');

            $rnd = rand(0, 9999); // generate random number between 0 - 9999

            $uploadedFile = CUploadedFile::getInstance($model, 'image');
            $fileName = "{$rnd}-{$uploadedFile}";
            $model->image = $fileName;




            if ($model->save()) {
                $uploadedFile->saveAs(Yii::app()->basePath . '/../img/' . $fileName);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
      
        if (isset($_POST['Post'])) {
            $_POST['Post']['image'] = $model->image;
            $model->attributes = $_POST['Post'];
            $uploadFile = CUploadedFile::getInstance($model, 'image');
            if ($model->save()) {
                if (!empty($uploadFile)) {
                    $uploadFile->saveAs(Yii::app()->basePath . '/../img/' . $model->image);
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
   
    public function actionDelete($id)
    {
        if(Post::model()->findByPk($id)){            // we only allow deletion via POST request
            $this->loadModel($id)->delete();
            
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }


    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'status=' . Post::STATUS_PUBLISHED,
            'order' => 'update_time DESC',
            'with' => 'commentCount',
        ));
        if (isset($_GET['tag'])) {
            $criteria->addSearchCondition('tags', $_GET['tag']);
        }

        $dataProvider = new CActiveDataProvider('Post', array(
            'pagination' => array(
                'pageSize' => Yii::app()->params['postsPerPage'],
            ),
            'criteria' => $criteria,
        ));

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionFollow()
    {
        $id = $_GET['id'];
        echo $id;
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Post('search');
        if (isset($_GET['Post'])) {
            $model->attributes = $_GET['Post'];
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
        $model = new Post('search');
        $model->unsetAttributes();
        if (isset($_GET['search_key'])) {
            $model->title = $_GET['search_key'];
        }
        $this->render('search', array(
            'model' => $model,
        ));
    }

    /**
     * Suggests tags based on the current user input.
     * This is called via AJAX when the user is entering the tags input.
     */
    public function actionSuggestTags()
    {
        if (isset($_GET['q']) && ($keyword = trim($_GET['q'])) !== '') {
            $tags = Tag::model()->suggestTags($keyword);
            if ($tags !== array()) {
                echo implode("\n", $tags);
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null) {
            if (isset($_GET['id'])) {
                if (Yii::app()->user->isGuest) {
                    $condition = 'status=' . Post::STATUS_PUBLISHED . ' OR status=' . Post::STATUS_ARCHIVED;
                } else {
                    $condition = '';
                }
                $this->_model = Post::model()->findByPk($_GET['id'], $condition);
            }
            if ($this->_model === null) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }

        return $this->_model;
    }

    /**
     * Creates a new comment.
     * This method attempts to create a new comment based on the user input.
     * If the comment is successfully created, the browser will be redirected
     * to show the created comment.
     * @param Post the post that the new comment belongs to
     * @return Comment the comment instance
     */
    protected function newComment($post)
    {
        $comment = new Comment;


        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($comment);
            Yii::app()->end();
        }
        if (isset($_POST['Comment'])) {
            $comment->attributes = $_POST['Comment'];
            if ($post->addComment($comment)) {
                $transport = (new Swift_SmtpTransport('smtp.gmail.com',465,'ssl'))
                ->setUsername('rinchan98.py@gmail.com')
                ->setPassword('xlpmiuyymkrgihpu');

                // Create the Mail using
                $mailer = new Swift_Mailer($transport);
                //create Mess
                $message = (new Swift_Message("People Comment"))
                    ->setFrom(['rinchan98.py@gmail.com' => "Rin Nguyen"])
                    ->setTo(["{$comment->email}","{$comment->email}" => "{$comment->author}"])
                    ->setBody("{$comment->content}");
                    
                $result = $mailer->send($message);

                if ($comment->status == Comment::STATUS_PENDING) {
                    Yii::app()->user->setFlash('commentSubmitted', 'Thank you for your comment. Your comment will be posted once it is approved.');
                }
                $this->refresh();
            }
        }

        return $comment;
    }

    /**
     * Event trigger
     * @param $event
     */
    public function sendEmail($event)
    {
        $post = $event->sender;
        var_dump($post->title, $post->content);
    }
}
