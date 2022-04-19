<?php
class Product extends Model{
    protected $table_name = "Product";
    protected $table_columns = [
        "p_name" => [
            "name" => "p_name",
            "type" => "varchar",
            "null" => false,
        ],
        "id" => [
            "name" => "id",
            "type" => "int",
            "null" => false,
            "primary_key" => true
        ],
        "price" => [
            "name" => "price",
            "type" => "int",
            "null" => false,
        ]
    ];
}
?>