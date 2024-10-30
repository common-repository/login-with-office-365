<?php


class Mo_o365_MoPointer
{

    private $content,$anchor_id,$edge,$align,$active,$pointer_name;

    function __construct($header,$body,$anchor_id,$edge,$align,$active,$prefix){

        $this->content = '<h3>' . __( $header ) . '</h3>';
        $this->content .= '<p  id="'.$prefix.'" style="font-size: initial;">' . __( $body ) . '</p>';
        $this-> anchor_id = $anchor_id;
        $this->edge = $edge;
        $this->align = $align;
        $this->active = $active;
        $this->pointer_name = 'miniorange_admin_pointer_'.$prefix;
    }

     function return_array(){
        return array(
            'content' => $this->content,
            'anchor_id' => $this->anchor_id,
            'edge' => $this->edge,
            'align' => $this->align,
            'active' => $this->active
        );
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getAnchorId()
    {
        return $this->anchor_id;
    }

    /**
     * @return mixed
     */
    public function getEdge()
    {
        return $this->edge;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPointerName()
    {
        return $this->pointer_name;
    }

}