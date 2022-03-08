<?php


class Cyt_model
{
    function __construct()
    {

    }

    public function provinces()
    {
        $query = ee()->db->select('*')
            ->from('contact_provinces')
            ->get();

        if($query->num_rows() == 0) {
            return false;
        }

        return $query->result_array();
    }

    public function constituency($id)
    {
        ee()->db->select('*')->from('contact_constituencies');//->join('contact_provinces', 'contact_provinces.id = contact_constituencies.province_id');
        if(is_string($id)) {
            ee()->db->where('constituency_url_title', $id);
        } else {
            ee()->db->where('contact_constituencies.id', $id);
        }

        $query = ee()->db->limit(1)->get();

        if($query->num_rows() == 0)
            return false;

        return $query->row_array();
    }

    public function constituencies()
    {
        $query = ee()->db->select('*')
            //->join('contact_provinces', 'provinces.province_id = constituencies.province_id')
            ->from('contact_constituencies')
            ->get();

        if($query->num_rows() == 0) {
            return false;
        }

        return $query->result_array();
    }

    public function politicians($where = null)
    {
        ee()->db->select('*')->from('contact_politicians')
        ->join('contact_parties', 'contact_parties.id = contact_politicians.party_id');

        if($where) {
            ee()->db->where($where);
        }

        $query = ee()->db->get();

        if($query->num_rows() == 0) {
            return false;
        }

        return $query->result_array();
    }

    public function constituency_stats($id)
    {
        ee()->db->select('contact_constituencies_stats.*, contact_parties.party_name, contact_parties.party_colour')->from('contact_constituencies_stats');

        if(is_string($id)) {
            ee()->db->where('constituency_url_title', $id);
        } else {
            ee()->db->where('id', $id);
        }

        ee()->db->join('contact_parties', 'contact_parties.id = contact_constituencies_stats.party_id');
        ee()->db->join('contact_constituencies', 'contact_constituencies.id = contact_constituencies_stats.constituency_id');

        $query = ee()->db->get();

        if($query->num_rows() == 0)
            return false;

        return $query->result_array();
    }
}