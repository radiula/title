<?php namespace Radiula\Title\Models;

class Title {

    protected $layout;
    protected $segmentSeperator;
    protected $siteName;
    protected $segments = [];

    public function __construct(\Illuminate\Config\Repository $config)
    {
        $this->layout = $config->get('radiula/title::layout');
        $this->segmentSeperator = $config->get('radiula/title::segmentSeperator');
    }

    /**
     * Set the site name
     *
     * @return void
     */
    public function siteName($name)
    {
        $this->siteName = $name;
    }

    /**
     * Set the segments for the page title, removing any that are null
     *
     * @return void
     */
    public function segment()
    {
        $this->segments = array_merge(array_filter(func_get_args(), function($segment) {
            return $segment !== null;
        }), $this->segments);
    }

    /**
     * Override the layout
     *
     * @return void
     */
    public function layout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Build the site title using the segments and title
     *
     * @return string
     */
    public function make()
    {
        $segments = implode($this->segmentSeperator, $this->segments);

        return trim(sprintf($this->layout, $segments, $this->siteName), ' | ');
    }
}
