<?php 
class UserM extends MY_Model{

    protected $_tableName = 'b_user';
    protected $_insertFields = array("username","password","email");
    protected $_updateFields = array("username","password","email");



    /**************分页***************/
    /**
     * @param $perpage          每页显示记录数量
     * @return array            array['links']  :   分页的字符串
     *                          array['data']   :   当前页的数据
     */
    public function search($perpage='5'){
        //获取用户提交的搜索条件
        $username = $this->input->get('username');
        if($username){
            $this->db->like('username', $username);
        }
        $password = $this->input->get('password');
        if($password){
            $this->db->like('password', $password);
        }
        $email = $this->input->get('email');
        if($email){
            $this->db->like('email', $email);
        }
        //导入分页类
        $this->load->library('pagination');
        //获取总记录数量
        $total = $this->db->count_all_results($this->_tableName, false);   //注意，取出总记录数默认清空where条件，第二个参数加上false可以防止
        //配置分页参数
        $config['base_url'] = site_url('Admin/UserC/lst');
        $config['total_rows'] = $total;
        $config['per_page'] = $perpage;
        $config['first_link'] = '首页';
        $config['last_link'] = '尾页';
        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';
        $config['reuse_query_string'] = true;        //防止翻页是url参数消失
        $this->pagination->initialize($config);
        //生成分页字符串
        $links = $this->pagination->create_links();
        //排序
        $this->db->order_by('id', 'desc');

        //计算分页偏移量
        $firstRow = (max($this->pagination->cur_page, 1) - 1) * $perpage;      //注意，如果当前页为首页，则cur_page为0，所以应该使cur_page必须大于等于1
        //取出分页数据
        $data = $this->db->get('', $perpage, $firstRow);

        //返回数据
        return array(
            'links' => $links,
            'data' => $data
        );
    }

    /****************添加前的钩子函数***************/
    function _before_insert(&$data){
    }
    /****************修改前的钩子函数***************/
    function _before_update(&$data){
    }
    /****************添加后的钩子函数***************/
    function _after_insert($data){
    }
    /****************修改后的钩子函数***************/
    function _after_update($data){
    }
    /****************删除前的钩子函数***************/
    function _before_delete($data){
    }
}