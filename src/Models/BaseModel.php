<?php

namespace App\Models;

abstract class BaseModel
{
	protected $table;
	protected $column;
	protected $db;
    protected $qb;

	public function __construct($db)
	{
		$this->db = $db;
        $this->qb = $this->db->createQueryBuilder();
	}

	public function getAll()
	{
        $this->qb->select($this->column)
           ->from($this->table);

        $result = $this->qb->execute();
        return $result->fetchAll();
	}

	public function create(array $data)
    {
        $column = [];
        $paramData = [];
        foreach ($data as $key => $value) {
            $column[$key] = ':'.$key;
            $paramData[$key] = $value;
        }
        $this->qb->insert($this->table)
           ->values($column)
           ->setParameters($paramData)
           // echo $this->qb->getSQL();
           ->execute();
    }

    //conditional edit
    public function update(array $data, $column, $value)
    {
        $columns = [];
        $paramData = [];

        $this->qb->update($this->table);
        foreach ($data as $key => $values) {
            $columns[$key] = ':'.$key;
            $paramData[$key] = $values;

            $this->qb->set($key, $columns[$key]);
        }
        try {
            $this->qb->where( $column.'='. $value)
                        ->setParameters($paramData)
                        ->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }




    }

    //conditional find
    public function find($column, $value)
    {
        $param = ':'.$column;

        $this->qb->select($this->column)
           ->from($this->table)
           ->where($column . ' = '. $param)
           ->setParameter($param, $value);
           // echo $this->qb->getSQL();
           // die();
        $result = $this->qb->execute();

        return $result->fetch();
    }

    //conditional find without delete column
    public function findWithoutDelete($column, $value)
    {
        $param = ':'.$column;

        $this->qb->select($this->column)
           ->from($this->table)
           ->where($column . ' = '. $param)
           ->setParameter($param, $value);
           // echo $this->qb->getSQL();
           // die();
        $result = $this->qb->execute();

        return $result->fetch();
    }

    //conditional find where deleted = 0
    public function findNotDelete($column, $value)
    {
        $param = ':'.$column;

        $this->qb->select($this->column)
           ->from($this->table)
           ->where($column . ' = '. $param)
           ->andWhere('deleted = 0')
           ->setParameter($param, $value);
           // echo $this->qb->getSQL();
           // die();
        $result = $this->qb->execute();

        return $result->fetch();
    }

    //conditional find where deleted = 1
    public function findDeleted($column, $value)
    {
        $param = ':'.$column;

        $this->qb->select($this->column)
           ->from($this->table)
           ->where($column . ' = '. $param)
           ->andWhere('deleted = 1')
           ->setParameter($param, $value);
           // echo $this->qb->getSQL();
           // die();
        $result = $this->qb->execute();

        return $result->fetch();
    }

    public function softDelete($id)
    {
    	$param = ':id';

    	$this->qb->update($this->table)
    	   ->set('deleted', 1)
    	   ->where('id = '. $param)
    	   ->setParameter($param, $id)
    	   ->execute();
    }

    public function restoreSoftDelete($id)
    {
        $param = ':id';

        $qb = $this->db->createQueryBuilder();
        $this->qb->update($this->table)
           ->set('deleted', 0)
           ->where('id = '. $param)
           ->setParameter($param, $id)
           ->execute();
    }

    public function hardDelete($id)
    {
        $param = ':id';

        $this->qb->delete($this->table)
           ->where('id = '. $param)
           ->setParameter($param, $id)
           ->execute();
    }

    public function deleteByColumn($column, $id)
    {
        $param = ':id';

        $this->qb->delete($this->table)
           ->where($column .' = '. $param)
           ->setParameter($param, $id)
           ->execute();
    }

    public function joinOneId($table_join, $foreign_key_column, $id)
    {
        $param = ':id';

        $this->qb->select('*')
            ->from($this->table)
            ->join($this->table, $table_join, $this->table.'.id = '.$table_join.'.'.$foreign_key_column)
            ->where($this->table .'.id ='. $param)
            ->setParameter($param, $id);

        $result = $this->qb->execute();

        return $result->fetchAll();
    }
}
