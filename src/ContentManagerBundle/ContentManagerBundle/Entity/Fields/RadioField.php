<?php

namespace ContentManagerBundle\ContentManagerBundle\Entity\Fields;

use ContentManagerBundle\ContentManagerBundle\Classes\Fields;

/**
 * ContentManagerBundle\ContentManagerBundle\Entity\Fields\RadioField
 *
 */
class RadioField extends Fields
{
    private $html;

    private $type;

    private $params;

    public function __construct(){
    	$this->type = $this->getTypeField();
    	$this->params = array();
    }

    public function getTypeField(){
    	return 'radio';
    }

    public function getName(){
    	return 'Radio field type';
    }

    public function getClassName(){
    	return 'RadioField';
    }

    public function displayfield($field, $value=null){
        $html = '<div class="control-group"><div class="control-label">'.$field->getTitle().'</div>';
        $html .= '<div class="controls">'.$this->getRadio($value, $field->getName()).'</div></div>';
        return $html;
    }

    private function getRadio($value, $name){
        $options = $this->params['options'];
        $options = explode('%%', $options);
        $html = '';
        $checked = '';
        foreach ($options as $key => $option) {
            $option = explode('::', trim($option));
            $checked = ($option[0]==$value)?'checked="checked"':'';
            $html .= '<input type="radio" name="'.$name.'" value="'.$option[0].'" '.$checked.'>'.$option[1];
        }

        return $html;
    }

    public function display($value){
    	$start = null;
    	$end = null;

    	switch($this->params['displaytype']){
    		case 'div':
    			$start = '<div>';
    			$end = '</div>';
    		break;
    		case 'span':
    			$start = '<span>';
    			$end = '</span>';
    		break;
    		case 'p':
    			$start = '<p>';
    			$end = '</p>';
    		break;
    	}

    	$html = $start.' '.$value.' '.$end;

    	return $html;
    }

    public function setParams($params){
    	$this->params = $params;
    	return $this;
    }

    // faire une classe avec les display des differents types: checkbox, select, input etc.
    public function getOptions(){
    	$options = '
    		<label for="options">Options</label>
    		<textarea id="options" name="options[options]" >'.$this->getParamsValue($this->params, 'options').'</textarea>
    		<label for="required">Required</label>
    		<select id="required" name="options[required]" >
    			<option '.$this->getParamsValue($this->params, 'required', 'select', 0).' value="0">No</option>
    			<option '.$this->getParamsValue($this->params, 'required', 'select', 1).' value="1">Yes</option>
    		</select>
    		<label for="displaytype">Display in </label>
    		<select if="displaytype" name="options[displaytype]" >
    			<option '.$this->getParamsValue($this->params, 'displaytype', 'select', 'div').' value ="div">div</option>
    			<option '.$this->getParamsValue($this->params, 'displaytype', 'select', 'span').' value ="span">span</option>
    			<option '.$this->getParamsValue($this->params, 'displaytype', 'select', 'p').' value ="p">paragraphe</option>
    		</select>
    	';

    	return $options;
    }
}
