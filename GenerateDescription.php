<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);

include_once (__DIR__ . '/models/Template.php');
include_once (__DIR__ . '/models/Product.php');
include_once (__DIR__ . '/models/ProductDescription.php');
include_once (__DIR__ . '/models/Manufacturer.php');
include_once (__DIR__ . '/models/CategoryDescription.php');
include_once (__DIR__ . '/models/ProductAttribute.php');

class GenerateDescription
{

    public $item;
    public $template;

    protected $templateModel;
    protected $itemModel;

    /**
     * GenerateDescription constructor.
     *
     * @param integer $itemId - product id
     * @param integer $templateId - template id
     */
    public function __construct($itemId, $templateId = 0) {
        $this->setItem($itemId);
        $this->setTemplate($templateId);
    }

    public function newDescription(){
        if(!$this->item || !$this->template){
            return null;
        }
        $template = $this->template->template;
        $template = preg_replace_callback('#\[\[([^\[\]]*)\]\]#Ssi', function ($matches){
            if(isset($matches[1])){
                $arr = explode('|', $matches[1]);
                $arr = "'" . $this->arrayRand($arr) . "'";
                return $arr;
            }
            return '';
        }, $template);
        $template = $this->getCurrentTemplate($template);
        $tpl = [];
        $tpl['product'] = $this->item;
        $productDescription = new ProductDescription();
        $tpl['description'] = $productDescription->getById($this->item->product_id);
        $manufacturer = new Manufacturer();
        $tpl['manufacturer'] = $manufacturer->getById($this->item->manufacturer_id);
        $categoryDescription = new CategoryDescription();
        $tpl['category'] = $categoryDescription->getById($this->item->main_category);
        return $this->parseTemplate($template, $tpl);
    }

    /**
     * @param string $template
     * @param array $array
     *
     * @return string
     */
    public function parseTemplate ( $template , $array = [])
    {
        $template = preg_replace_callback ( '#\$attribute\-\>\'([^\']*?)\'#Ssi' , function ($matches) use ($array){
            if(isset($matches[1])){
                $name = trim($matches[1], '\'');
                $name = trim($name, '"');
                $attribute = new ProductAttribute();
                if(mb_substr_count($name, '->', 'UTF-8') > 0) {
                    $attribute = $attribute->getByIdAndGroup($name, $array['product']->product_id);
                    return isset($attribute->text) ? "'" . $attribute->text . "'" : "''";
                }
                $attribute = $attribute->getById($name, $array['product']->product_id);
                return isset($attribute->text) ? "'" . $attribute->text . "'" : "''";
            }
            return "''";

        } , $template );
        $product = $array['product'];
        $description = $array['description'];
        $manufacturer = $array['manufacturer'];
        $category = $array['category'];
        $template = '?> ' . str_replace(['{{', '}}'], ['<?=', '; ?>'], $template) . '';
//        var_dump(htmlspecialchars($template));
        return str_ireplace('NULL', '', eval($template));
    }

    public function arrayRand($array = []){
        $key = array_rand($array);
        return $array[$key];
    }

    /**
     * @param string $template
     *
     * @return string
     */
    protected function getCurrentTemplate($template){
        if(!$template){
            return '';
        }
        $template = explode('|', $template);
        if(sizeof($template) < 2){
            return $template[0] ? $template[0] : '';
        }
        $rand = array_rand($template);
        return $template[$rand];
    }

    /**
     * @param integer $templateId - template id
     */
    public function setTemplate($templateId){
        $this->templateModel = new Template();
        if($templateId < 1){
            if(!$this->item){
                $this->template = null;
            }else{
                $this->template = $this->templateModel->getByCategory($this->item->main_category);
            }
        }else{
            $this->template = $this->templateModel->getById($templateId);
        }
    }

    /**
     * @param integer $itemId - product id
     */
    public function setItem($itemId){
        $this->itemModel = new Product();
        $this->item = $this->itemModel->getById($itemId);
        $this->item->price = number_format($this->item->price, 0, ',', ' ');
        $this->item->weight = number_format($this->item->weight, 2, ',', ' ');
        $this->item->length = number_format($this->item->length, 2, ',', ' ');
        $this->item->width = number_format($this->item->width, 2, ',', ' ');
        $this->item->height = number_format($this->item->height, 2, ',', ' ');
    }
}