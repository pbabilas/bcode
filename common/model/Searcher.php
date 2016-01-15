<?php
/**
 * @user: Pawel Babilas
 * @date: 06.01.2016
 */

namespace app\common\model;


use yii\data\Pagination;
use yii\db\ActiveRecord;

class Searcher
{

	/** @var ActiveRecord  */
	private $model;

	/** @var int  */
	private $limit = 10;

	/** @var \yii\db\ActiveQuery  */
	private $query;

	/** @var \yii\db\ActiveQuery  */
	private $countQuery;

	/**
	 * @param ActiveRecord $model
	 */
	public function __construct(ActiveRecord $model)
	{
		$this->model = $model;
		$this->query = $this->model->find();
		$this->countQuery = clone $this->query;
	}

	/**
	 * @param array $params
	 */
	public function setParams($params = [])
	{
		foreach ($params as $col => $value)
		{
			$this->query->andWhere(['like', $col, [$value]]);
			$this->countQuery->orWhere([$col => $value]);
		}
	}

	/**
	 * @param int $page
	 */
	public function setPage($page)
	{
		$offset = ( $page - 1 ) * $this->limit;
		$this->query->offset($offset);
	}

	/**
	 * @return array|\yii\db\ActiveRecord[]
	 */
	public function findAll()
	{
		$this->query->limit($this->limit);
		return $this->query->all();
	}

	/**
	 * @return static|null ActiveRecord instance matching the condition, or `null` if nothing matches.
	 */
	public function findOne()
	{
		return $this->query->one();
	}

	/**
	 * @return Pagination
	 */
	public function getPaginator()
	{
		$paginator =  new Pagination(['totalCount' => $this->countQuery->count()]);
		$paginator->pageParam = 'page';
		$paginator->pageSizeParam = false;
		$paginator->setPageSize($this->limit);
		return $paginator;
	}

}