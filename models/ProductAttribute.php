<?php

include_once (__DIR__ . '/../db/Model.php');


class ProductAttribute extends Model
{
    /**
     * @return string
     */
    public function tableName(){
        return "product_attribute";
    }

    /**
     * @param string $name
     * @param integer $itemId
     *
     * @return array|bool
     */
    public function getById($name, $itemId){
        $item = $this->db
            ->from($this->getTableName() . ' AS `pa`')
            ->join($this->getTableName('attribute_description') . ' AS `ad`', '`ad`.`attribute_id` = `pa`.`attribute_id`', 'INNER')
            ->where(["`ad`.`name`" => $name, '`pa`.`product_id`' => $itemId, 'language_id' => 1])
            ->limit(1)
            ->getOne();
        return $item;
    }
}