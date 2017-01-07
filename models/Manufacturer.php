<?php

include_once (__DIR__ . '/../db/Model.php');


class Manufacturer extends Model
{
    /**
     * @return string
     */
    public function tableName(){
        return "manufacturer";
    }

    /**
     * @param integer $id
     *
     * @return array|bool
     */
    public function getById($id){
        $item = $this->db
            ->from($this->getTableName())
            ->where(["manufacturer_id" => $id])
            ->limit(1)
            ->getOne();
        return $item;
    }
}