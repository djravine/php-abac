<?php

namespace PhpAbac\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class MysqlAbacLoader extends FileLoader
{
    
    private $CI;
    
    public function __construct($input) {
        parent::__construct($input);
        
        $this->CI =& get_instance();
        $this->CI->load->database('db_read');
    }
    
    public function load($resource, $type = null)
    {
        $result = $this->CI->db
            ->select('policy')
            ->where('resource', $resource)
            ->get('abac_policy');
        
        return ($result->num_rows() === 0) ? false : json_decode($result->row()->policy, true);
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource);
    }
}