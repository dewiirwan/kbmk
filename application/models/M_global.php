<?php
class M_global extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function filterisasi($data)
    {
        $list_block = array(
            '<?php'         => '',
            '<?'            => '',
            '?>'            => '',
            'php_info()'    => '',
            'echo'          => '',
            '</script>'     => '',
            '</script>'     => ''
        );
        return strtr($data, $list_block);
    }

    public function getData($value = '')
    {
        $this->db->select($value['select']);
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        if (isset($value['where_in'])) {
            $this->db->where_in($value['where_in']);
        }

        if (isset($value['join'])) {
            foreach ($value['join'] as $join) {
                $this->db->join($join['0'], $join['1'], 'left');
            }
        }

        if (isset($value['group'])) {
            $this->db->group_by($value['group']);
        }

        if (isset($value['limit'])) {
            $this->db->limit($value['limit']);
        }
        if (isset($value['having'])) {
            $this->db->having($value['having']);
        }
        if (isset($value['order'])) {
            $this->db->order_by($value['order']);
        }

        $result = $this->db->get()->result();
        return $result;
    }

    public function getRow($value = '')
    {
        $this->db->select($value['select']);
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        if (isset($value['join'])) {
            foreach ($value['join'] as $join) {
                $this->db->join($join['0'], $join['1'], 'left');
            }
        }

        if (isset($value['group'])) {
            $this->db->group_by($value['group']);
        }

        if (isset($value['limit'])) {
            $this->db->limit($value['limit']);
        }
        if (isset($value['order'])) {
            $this->db->order_by($value['order']);
        }

        $result = $this->db->get()->row();
        return $result;
    }

    public function getNum($value = '')
    {
        $this->db->select($value['select']);
        $this->db->from($value['table']);

        if (isset($value['where'])) {
            $this->db->where($value['where']);
        }

        if (isset($value['join'])) {
            foreach ($value['join'] as $join) {
                $this->db->join($join['0'], $join['1'], 'left');
            }
        }

        if (isset($value['group'])) {
            $this->db->group_by($value['group']);
        }

        if (isset($value['limit'])) {
            $this->db->limit($value['limit']);
        }
        if (isset($value['order'])) {
            $this->db->order_by($value['order']);
        }

        $result = $this->db->get()->num_rows();
        return $result;
    }
}
