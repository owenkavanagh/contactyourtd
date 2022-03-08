<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_your_td {

    public $return_data;

    // --------------------------------------------------------------------

    /**
     *	Constructor
     *
     *	@access		public
     *	@return		null
     */
    public function __construct()
    {
        ee()->load->model('cyt_model');
    }

    // --------------------------------------------------------------------

    public function provinces()
    {
        ee()->load->model('cyt_model');
        $provinces = ee()->cyt_model->provinces();

        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $provinces);
    }

    public function constituencies()
    {
        // channel entry wrapper
        ee()->load->model('cyt_model');

        $url_title = ee()->TMPL->fetch_param('url_title');

        if(!$url_title) {
            $provinces = ee()->cyt_model->provinces();
            $constituencies = ee()->cyt_model->constituencies();

            $vars = [];

            foreach ($provinces as $province) {
                $var = [];

                $var['province_name'] = $province['province_name'];
                $var['province_url_title'] = $province['province_url_title'];
                $var['constituencies'] = [];
                foreach ($constituencies as $constituency) {
                    if($constituency['province_id'] == $province['id']) {
                        $var['constituencies'][] = $constituency;
                    }
                }

                $vars[] = $var;
            }

            return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $vars);
        } else {

            $constituency = ee()->cyt_model->constituency($url_title);

            $politicians = ee()->cyt_model->politicians(['constituency_id' => $constituency['id']]);
            $prefixed_politicians = [];

            foreach ($politicians as $politician) {
                $prefixed_politicians[] = array_combine(array_map(function($key){ return 'politicians:'.$key; }, array_keys($politician)), $politician);
            }

            $constituency['politicians'] = $prefixed_politicians;

            return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, [$constituency]);

        }
    }

    public function constituency_stats()
    {
        ee()->load->model('cyt_model');
        $url_title = ee()->TMPL->fetch_param('url_title');
        $stats = ee()->cyt_model->constituency_stats($url_title);

        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $stats);
    }

    // --------------------------------------------------------------------

    public function parties()
    {
        $query = ee()->db->select('*')
            ->from('contact_parties')
            ->get();

        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata, $query->result_array());
    }

    public function url_embed()
    {
        return ee()->TMPL->parse_variables(urlencode(ee()->TMPL->tagdata), []);
    }





}
