<?php
function get_project_manager($id_project)
{

    $CI = get_instance();
    $CI->load->model('Project_m');
    $data = $CI->Project_m->get_project_manager_by_id_project($id_project);
    return $data;
}