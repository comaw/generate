<?php

include_once (__DIR__ . '/../db/Model.php');

class ProductDescription extends Model
{
    /**
     * @return string
     */
    public function tableName(){
        return "product_description";
    }

    /**
     * @param integer $id
     *
     * @return array|bool
     */
    public function getById($id){
        $item = $this->db
            ->from($this->getTableName())
            ->where(["product_id" => $id])
            ->limit(1)
            ->getOne();
        return $item;
    }
}