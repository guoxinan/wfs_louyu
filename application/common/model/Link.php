<?php 
namespace app\common\model;

/**
 * 
 */
class Link extends Base
{
	protected $append = ['status_name'];

	public function bindUpload()
    {
        $bindArr = ['filepath' => 'filepath'];
        return $this->belongsTo('Upload', 'icon')->bind($bindArr);
    }
}