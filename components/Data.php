<?php

namespace app\components;

use Yii;
use yii\base\Component;

class Data extends Component
{
    public $data;

    public function all($title, $subtitle)
    {
        if (isset($this->data[$title][$subtitle]) && $this->data[$title][$subtitle]) {
            return $this->data[$title][$subtitle];
        }
        return [];
    }

    public function row($title, $subtitle)
    {
        $all = $this->all($title, $subtitle);
        if ($all) {
            return reset($all);
        }
        return [];
    }

    public function column($title, $subtitle, $attribute)
    {
        $all = $this->all($title, $subtitle);
        $column = [];
        foreach ($all as $row) {
            $column[] = $row[$attribute];
        }
        return $column;
    }

    public function cell($title, $subtitle, $attribute)
    {
        $row = $this->row($title, $subtitle);
        if ($row) {
            return $row[$attribute];
        }
        return null;
    }

    public function count($title, $subtitle = null)
    {
        if (isset($this->data[$title]) && $this->data[$title]) {
            if ($subtitle === null) {
                return count($this->data[$title]);
            }
            if (isset($this->data[$title][$subtitle]) && $this->data[$title][$subtitle]) {
                return count($this->data[$title][$subtitle]);
            }
        }
        return 0;
    }
}
