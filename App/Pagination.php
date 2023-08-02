<?php

namespace App;

class Pagination
{
    /** Recebe os dados do banco de dados @var array */
    public array $data;
    public $currentPage;
    public $quantity;
    public $recordsPage;
    public $count;
    public $result;

    public function __construct($data, $currentPage, $quantity)
    {
        $this->data = $data;
        $this->currentPage = $currentPage;
        $this->quantity = $quantity;
    }

    public function result()
    {
        //Recebe os dados e divide pela quantidade de registros por página
        $this->recordsPage = array_chunk($this->data, $this->quantity);
        //Contar o total de registros
        $this->count = count($this->recordsPage);

        if ($this->count > 0) :
            $this->result = $this->recordsPage[$this->currentPage - 1];
            return $this->result;
        else :
            return [];
        endif;
    }

    public function navigator()
    {
        echo "<ul id='ul-horizontal'>";
        for ($i = 1; $i <= $this->count; $i++) :
            if ($i == $this->currentPage) :
                echo "<li id='active'><a href='#'>" . $i . "</a></li>";
            else :
                echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
            endif;
        endfor;
        echo "</ul>";
    }
}
