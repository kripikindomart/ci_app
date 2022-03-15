<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Crud_model extends CI_Model
{
    function __construct()
    {
        $this->table = 'crud';
        $this->id = 'id_crud';
        $this->column_order = array(null, 'crud', 'core', null);
        $this->column_search = array('crud', 'core');
        $this->order = array('id_crud' => 'asc');
    }

    public function getRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        $this->db->join('user_role', 'user.id_role = user_role.id_role');
        return $this->db->count_all_results();
    }

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_datatables_query($postData)
    {

        $this->db->from($this->table);
        $this->db->join('user_role', 'user.id_role = user_role.id_role');
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($postData['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function active()
    {
        $id = $this->input->post('id');
        $active = $this->input->post('active');
        if ($active == 1) {
            $this->db->set('is_active', 0);
            $data['active'] = 'false';
        } else {
            $this->db->set('is_active', 1);
            $data['active'] = 'true';
        }
        $this->db->where($this->id, $id);
        $data['data'] = $this->db->update($this->table);
        return $data;
    }
    public function reset()
    {
        $id = htmlspecialchars($this->input->post('id'));
        $pass = htmlspecialchars($this->input->post('pass'));
        $data = [
            'password' => password_hash($pass, PASSWORD_DEFAULT)
        ];
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
        $hasil = [
            'status' => true,
            'pesan' => "Password Berhasil di reset"
        ];
        return $hasil;
    }
    public function tambah()
    {
        $controller = htmlspecialchars($_POST['controller']);
        $core = htmlspecialchars($_POST['core']);
        $cek = $this->db->get_where('crud', ['crud' => $controller])->row();
        if ($cek) {
            $hasil['status'] = false;
            $hasil['pesan'] = "Module sudah Terpakai";
            return $hasil;
        }
        $data = [
            'crud' => $controller,
            'core' => $core,
        ];
        $save = $this->db->insert('crud', $data)->insert_id();
        if ($save) {
        	
        }
        $hasil['status'] = true;
        $hasil['pesan'] = "User berhasil ditambahkan";
        return $hasil;
    }
    public function edit()
    {
        $user = htmlspecialchars($_POST['user']);
        $id = htmlspecialchars($_POST['id']);
        $id_role = htmlspecialchars($_POST['role']);
        $cek = $this->db->get_where($this->table, [$this->id => $id])->row();
        if ($cek->username != $user) {
            $cek2 = $this->db->get_where($this->table, ['username' => $user])->row();
            if ($cek2) {
                $hasil['status'] = false;
                $hasil['pesan'] = "Username sudah terpakai";
                return $hasil;
            }
            $this->db->set('username', $user);
        }
        $this->db->set('id_role', $id_role);
        $this->db->where($this->id, $id);
        $this->db->update($this->table);
        $hasil['status'] = true;
        $hasil['pesan'] = "User berhasil diubah";
        return $hasil;
    }
    public function hapus()
    {
        $id = htmlspecialchars($_POST['id']);
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
        $hasil['status'] = true;
        $hasil['pesan'] = "User berhasil dihapus";
        return $hasil;
    }
}
