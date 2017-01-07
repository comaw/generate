<?php

include_once (__DIR__ . '/../db/Model.php');

class Product extends Model
{

    /**
     * @return string
     */
    public function tableName(){
        return "product";
    }

    /**
     * @param integer $id
     *
     * @return array|bool
     */
    public function getById($id){
        $item = $this->db
            ->select('`ptc`.*, `p`.*')
            ->from($this->getTableName() . ' AS `p`')
            ->join($this->getTableName('product_to_category') . ' AS `ptc`', "`ptc`.`product_id` = `p`.`product_id`")
            ->where(["`p`.`product_id`" => $id])
            ->limit(1)
            ->getOne();
        return $item;
    }
}