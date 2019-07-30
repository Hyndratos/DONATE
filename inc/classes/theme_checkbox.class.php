<?php

class theme_checkbox
{
    public function __construct($checkbox_title, $checkbox_name, $options = array())
    {
        $this->checkboxName = $checkbox_name;
        $this->checkboxTitle = $checkbox_title;
        $this->options = $options;
    }

    public function display()
    {

        $option = '';
        $display = '';

        $checked = '';
        $o_style = '';

        $val = '';

        if (isset($_GET['id'])) {
            $checked = 'checked';
            $o_style = 'display: block;';

            $theme = $_GET['id'];
            $file = file_get_contents('themes/' . $theme . '/style.css');
        }

        //die(var_dump($this->options));

        foreach ($this->options as $key => $value) {
            if (isset($value['class'])) {
                $class = $value['class'];
            } else {
                $class = '';
            }

            if (isset($value['classtype'])) {
                $classtype = $value['classtype'];
            } else {
                $classtype = '';
            }

            if (isset($value['extra'])) {
                $extra = $value['extra'];
            } else {
                $extra = '';
            }

            if (isset($value['wrap'])) {
                $wrap = $value['wrap'];
            } else {
                $wrap = 'rgb';
            }

            $colour = isset($value['colour']) ? $value['colour'] : true;
            if($colour){
                $colour = 'color_box';
            }

            if (isset($_GET['id'])) {
                /*

                    $class\{$classtype\: $wrap\((\d+,\d+,\d+)\)$extra

                 */

                $p_class = str_replace('(odd)', '\(odd\)', $class);

                $extra_pattern = $extra;
                if(!empty($extra)){ $extra_pattern = ' ' . $extra; }

                $pattern = "/[\s+|\}]$p_class\{$classtype\: $wrap\(([\d\w\s\S]+?)\)$extra_pattern/";

                preg_match($pattern, $file, $matches);

                if (isset($matches[1])) {
                    $val = $matches[1];
                }
            }

            $extra_attr = '';

            if(isset($value['extra_attr'])) {
                foreach ($value['extra_attr'] as $attr_key => $attr) {
                    $extra_attr .= '<input type="hidden" name="theme_extra_attr[' . $this->checkboxName . '_' . $value['name'] . '][' . $attr_key . ']" value="' . $attr . '">';
                }
            }

            $option .= '
					<div class="form-group">
						<label class="col-sm-2 control-label">' . $value['title'] . '</label>
						<div class="col-sm-10">
							<input type="text" forclass="' . $class . '" classtype="' . $classtype . '" class="form-control '. $colour .'" placeholder="' . $value['desc'] . '" name="theme_rgb[' . $this->checkboxName . '_' . $value['name'] . ']" value="' . $val . '">
							<input type="hidden" name="theme_class[' . $this->checkboxName . '_' . $value['name'] . ']" value="' . $class . '">
							<input type="hidden" name="theme_classtype[' . $this->checkboxName . '_' . $value['name'] . ']" value="' . $classtype . '">
							<input type="hidden" name="theme_extra[' . $this->checkboxName . '_' . $value['name'] . ']" value="' . $extra . '">
							<input type="hidden" name="theme_wrap[' . $this->checkboxName . '_' . $value['name'] . ']" value="' . $wrap . '">
							'.$extra_attr.'
						</div>
					</div>
				';

            $val = '';
        }

        $display = '
				<div class="checkbox">
					<input type="checkbox" class="action_checkbox" name="' . $this->checkboxName . '" ' . $checked . '>
					<label>' . $this->checkboxTitle . '</label>
					<div class="options" style="' . $o_style . '">
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<h2>' . $this->checkboxTitle . '</h2>
						</div>
					</div>
						' . $option . '
					</div>
				</div>
			';

        echo $display;
    }
}