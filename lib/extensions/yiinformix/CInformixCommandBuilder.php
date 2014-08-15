<?php

/**
 * CInformixCommandBuilder class file.
 *
 * @author Edgard L. Messias <edgardmessias@gmail.com>
 * @link https://github.com/edgardmessias/yiinformix
 */

/**
 * CInformixCommandBuilder provides basic methods to create query commands for tables for Informix Servers.
 *
 * @author Edgard L. Messias <edgardmessias@gmail.com>
 * @package ext.yiinformix
 */
class CInformixCommandBuilder extends CDbCommandBuilder {

    /**
     * 
     * @param string $sql SQL query string.
     * @param integer $limit maximum number of rows, 0 to ignore limit.
     * @param integer $offset row offset, 0 to ignore offset.
     * @return string SQL with limit and offset.
     */
    public function applyLimit($sql, $limit, $offset) {
        $limit = $limit !== null ? (int) $limit : 0;
        $offset = $offset !== null ? (int) $offset : 0;

        if ($offset > 0) { //just limit
            $sql = preg_replace('/^([\s(])*SELECT(\s+SKIP\s+\d+)?(\s+DISTINCT)?/i', "\\1SELECT SKIP $offset\\3", $sql);
        }
        if ($limit > 0) { //just offset
            $sql = preg_replace('/^([\s(])*SELECT(\s+SKIP\s+\d+)?(\s+LIMIT\s+\d+)?(\s+DISTINCT)?/i', "\\1SELECT\\2 LIMIT $limit\\4", $sql);
        }
        return $sql;
    }

    /**
     * Creates an UPDATE command.
     * @param CDbTableSchema $table the table schema ({@link CDbTableSchema}) or the table name (string).
     * @param array $data list of columns to be updated (name=>value)
     * @param CDbCriteria $criteria the query criteria
     * @return CDbCommand update command.
     */
    public function createUpdateCommand($table, $data, $criteria) {
        foreach ($data as $name => $value) {
            if (($column = $table->getColumn($name)) !== null) {
                if ($column->autoIncrement) {
                    unset($data[$name]);
                    continue;
                }
            }
        }
        return parent::createUpdateCommand($table, $data, $criteria);
    }

    /**
     * Creates a multiple INSERT command.
     * This method could be used to achieve better performance during insertion of the large
     * amount of data into the database tables.
     * @param mixed $table the table schema ({@link CDbTableSchema}) or the table name (string).
     * @param array[] $data list data to be inserted, each value should be an array in format (column name=>column value).
     * If a key is not a valid column name, the corresponding value will be ignored.
     * @return CDbCommand multiple insert command
     * @since 1.1.14
     */
    public function createMultipleInsertCommand($table, array $data) {
        $templates = array(
            'main' => '{{rowInsertValues}}',
            'columnInsertValue' => '{{value}}',
            'columnInsertValueGlue' => ', ',
            'rowInsertValue' => 'INSERT INTO {{tableName}} ({{columnInsertNames}}) VALUES ({{columnInsertValues}})',
            'rowInsertValueGlue' => '; ',
            'columnInsertNameGlue' => ', ',
        );
        return $this->composeMultipleInsertCommand($table, $data, $templates);
    }

    /**
     * Generates the expression for selecting rows with specified composite key values.
     * @param CDbTableSchema $table the table schema
     * @param array $values list of primary key values to be selected within
     * @param string $prefix column prefix (ended with dot)
     * @return string the expression for selection
     */
    protected function createCompositeInCondition($table, $values, $prefix) {
        $vs = array();
        foreach ($values as $value) {
            $c = array();
            foreach ($value as $k => $v)
                $c[] = $prefix . $table->columns[$k]->rawName . '=' . $v;
            $vs[] = '(' . implode(' AND ', $c) . ')';
        }
        return '(' . implode(' OR ', $vs) . ')';
    }

    /**
     * Creates a COUNT(*) command for a single table.
     * @param mixed $table the table schema ({@link CDbTableSchema}) or the table name (string).
     * @param CDbCriteria $criteria the query criteria
     * @param string $alias the alias name of the primary table. Defaults to 't'.
     * @return CDbCommand query command.
     */
    public function createCountCommand($table,$criteria,$alias='t')
    {
        $this->ensureTable($table);
        if($criteria->alias!='')
            $alias=$criteria->alias;
        $alias=$this->_schema->quoteTableName($alias);

        if(!empty($criteria->group) || !empty($criteria->having))
        {
            $select=is_array($criteria->select) ? implode(', ',$criteria->select) : $criteria->select;
            if($criteria->alias!='')
                $alias=$criteria->alias;
            $sql=($criteria->distinct ? 'SELECT DISTINCT':'SELECT')." {$select} FROM {$table->rawName} $alias";
            $sql=$this->applyJoin($sql,$criteria->join);
            $sql=$this->applyCondition($sql,$criteria->condition);
            $sql=$this->applyHaving($sql,$criteria->having);
            $sql="SELECT COUNT(*) FROM ($sql) sq";
            $sql=$this->applyGroup($sql,$criteria->group);
        }
        else
        {
            if(is_string($criteria->select) && stripos($criteria->select,'count')===0)
                $sql="SELECT ".$criteria->select;
            elseif($criteria->distinct)
            {
                if(is_array($table->primaryKey))
                {
                    $pk=array();
                    foreach($table->primaryKey as $key)
                        $pk[]=$alias.'.'.$key;
                    $pk=implode(', ',$pk);
                }
                else
                    $pk=$alias.'.'.$table->primaryKey;
                $sql="SELECT COUNT(DISTINCT $pk)";
            }
            else
                $sql="SELECT COUNT(*)";
            $sql.=" FROM {$table->rawName} $alias";
            $sql=$this->applyJoin($sql,$criteria->join);
            $sql=$this->applyCondition($sql,$criteria->condition);
        }

        // Suppress binding of parameters belonging to the ORDER clause. Issue #1407.
        if($criteria->order && $criteria->params)
        {
            $params1=array();
            preg_match_all('/(:\w+)/',$sql,$params1);
            $params2=array();
            preg_match_all('/(:\w+)/',$this->applyOrder($sql,$criteria->order),$params2);
            foreach(array_diff($params2[0],$params1[0]) as $param)
                unset($criteria->params[$param]);
        }

        // Do the same for SELECT part.
        if($criteria->select && $criteria->params)
        {
            $params1=array();
            preg_match_all('/(:\w+)/',$sql,$params1);
            $params2=array();
            preg_match_all('/(:\w+)/',$sql.' '.(is_array($criteria->select) ? implode(', ',$criteria->select) : $criteria->select),$params2);
            foreach(array_diff($params2[0],$params1[0]) as $param)
                unset($criteria->params[$param]);
        }

        $command=$this->_connection->createCommand($sql);
        $this->bindValues($command,$criteria->params);
        return $command;
    }

}
