<?php


namespace App\Helpers;


class QueryParser
{

    public $query = [
        "select" => [],
        "select_raw" => [],
        "from" => [],
        "where" => [],
        "group_by" => [],
        "where_raw" => null,
        "limit" => null,
        "offset" => null,
        "order_by_raw" => null
    ];

    public function toSql()
    {
        $select = "SELECT " . implode(", ", array_merge($this->query['select'], $this->query['select_raw']));
        $from = "FROM " . $this->query['from'];
        $where = $this->query['where_raw'] !== null && $this->query['where_raw'] !== "" ? "WHERE " . $this->query['where_raw'] : "";
        $group_by = !empty($this->query['group_by']) ? "GROUP BY " . implode(",", $this->query['group_by']) : "";
        $order_by = $this->query['order_by_raw'] !== null  ? "ORDER BY " . $this->query['order_by_raw'] : "";
        $limit = $this->query['limit'] !== null ? "LIMIT " . $this->query['limit'] : "";
        $offset = $this->query['offset'] !== null ? "OFFSET " . $this->query['offset'] : "";
        return "$select $from $where $group_by $order_by $limit $offset";
    }

}
