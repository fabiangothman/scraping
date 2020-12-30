<?php
/*if(isset($_GET['btn'])):
    function file_get_contents_curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    function limpiarString($String){ 
        $String = str_replace(array("|","|","[","^","´","`","¨","~","]","'","#","{","}",".",""),"",$String);
        return $String;
    }

    $url 	=	$_GET['url'];
	$html 	= 	file_get_contents_curl($url);                    
    $doc 	= 	new DOMDocument();
    @$doc->loadHTML($html);
    $nodes 	= 	$doc->getElementsByTagName('title');
    $title 	= 	limpiarString($nodes->item(0)->nodeValue);
    $metas 	= 	$doc->getElementsByTagName('meta');
    for ($i = 0; $i < $metas->length; $i++):
		$meta = $metas->item($i);
        if($meta->getAttribute('name') == 'description')
        	$description = limpiarString($meta->getAttribute('content'));
        if($meta->getAttribute('name') == 'keywords')
        	$keywords = limpiarString($meta->getAttribute('content'));
    endfor;
	echo "TITLE :<br>".$title."<br>";
    echo "DESCRIPTION :<br>".$description."<br>";
    echo "KEYWORDS :<br>".$keywords;
else:
<?php endif; ?>
*/


$general_url = file_get_contents('https://www.milanuncios.com/anuncios/');
 
 
//creamos nuevo DOMDocument y cargamos la url
$general_dom = new DOMDocument();
@$general_dom->loadHTML($general_url);
 
//obtenemos todos los div de la url
$cat_options = $general_dom->getElementById( 'ca0' );
$categories = $cat_options->getElementsByTagName('option');

for ($i=1; $i < $categories->length; $i++) {
	echo $categories->item($i)->getAttribute('value');

	$category_url = file_get_contents("https://www.milanuncios.com/".$categories->item($i)->getAttribute('value')."/");
	$category_dom = new DOMDocument();
	@$category_dom->loadHTML($category_url);
	//obtenemos todos los div de la url
	$sbcat_options = $category_dom->getElementById( 'ca1' );
	if($sbcat_options){
		$subcategories = $sbcat_options->getElementsByTagName('option');

		for ($j=1; $j < $subcategories->length; $j++) { 
			echo "<br /> --> ".$subcategories->item($j)->getAttribute('value');

			$subCategory_url = file_get_contents("https://www.milanuncios.com/".$subcategories->item($j)->getAttribute('value')."/");
			$subCategory_dom = new DOMDocument();
			@$subCategory_dom->loadHTML($subCategory_url);
			//obtenemos todos los div de la url
			$itemsCont = $subCategory_dom->getElementById('cuerpo');
			//$items = $itemsCont->getElementsByClass('aditem-detail');
			$divItems = $itemsCont->getElementsByTagName('div');

			for ($k=0; $k < $divItems->length; $k++) {
				if($divItems->item($k)->getAttribute('class') === "aditem-detail"){
					echo "<br />______t_______ ".$divItems->item($k)->getElementsByTagName('a')[0]->nodeValue;
					echo "<br />______d_______ ".$divItems->item($k)->getElementsByTagName('div')[2]->nodeValue;
				}
			}
			
		}
	}

	
	echo "<br /><br /><br />";
}

//Pasar a CSV
exit();