<?php


class View {

	var $template;
	var $variables = array();


	function setTemplate($template){
		$this->template = $template;
	}

	function assign($name, $value){
		$this->variables[$name] = $value;
	}

	function render(){

		echo "<h1>FlickrGuzzle</h1>";

//		$renderFunctions = array(
//			"flickr/flickrNotAuthed" => 'flickrNotAuthed',
//			"flickr/flickrAuthRequest" => 'flickrAuthRequest',
//			"flickr/index" => 'index',
//			"flickr/brands" => 'cameraBrands',
//			"flickr/brandModels" => 'brandModels',
//			"flickr/photoList" => 'photoList',
//			"flickr/apiProgress" => 'apiProgress',
//		);
//
//		if (array_key_exists($this->template, $renderFunctions) == false) {
//			echo "Unknown template [".$this->template."]";
//			return;
//		}


		$renderFunction = str_replace('flickr/', '', $this->template);

		$this->{$renderFunction}();
	}

	function flickrNotAuthed(){

		echo "<p>
			You are not authorized. Click here to <a href='/index.php?function=flickrAuthRequest'>auth</a>.
		</p>";

		$this->renderFooter();
	}

	function flickrAuthRequest(){
		echo "Authorisation request started.<br/>";
		echo "<a href='".$this->variables['flickrURL']."'>Click to go to Flickr to confirm</a>.<br/>";
		echo "(This redirect should be done automatically in a real environment)";
	}


	function photoList(){
		//{showPagination page=$photoList->page maxPages=$photoList->pages}
		$photoList = $this->variables['photoList'];
		foreach ($photoList->photos as $photo) {
			echo "<a href='/index.php?function=flickrPicture&photoID=".$photo->photoID."'>";
			echo "<img src='".$photo->getImageURL()."' />";
			echo "</a>";
		}

		$this->renderFooter();
	}


	function renderFooter(){
		echo "<div style='height: 30px'></div>";
		echo "<hr/>";

		foreach($this->variables['routes'] as $key => $value) {
			echo "<a href='/index.php?function=$value'>";
			echo $key;
			echo "</a>&nbsp;";
		}
	}

	function	cameraBrands(){

		$cameraBrandList = $this->variables['cameraBrandList'];

		foreach ($cameraBrandList->cameraBrands as $cameraBrand) {
			echo "<a href='/index.php?function=flickrCameraBrandModels&cameraBrandID=".$cameraBrand->cameraBrandID."'>";
			echo "ID: ".$cameraBrand->cameraBrandID;
			echo "Name: ".$cameraBrand->name;
			echo "</a>";
			echo "<br/>";
		}

		$this->renderFooter();
	}

	function brandModels() {

		$cameraDetailList = $this->variables['cameraDetailList'];

		foreach ($cameraDetailList->cameraDetails as $cameraDetail) {
			if ($cameraDetail->name) {
				echo "Name: ".$cameraDetail->name."<br/>";
			}

			if ($cameraDetail->megaPixels) {
				echo "MegaPixels: ".$cameraDetail->megaPixels."<br/>";
			}

			if ($cameraDetail->lcdScreenSize) {
				echo "LCD screen size: ".$cameraDetail->lcdScreenSize."<br/>";
			}
			if ($cameraDetail->memoryType) {
				echo "Memory Type: ".$cameraDetail->memoryType."<br/>";
			}
			if ($cameraDetail->zoom) {
				echo "Zoom: ".$cameraDetail->zoom."<br/>";
			}

			if ($cameraDetail->storageType) {
				echo "StorageType: ".$cameraDetail->storageType."<br/>";
			}

//	{if $cameraDetail->images}
//		{if is_array($cameraDetail->images)}
//			{foreach from=$cameraDetail->images item=image}
//				{$image}
//			{/foreach}
//		{/if}
//	{/if}
			echo "<br/>";
		}

		$this->renderFooter();
	}

	function index(){
		echo "<p>Please choose one of the options below.</p>";
		$this->renderFooter();
	}

	function	apiProgress(){

		$apiProgress = $this->variables['apiProgresss'];

		echo "Methods with response classes: ".$apiProgress['operationWithResponseClassCount']."<br/>";
		echo "Methods in Flickr API:	     ".$apiProgress['operationCount']."<br/>";

		$percentage = (100 * $apiProgress['operationWithResponseClassCount']) / $apiProgress['operationCount'];
		$percentageString = sprintf("%01.2f", $percentage);

		echo "Percentage complete: ".$percentageString."% <br/>";

		$functionsLeftToImplement = $apiProgress['functionsLeftToImplement'];

		echo "<h2>Functions left to implement</h2>";

		foreach ($functionsLeftToImplement as $functionLeftToImplement) {
			echo $functionLeftToImplement;
			echo "<br/>";
		}


		$this->renderFooter();
	}

	function licenseList() {
		/** @var $licenseList LicenseList */
		$licenseList = $this->variables['licenseList'];

		foreach ($licenseList->licenses as $license) {
			echo "ID: ".$license->id."&nbsp;";
			echo "Name: ".$license->name."&nbsp;";
			echo "URL: ".$license->url;
			echo "<br/>";
		}

		$this->renderFooter();
	}

	function institutionList(){
		/** @var $instituionList InstitutionList */
		$institutionList = $this->variables['institutionList'];

		foreach ($institutionList->institutions as $institution) {

			$name = $institution->name;
			$siteURL = false;

			//var_dump($institution->urls);

			foreach ($institution->urls as $url) {
				if ($url->type == 'site') {
					$siteURL = $url->url; //ugh

					if (strpos($siteURL, 'http://') === false &&
						strpos($siteURL, 'https://') === false) {
						$siteURL = 'http://'.$siteURL;
					}
				}
			}

			if ($siteURL != false ) {
				echo "<a href='".$siteURL."'>";
				echo $name."</a><br/>";
			}
			else{
				echo $name."<br/>";
			}
		}

		$this->renderFooter();
	}
}




?>