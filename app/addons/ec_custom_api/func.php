<?php
use Tygh\Registry;
function fn_ec_custom_hook_name($params1, $params2, $params3)
{
   
}

function fn_ec_get_view_all_return_url($variable, $block, $block_schema){
    unset($block['content']['items']['limit']);
    if ($block['content']['items']['filling'] == 'newest'){
        $block['content']['items']['sort_by'] = 'timestamp';
        $block['content']['items']['sort_order'] = 'desc';
    }
    return "&".http_build_query($block['content']['items']);
}

