<?php

interface IDAO {

    public function insert($data);

    public function findById($id);

    public function exists($id);
}

