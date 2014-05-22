<?php namespace Core\Helper;

class Form
{
	public static function open($name, $action, $attr = array(), $method = 'POST')
	{
		$form = '<form ';
		$form .= 'name="' . $name . '"';
		$form .= static::addAttributes($attr);
		$form .= ' method="' . $method . '"';
		$form .= ' action="' . $action . '"';
		$form .= '>';

		return $form;
	}

	public static function input($name, $value = '', $attr = array())
	{
		$input = '<input type="text" ';
		$input .= 'name="' . $name . '"';
		$input .= static::addAttributes($attr);
		$input .= ' value="' . $value . '"';
		$input .= '>';

		return $input;
	}

	public static function password($name, $attr = array())
	{
		$input = '<input type="password" ';
		$input .= 'name="' . $name . '"';
		$input .= static::addAttributes($attr);
		$input .= '>';

		return $input;
	}

	public static function text($name, $value = '', $attr = array())
	{
		$textarea = '<textarea ';
		$textarea .= 'name="' . $name . '"';
		$textarea .= static::addAttributes($attr);
		$textarea .= '>';
		$textarea .= $value;
		$textarea .= '</textarea>';

		return $textarea;
	}

	public static function label($string, $attr = array())
	{
		return '<label' . static::addAttributes($attr) . '>' . $string . '</label>';
	}

	public static function dropdown($name, $data, $attr = array(), $selected = null)
	{
		$dropdown = '<select ';
		$dropdown .= 'name="' . $name . '">';
		$dropdown .= static::addAttributes($attr);

		foreach($data as $key => $value)
		{
			$dropdown .= '<option value="' . $key . '"';
			$dropdown .= ($selected == $key) ? ' selected>' : '>';
			$dropdown .= $value;
			$dropdown .= '</option>';
		}

		$dropdown .= '</select>';

		return $dropdown;
	}

	public static function checkbox($name, $value, $attr = array(), $checked = false)
	{
		$input = '<input type="checkbox" ';
		$input .= 'name="' . $name . '"';
		$input .= static::addAttributes($attr);
		$input .= ' value="' . $value . '"';
		$input .= $checked ? ' checked' : '';
		$input .= '>';

		return $input;
	}

	public static function radio($name, $values, $attr = array(), $selected = null)
	{
		$input = '';

		foreach($values as $value)
		{
			$input .= '<input type="radio" ';
			$input .= 'name="' . $name . '"';
			$input .= static::addAttributes($attr);
			$input .= ' value="' . $value . '"';
			$input .= ($selected == $value) ? ' checked' : '';
			$input .= '>';
		}
		
		return $input;
	}

	public static function submit($name = 'submit', $value = 'Submit', $attr = array())
	{
		$input = '<input type="submit" ';
		$input .= 'name="' . $name . '"';
		$input .= static::addAttributes($attr);
		$input .= ' value="' . $value . '"';
		$input .= '>';

		return $input;
	}

	public static function addAttributes($attr = array())
	{
		$text = '';

		if(!empty($attr))
		{
			foreach($attr as $key => $value)
			{
				$text .= ' ' . $key . '="' . $value . '"';
			}			
		}

		return $text;
	}

	public static function close()
	{
		return '</form>';
	}
}
