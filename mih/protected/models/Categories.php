<?php


/**
 * The followings are the available columns in table 'tbl_categories':
 * @property integer $id
 * @property string $title
 */

class Categories extends CActiveRecord {

    public $author_search;

    public static function model($className =__CLASS__)
    {
        return parent::model($className);
    }


	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{categories}}';
    }
    
    public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
            array('title', 'length', 'max'=>128),
            array( 'xxx,yyy,author_search', 'safe', 'on'=>'search' ),
            
		);
    }
    
    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'posts' => array(self::HAS_MANY,'Post','','on'=>'id=categories_id','joinType'=>'INNER JOIN', 'alias'=>'Post')
		);
	}

    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
		);
	}
    /**
     * @return string the URL that shows the detail of the post
     */
    public function getUrl()
    {
        return Yii::app()->createUrl('categories/view', array(
          'id' => $this->id,
          'title' => $this->title,
        ));
    }
     /**
     * Retrieves the list of posts based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the needed posts.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        

        $criteria->compare('title', $this->title, true);


        return new CActiveDataProvider( 'Categories', array(
            'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'author_search'=>array(
                        'asc'=>'author.username',
                        'desc'=>'author.username DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }


}

?>