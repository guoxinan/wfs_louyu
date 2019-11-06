<?php

namespace app\common\func;

class ProductFunc
{
    public static function addFilePathToInfo($info, $imgArr)
    {
        if (array_key_exists('banner', $info)) {
            $imgId = $info['banner'];
            $info['banner_url'] = isset($imgArr[$imgId]) ? $imgArr[$imgId] : '';
        }
        if (array_key_exists('cover', $info)) {
            $imgId = $info['cover'];
            $info['cover_url'] = isset($imgArr[$imgId]) ? $imgArr[$imgId] : '';
        }
        if (array_key_exists('carousel', $info)) {
            $carouselIdArr = explode('_', $info['carousel']);
            $carouselUrl = [];
            foreach ($carouselIdArr as $key => $val) {
                if (isset($imgArr[$val])) {
                    $carouselUrl[] = [
                        'id' => $val,
                        'fileurl' => $imgArr[$val],
                    ];
                }
            }
            $info['carousel_url'] = $carouselUrl;
        }
        return $info;
    }
}

?>