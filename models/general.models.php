<?php require_once 'connection.php';

class ModelsGeneral{

//show records
    static public function mdlRecord( $type, $table, $other )
    {
        $stmt = connection::connect()->prepare(' SELECT * FROM '.$table.' '.$other );
        $stmt -> execute();

        switch ($type) {

            case 'all':
                return $stmt -> fetchAll();
                break;

            case 'single':
                return $stmt -> fetch();
                break;

        }

        $stmt -> close();
        $stmt = null;
    }

//update a field unique 
    static public function mdlUpdateFieldUnique( $table, $set, $data )
    {


        $stmt = connection::connect()->prepare(' update '.$table.' set '.$set.' = :set where id = :id ' );

        foreach ( $data as $key => $value ){

            if( is_numeric($value) ){ $param = PDO::PARAM_INT; } else { $param = PDO::PARAM_STR; }
            $stmt->bindValue(':'.$key, $value, $param );

        }

        if ( $stmt->execute() ){
            return 'ok';
        }else{
            switch ( $stmt->errorInfo()[0] ){
                case 23000: return 'repeated'; break;
                default: return 'error'; break;
            }
        }

        $stmt = null;



    }

//update row 
    static public function mdlUpdateRow( $table, $data )
    {
        $tbl = connection::connect()->query(' show columns from '.$table );
        $columns = $tbl->fetchAll();

        $set = [];
        foreach ( $columns as $row ){

            if( $row['Field'] != 'id' && $row['Field'] != 'created' && $row['Field'] != 'modified' &&
                $row['Field'] != 'photo' && $row['Field'] != 'last_login' && $row['Field'] != 'status' ){
                $set[] = $row['Field']. '=' .':'.$row['Field'];
            }

        }

        $set = implode(',', $set);

        $stmt = connection::connect()->prepare(' update '.$table.' set '.$set.' where id = :id ');

        foreach ( $data as $key => $value ){
            if( $key == 'tax' ){ $param = PDO::PARAM_STR; $value = strval($value); }elseif( is_numeric($value) ){ $param = PDO::PARAM_INT; } else { $param = PDO::PARAM_STR; }
            $stmt->bindValue(':'.$key, $value, $param );
        }

        if( $stmt->execute() ){
            return 'ok';
        }else{
            return 'error';
        }

        $stmt -> close();
        $stmt = null;

    }

//insert row 
    static public function mdlInsertRow( $table, $data )
    {
        $tbl = connection::connect()->query(' show columns from '.$table );
        $columns = $tbl->fetchAll();

        $fiel = [];
        $valu = [];
        foreach ( $columns as $row ){

            if( $row['Field'] != 'id' && $row['Field'] != 'created' && $row['Field'] != 'modified' &&
                $row['Field'] != 'photo' && $row['Field'] != 'last_login' && $row['Field'] != 'status' ){
                $fiel[] = $row['Field'];
                $valu[] = ':'.$row['Field'];
            }

        }

        $fields = implode(',', $fiel);
        $values = implode(',', $valu);

        $stmt = connection::connect()->prepare(' INSERT INTO '.$table.' ( '.$fields.' ) VALUES ( '.$values.' ) ');

        foreach ( $data as $key => $value ){

            if( is_numeric($value) ){ if( $key=='tax' || $key=='dto' ) { $param = PDO::PARAM_STR; }else{ $param = PDO::PARAM_INT; }  } else { $param = PDO::PARAM_STR; }
            $stmt->bindValue(':'.$key, $value, $param );

        }

        if ( $stmt->execute() ){
            return 'ok';
        }else{
            switch ( $stmt->errorInfo()[0] ){
                case 23000: return 'repeated'; break;
                default: return 'error'; break;
            }
        }

        $stmt = null;

    }

//delete the record 
    static public function mdlDeleteRecord( $table, $filter, $value, $other )
    {
        $stmt = connection::connect()->prepare(' DELETE FROM '.$table.' WHERE '.$filter.' = :'.$filter.' '.$other);
        $stmt -> bindParam(':'.$filter, $value, PDO::PARAM_INT);
        $stmt -> execute();

        if( $stmt->rowCount() > 0 ){
            return 'ok';
        }else{
            return 'error';
        }

        $stmt -> close();
        $stmt = null;
    }

//execute query
    static public function mdlExecuteQuery( $query )
    {
        $data = connection::connect()->query( $query );
        return $data->fetchAll();
    }
    static public function mdlExecuteQuerySingle( $query )
    {
        $data = connection::connect()->query( $query );
        return $data->fetch();
    }

//data table dynamic
    static public function mdlDataTableDynamic( $query )
    {

        $header = connection::connect()->query( $query );
        $execution = connection::connect()->query( $query );
        $data = $execution->fetchAll();

        if( empty( $data ) ){

            $info = [
                "header" => [''],
                "data" => $data,
            ];

        }else{

            $info = [
                "header" => array_keys($header->fetch(PDO::FETCH_ASSOC)),
                "data" => $data,
            ];

        }

        return $info;

    }








}