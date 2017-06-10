<?php

class HtmlGenerator {

	public function createAdditionalContent($array) {
		$string = '';
		foreach($array as $row){
			foreach($row as $type => $value2){
					switch ($type) {
						case 'file':
							$string .= '<label>'. $type . '</label>';
							$string .= '<input id="'.$value2.'" type="file" name="' . $value2 . '" multiple>';
							$string .= '<br>';
						break;
						case 'selectbox':
							$string .= $this->createSelectbox($value2, 0);
						break;
						case 'textarea':
							$string .= $this->createTextarea($value2);
							break;
						default:
					}
				}
			}
		return $string;
	}

	public function createSelectbox($array, $selected = 1) {
		$string = '<select>';
		$count = 1;
		foreach($array as $row) {
			if($selected == $count) {
				$string .= '<option selected value="' . array_values($row)[0] . '">';
			} else {
				$string .= '<option value="' . array_values($row)[0] . '">';
			}
			$string .= array_values($row)[1];
			$string .= '</option>';
			$count++;
		}
		$string .= '</select>';
		return $string;
	}

	public function createOptions($array, $selected = 1) {
		$string = '';
		$count = 1;
		foreach($array as $row) {
			if($selected == $count) {
				$string .= '<option selected value="' . array_values($row)[0] . '">';
			} else {
				$string .= '<option value="' . array_values($row)[0] . '">';
			}
			$string .= array_values($row)[1];
			$string .= '</option>';
			$count++;
		}
		return $string;
	}

	public function createMultiSelectboxes($array, $selected = 1) {
		$string = '';
		foreach($array as $row) {
			$string .= $this->createSelectbox($row, $selected);
		}
		return $string;
	}

	public function createUpdateForm($array, $addition) {
		$string = '<form method="post" enctype="multipart/form-data">';
		foreach($array as $key => $value) {
			foreach($value as $key2 => $value2) {
				$string .= '<label>'. $key2 . '</label>';
				$string .= '<input type="text" name="' . $value2 . '">';
				$string .= '<br>';
			}
		}
		$string .= $this->createAdditionalContent($addition);
		$string .= '</form>';
		return $string;
	}
	public function createTextarea($array) {
		$string = '';
		foreach($array as $key => $value) {
			foreach($value as $key2 => $value2) {
				$string .= '<label>'.$key2.':</label><br>';
				$string .= '<textarea type="text" name="' . $key2 . '" ></textarea>';
				$string .= '<br>';

			}
		}
		return $string;
	}

	public function createCreationForm($array, $addition) {
		$string = '<form method="post" enctype="multipart/form-data">';
		foreach($array as $key => $value) {
			foreach($value as $key2 => $value2) {
				$string .= '<label>'.$key2.':</label><br>';
				$string .= '<input type="text" name="' . $key2 . '" value="">';
				$string .= '<br>';

			}
		}


				$string .= $this->createAdditionalContent($addition);

				$string .= "<input type='submit' name='submit' value='Aanmaken'>";
		$string .= '</form>';
		return $string;
	}


	public function createTable($array, $prefixHeader, $suffixHeader, $prefix, $suffix, $addition) {
		$count = 0;
		$string = '<table>';
		$string .= '<tr>';
		foreach($array as $key => $value) {
			if($count < 1) {
				foreach($value as $key2 => $value2) {
					$string .= '<th>';
						foreach($prefixHeader as $prefixKey => $prefixValue) {
							if($key2 == $prefixKey) {
								$string .= $prefixValue;
								break;
							}
						}

						$string .= $key2;

						foreach($suffixHeader as $suffixKey => $suffixValue) {
							if($key2 == $suffixKey) {
								$string .= $suffixValue;
								break;
							}
						}
					$string .= '</th>';
				}
			} else {
				break;
			}
			$count++;
		}
		$string .= '</tr>';

		foreach($array as $key => $value) {
			$string .= '<tr>';
			foreach($value as $row => $value2) {

				$string .= '<td>';

				foreach($prefix as $prefixKey => $prefixValue) {
					if($value2 == $prefixKey) {
						$string .= $prefixValue;
						break;
					}
				}

				 $string .= $value2;


				foreach($suffixHeader as $suffixKey => $suffixValue) {
					if($value2 == $suffixKey) {
						$string .= $suffixValue;
						break;
					}
				}

				$string .= '</td>';

			}
			$string .= '</tr>';
		}

		$string .= '</table>';
		return $string;
	}
}
