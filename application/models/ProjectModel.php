<?php

 
class ProjectModel extends CI_Model {

    // var $_db = null;


    public function __construct() {
        parent::__construct();
       
    }

    public function setDBinuse($dbname = 'default'){
         // $this->_db = $this->load->database(,TRUE);
        $this->db->setDatabase( $dbname );
    }
    
    public function do_CI_Query($args){
        $this->db->select($args['select']);    //Select Fields

        $this->db->from($args['from']); //Select table

        // Check if there is conditional select where args
        if (  isset($args['where'])){
            foreach ($args['where'] as $where => $val){
                if( !isset($val['value']) ){
                    $this->db->where( $val['field'] );
                }else{
                    if( isset( $val['type'] ) ){
                        if( $val['type'] == 'wherein' ) $this->db->where_in( $val['field'], $val['value'] ); 
                        else if( $val['type'] == 'or' ) $this->db->or_where( $val['field'] );
                    }else{  
                        $this->db->where($val['field'],$val['value']);
                    }
                }
            }
        }
        // Check if there is join args present
        if ( isset($args['join'])){
            // Loop for evey join args
            foreach ($args['join'] as $val){
                if(   array_key_exists('join_type',$val) ){
                    $this->db->join($val['table'],$val['cond'], $val['join_type']);
                }else{
                    $this->db->join($val['table'],$val['cond']);
                }
                
            }
        }

         // Check if there is join args present
        if ( isset($args['like'])){
            // Loop for evey join args
            foreach ($args['like'] as $join => $val){
                $this->db->like($val['field'],$val['match']);
            }
        }

        // Check if there is order args
        if (  isset($args['order'])){
            foreach ($args['order'] as $odr => $val){
                $this->db->order_by($val['by'] , $val['path']);
            }
           
        }


        if( isset($args['limit']) ){
            $this->db->limit( $args['limit'] );
        }



        //return the data
        return $this->db->get();
    }

    public function insert_CI_Query($data,$table,$returnQuery = false, $insertBatch = false){
        
        if(!$insertBatch) {
            $this->db->insert( $table ,$data );
        }else{
            $this->db->insert_batch( $table ,$data  );
        }
        
        if(!$returnQuery){
            return $this->db->affected_rows();    
        }

        return $this->db->insert_id();
        
    }
    


    public function create($query){
        
    }

    public function read($query){
        $data =  $cur_db->query($query);
        $cur_db->close();
        return $data;
    }

    public function update($whereArray,$table, $dataSet){
        $this->db->where($whereArray);
        return $this->db->update($table, $dataSet);
    }

    public function delete($whereval,$field, $table) {
        if( is_array( $whereval ) ){
            foreach($whereval as $key => $val){
                $this->db->where($key, $val); 
            }
        }else{
            $this->db->where($field, $whereval); 
        }
       
        $this->db->delete($table);
        return $this->db->affected_rows();
    }


    public function customQuery($query){
       return  $this->db->query($query);
    }


    

    public function printLastquery(){
        print_r($this->db->last_query());
    }
}
