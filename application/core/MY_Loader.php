<?php 

class MY_Loader extends CI_Loader {
    

    public function template($template_name, $vars = array(), $return = FALSE, $prefix = 'shared')
    {

    if($return):
        $content  = $this->view( $prefix . '/header', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view($prefix . '/footer', $vars, $return);

        return $content;
    else:
        $this->view($prefix . '/header', $vars);
        $this->view($template_name, $vars);
        $this->view($prefix . '/footer', $vars);
    endif;
    }
}