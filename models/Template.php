<?php

include_once (__DIR__ . '/../db/Model.php');


/**
 * Class Template
 *
 * @property string $id
 * @property integer $category_id
 * @property string $template
 */
class Template extends Model
{
    public $id;
    public $category_id;
    public $template;

    /**
     * @return string
     */
    public function tableName(){
        return "template";
    }

    /**
     * @param integer $id
     *
     * @return self|array|bool
     */
    public function getById($id){
        return $this->db
            ->from($this->getTableName())
            ->where(["id" => $id])
            ->limit(1)
            ->getOne();
    }

    /**
     * @param integer $id
     *
     * @return self|array|bool
     */
    public function getByCategory($id){
        return $this->db
            ->from($this->getTableName())
            ->where(["category_id" => $id])
            ->limit(1)
            ->getOne();
    }
}