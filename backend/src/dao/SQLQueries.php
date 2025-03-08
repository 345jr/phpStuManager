<?php

class SQLQueries {
    private static $queries = [];

    /**
     * 从 JSON 文件中加载 SQL 查询到查询数组中。
     * 这个方法应该在初始化查询数组时调用一次。
     * 
     * @param string $tableName 表的名称（例如，'courses'，'students'）。
     * @param string $filePath 包含 SQL 查询的 JSON 文件的路径。
     */
    public static function loadQueries($tableName, $filePath) {
        if (!isset(self::$queries[$tableName])) {
            $json = file_get_contents($filePath);
            self::$queries[$tableName] = json_decode($json, true);
        }
    }

    /**
     * 根据表名和查询名获取特定的 SQL 查询。
     * 
     * @param string $tableName 表的名称（例如，'courses'，'students'）。
     * @param string $queryName 查询的名称（例如，'getCourseById'，'insertStudent'）。
     * @return string SQL 查询字符串。
     * @throws InvalidArgumentException 如果查询未找到。
     */
    public static function getQuery($tableName, $queryName) {
        if (isset(self::$queries[$tableName][$queryName])) {
            return self::$queries[$tableName][$queryName];
        } else {
            throw new InvalidArgumentException("未找到查询: $tableName -> $queryName");
        }
    }
}
?>