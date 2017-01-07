<?php

include_once (__DIR__ . '/../db/Model.php');


class CategoryDescription extends Model
{
    /**
     * @return string
     */
    public function tableName(){
        return "category_description";
    }

    /**
     * @param integer $id
     *
     * @return array|bool
     */
    public function getById($id){
        $item = $this->db
            ->from($this->getTableName())
            ->where(["category_id" => $id])
            ->limit(1)
            ->getOne();
        return $item;
    }
}