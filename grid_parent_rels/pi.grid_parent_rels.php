<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
	'pi_name'           => 'Grid Parent Relationships',
	'pi_version'        => '1.1',
	'pi_author'         => 'James Smith',
	'pi_author_url'     => 'http://www.jamessmith.co.uk/',
	'pi_description'    => 'Fetch parent relationships that are inside a grid column',
	'pi_usage' => '{exp:grid_parent_rels entry_id="{entry_id}" field_id="123"}',
);

class Grid_parent_rels
{

	var $return_data = "";

	public function __construct()
	{
		$out = '';
		$entry_id = ee()->TMPL->fetch_param('entry_id');
		$field_id = ee()->TMPL->fetch_param('field_id');

		$query =    ee()->db->select('parent_id')
							->distinct('parent_id')
							->where('grid_field_id', $field_id)
							->where('child_id', $entry_id)
							->get('relationships');

		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $result)
			{
				$ids[] = $result['parent_id'];
			}
			$out = implode("|", $ids);
		} else {
			$out = "0|";
		}
		$this->return_data = $out;
	}
}