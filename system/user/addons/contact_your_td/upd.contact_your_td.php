<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include(PATH_THIRD.'/contact_your_td/config.php');

class Contact_your_td_upd {

    public $version = MODULE_VERSION;

    // --------------------------------------------------------------------

    /**
     *	Constructor
     *
     *	@access		public
     *	@return		null
     */
    public function __construct()
    {
    }

    // --------------------------------------------------------------------

    public function install()
    {
        // Module
        $mod_data = array(
            'module_name'			=> 'ContactYourTD',
            'module_version'		=> $this->version,
            'has_cp_backend'		=> 'n',
            'has_publish_fields'	=> 'n'
        );

        ee()->db->insert('modules', $mod_data);

        return TRUE;
    }

    // --------------------------------------------------------------------

    public function uninstall()
    {
        // Module
        $mod_id = ee()->db->select('module_id')
            ->get_where('modules', array(
                'module_name' => 'ContactYourTD'
            ))->row('module_id');
        ee()->db->where('module_id', $mod_id)->delete('module_member_groups');
        ee()->db->where('module_name', 'Cpd')->delete('modules');

        // Extension
        // ee()->db->where('class', 'Cpd_ext')->delete('extensions');

        return TRUE;
    }

    // --------------------------------------------------------------------

    public function update($current = '')
    {
        return TRUE;
    }

    // --------------------------------------------------------------------

}
