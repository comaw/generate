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
        $name = trim($name);
        $item = $this->db
            ->from($this->getTableName() . ' AS `pa`')
            ->join($this->getTableName('attribute_description') . ' AS `ad`', '`ad`.`attribute_id` = `pa`.`attribute_id`', 'INNER')
            ->where(["`ad`.`name`" => $name, '`pa`.`product_id`' => $itemId, '`ad`.`language_id`' => 1])
            ->limit(1)
            ->getOne();
        return $item;
    }

    /**
     * @param string $name
     * @param integer $itemId
     *
     * @return array|bool
     */
    public function getByIdAndGroup($name, $itemId){
        $name = trim($name);
        $name = explode('->', $name);
        if(sizeof($name) != 2){
            return '';
        }
        $group = $name[0];
        $name = $name[1];
        $item = $this->db
            ->from($this->getTableName() . ' AS `pa`')
            ->join($this->getTableName('attribute_description') . ' AS `ad`', '`ad`.`attribute_id` = `pa`.`attribute_id`', 'INNER')
            ->join($this->getTableName('attribute') . ' AS `a`', '`a`.`attribute_id` = `ad`.`attribute_id`', 'INNER')
            ->join($this->getTableName('attribute_group_description') . ' AS `agd`', '`agd`.`attribute_group_id` = `a`.`attribute_group_id`', 'INNER')
            ->where([
                "`ad`.`name`" => $name,
                '`pa`.`product_id`' => $itemId,
                '`ad`.`language_id`' => 1,
                '`agd`.`language_id`' => 1,
                "`agd`.`name`" => $group,
            ])
            ->limit(1)
            ->getOne();
        return $item;
    }
}