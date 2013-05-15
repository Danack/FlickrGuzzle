<?php


class View {

	var $template;
	var $variables = array();
	var $statusMessageArray = array();


	function addStatusMessage($message) {
		$this->statusMessageArray[] = $message;
	}

	function setTemplate($template){
		$this->template = $template;
	}

	function assign($name, $value){
		$this->variables[$name] = $value;
	}

	function render(){

		pageStart();

		echo "<h1><a href='/index.php'>FlickrGuzzle</a></h1>";

		foreach ($this->statusMessageArray as $statusMessage) {
			echo "$statusMessage <br/>";
		}

		$renderFunction = str_replace('flickr/', '', $this->template);

		$this->{$renderFunction}();
	}

	function	activityInfo(){
		$activityInfo = $this->variables['activityInfo'];

		echo "Function call succeeded - have fun with this object:<br/>";

		var_dump($activityInfo);
		$this->renderFooter();
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
			echo "<a href='/index.php?function=photo&photoID=".$photo->photoID."'>";
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

		echo "<hr/>";
		echo "Authed methods:<br/>";

		foreach($this->variables['authedRoutes'] as $key => $value) {
			echo "<a href='/index.php?function=$value'>";
			echo $key;
			echo "</a>&nbsp;";
		}

	}

	function	brands(){

		$cameraBrandList = $this->variables['cameraBrandList'];

		foreach ($cameraBrandList->cameraBrands as $cameraBrand) {
			echo "<a href='/index.php?function=flickrCameraBrandModels&cameraBrandID=".$cameraBrand->cameraBrandID."'>";
			echo "ID: ".$cameraBrand->cameraBrandID;
			echo "&nbsp;";
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

			if ($cameraDetail->storageType) {
				echo "Storage Type: ".$cameraDetail->storageType."<br/>";
			}
			if ($cameraDetail->zoom) {
				echo "Zoom: ".$cameraDetail->zoom."<br/>";
			}

			if ($cameraDetail->storageType) {
				echo "StorageType: ".$cameraDetail->storageType."<br/>";
			}

			if ($cameraDetail->images) {
			//	var_dump($cameraDetail->images);
			}

			echo "<br/>";
		}

		$this->renderFooter();
	}

	function index(){
		echo "<p>Please choose one of the options below.</p>";
		$this->renderFooter();
	}


	function methodList(){
		$methodList = $this->variables['methodList'];

		foreach ($methodList->methods as $method) {
			echo "<a href='/index.php?function=methodInfo&method=".$method."'>";
			echo $method;
			echo "</a>";
			echo "<br/>";
		}

		$this->renderFooter();
	}

	function methodInfo(){
		$methodInfo = $this->variables['methodInfo'];
		var_dump($methodInfo);
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

		echo "<hr/>";

		echo "<h2>Functions with response classes</h2>";


		echo "Copy this to phpstorm.meta.php:<br/>";
		echo "<br/><br/>";

		$functionsWithResponseClasses = $apiProgress['functionsWithResponseClasses'];

		foreach ($functionsWithResponseClasses as $key => $value) {
			echo "'".$key."' instanceof \\".$value.",<br/>";
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
			$siteURL = FALSE;

			//var_dump($institution->urls);

			foreach ($institution->urls as $url) {
				if ($url->type == 'site') {
					$siteURL = $url->url; //ugh

					if (strpos($siteURL, 'http://') === FALSE &&
						strpos($siteURL, 'https://') === FALSE) {
						$siteURL = 'http://'.$siteURL;
					}
				}
			}

			if ($siteURL != FALSE ) {
				echo "<a href='".$siteURL."'>";
				echo $name."</a><br/>";
			}
			else{
				echo $name."<br/>";
			}
		}

		$this->renderFooter();
	}


	function	flickrUpload(){

		echo "<p>This is the happy fun-time flickr uploader.</p>";

		echo "<form method='post' accept-charset='utf-8' action='/index.php?function=flickrUpload' onsubmit='' class='inlineForm' name='contactForm' enctype='multipart/form-data'>";

		echo "<input type='file' name='fileUpload'/><br/>";

		echo "Title<br/>";
		echo "<input type='text' name='title' size='100' /><br/>";

		echo "Description<br/>";
		echo "<textarea rows='8' cols='100' name='description'>";
		echo "</textarea>";
		echo "<br/>";
		echo "<input type='submit' name='submitButton' class='clickyButton' value='Upload'/>";
		echo "</form>";

		$this->renderFooter();
	}

	function blogList(){
		$blogList = $this->variables['blogList'];

		foreach ($blogList->blogList as $blog) {
			echo "<a href='".$blog->url."'>";
			echo $blog->name."<br/>";
			echo "</a><br/>";
		}

		$this->renderFooter();
	}


	function contactList() {
		$contactList = $this->variables['contactList'];

		//var_dump($contactList

		echo "Total contacts is:".$contactList->total."<br/>";

		//var_dump($contactList);

		foreach ($contactList->users as $user) {
			echo $user->userName."<br/>";
		}

		$this->renderFooter();
	}



	function blogServicesList(){
		$blogServicesList = $this->variables['blogServicesList'];

		foreach($blogServicesList->blogServiceList as $blogService) {
			echo $blogService->id.": ";
			echo $blogService->name;
			echo "<br/>";
		}
		$this->renderFooter();
	}


	function	photo(){
		$photoID = $this->variables['photoID'];
		$photoInfo = $this->variables['photoInfo'];

		if (array_key_exists('tagList', $this->variables) == true){
			$tagList = $this->variables['tagList'];

			//var_dump($tagList->tags);

			echo "Tags are:<br/>";
			foreach ($tagList->tags as $tag) {
				echo $tag->text."<br/>";
			}
		}


		echo "<table><tr><td>";

		$url = "/index.php?function=photo&photoID=".$photoID;
		echo "<a href='$url'>PhotoID: ".$photoID."<br/>";
		$photo = $photoInfo->photo;

		echo "<img src='".$photo->getImageURL()."' /></a>";

		echo "</td><td>";

		$this->displayPhotoButtons($photoID);

		echo "</td></tr></table>";


		foreach ($photoInfo->notes as $note) {
			echo "<form method='post' accept-charset='utf-8' action='/index.php'>";

			echo "'".$note->text."'";

			echo "<input type='hidden' name='function' value='deleteNote' />";
			echo "<input type='hidden' name='photoID' value='".$photoID."' />";
			echo "<input type='hidden' name='noteID' value='".$note->noteID."' />";
			echo "<input type='submit' name='submitButton' class='clickyButton' value='Delete note'/>";

			echo "</form>";
		}


		echo "PhotoInfo has lots of info: <br/>";
		var_dump($photoInfo);

		$this->renderFooter();
	}

	function displayPhotoButtons($photoID){
		$this->displayRotateButton($photoID);
		$this->displayNoteAddButton($photoID);
		$this->displayGetTagsButton($photoID);
		$this->displayReplacePhotoButton($photoID);
		$this->displayAddToFavouritesButton($photoID);

		$this->displayRemoveFromFavouritesButton($photoID);


		$this->displayTweetButton($photoID);


	}

	function	displayRotateButton($photoID){
		echo "<div class='bordered'>";
		echo "<form method='post' accept-charset='utf-8' action='/index.php'>";

			echo "<input type='hidden' name='function' value='photoRotate' />";
			echo "<input type='hidden' name='photoID' value='".$photoID."' />";

			echo "<select name='degrees'>";
				echo "<option value='90'>90°</option>";
				echo "<option value='180'>180°</option>";
				echo "<option value='270'>270°</option>";
			echo "</select>";

			echo "<input type='submit' name='submitButton' class='clickyButton' value='Rotate photo'/>";
		echo "</form>";
		echo "</div>";
	}

	function	displayNoteAddButton($photoID){
		echo "<div class='bordered'>";
		echo "<form method='post' accept-charset='utf-8' action='/index.php'>";

		echo "<input type='hidden' name='function' value='noteAdd' />";
		echo "<input type='hidden' name='photoID' value='".$photoID."' />";

		echo "<input type='text' name='noteText' width='80' >";

		echo "<input type='submit' name='submitButton' class='clickyButton' value='Add note'/>";
		echo "</form>";
		echo "</div>";
	}



	function displayAddToFavouritesButton($photoID){

		echo "<div class='bordered'>";
		$url = "/index.php?function=addToFavourites&photoID=".$photoID;

		echo "<a href='$url'>Add to favourites</a>";
		echo "</div>";
	}


	function displayRemoveFromFavouritesButton($photoID){

		echo "<div class='bordered'>";
		$url = "/index.php?function=removeFromFavourites&photoID=".$photoID;

		echo "<a href='$url'>Remove from favourites</a>";
		echo "</div>";
	}


	function displayGetTagsButton($photoID){
		echo "<div class='bordered'>";

		$url = "/index.php?function=getPhotoTags&photoID=".$photoID;

		echo "<a href='$url'>Get tags for photo</a>";
		echo "</div>";
	}


	function displayReplacePhotoButton($photoID){
		echo "<div class='bordered'>";

		echo "<form method='post' accept-charset='utf-8' action='/index.php' onsubmit='' class='inlineForm' name='contactForm' enctype='multipart/form-data'>";

		echo "<input type='hidden' name='function' value='replacePhoto' />";
		echo "<input type='hidden' name='photoID' value='".$photoID."' />";

		echo "<input type='file' name='fileUpload'/><br/>";

		$url = "/index.php?function=getPhotoTags&photoID=".$photoID;
		echo "<input type='submit' name='submitButton' class='clickyButton' value='Replace photo'/>";
		echo "</form>";
		echo "</div>";
	}

	function displayTweetButton($photoID){
		echo "<div class='bordered'>";
		$url = "/index.php?function=blogPost&photoID=".$photoID;
		echo "<a href='$url'>Tweet this</a>";
		echo "</div>";
	}



	function lookupUser(){
		$lookupUser = $this->variables['lookupUser'];
		echo "UserID: ".$lookupUser->userID."<br/>";
  		echo "Username: ".$lookupUser->username."<br/>";
		$this->renderFooter();
	}

	function lookupGroup(){
		$lookupGroup = $this->variables['lookupGroup'];

		echo "GroupID: ".$lookupGroup->groupID."<br/>";
  		echo "Group name ".$lookupGroup->groupName."<br/>";

		$this->renderFooter();
	}

	function lookupGallery(){
		$lookupGallery = $this->variables['lookupGallery'];

		var_dump($lookupGallery);

//		echo "GroupID: ".$lookupGroup->groupID."<br/>";
//		echo "Group name ".$lookupGroup->groupName."<br/>";

		$this->renderFooter();
	}

	function	urlInfo(){
		$urlInfo = $this->variables['urlInfo'];
		echo "NSID: ". $urlInfo->nsid."<br/>";
		echo "URL: ".$urlInfo->url."<br/>";
		$this->renderFooter();
	}


	function	tagList(){
		$tagList = $this->variables['tagList'];

		echo "<h2>Tag list</h2>";

		foreach ($tagList->tags as $tag) {
			echo "".$tag->text;

			if ($tag->count != null) {
				echo "&nbsp;";
				echo $tag->count;
			}

			echo "&nbsp;";
			$url = "/index.php?function=getRelatedTags&tagText=".$tag->text;
			echo "<a href='$url'>Get related</a>";

			echo "<br/>";
		}

		$this->renderFooter();
	}

	function	accountStat() {
		$accountStat = $this->variables['accountStat'];
		var_dump($accountStat);
		$this->renderFooter();
	}

	function	placeList() {
		$placeList = $this->variables['placeList'];

		echo "<table>";
			echo "<thead>";
				echo "<tr><th>";
					echo "Lat.";
				echo "</th><th>";
					echo "Long.";
				echo "</th><th >"; //Covers the functions that need a woeID
					echo "Name";
				echo "</th><th colspan='2'>";
					echo "&nbsp;";
				echo "</th></tr>";
			echo "</thead>";
			echo "<tbody>";
		foreach ($placeList->places as $place) {

			echo "<tr><td>";
				echo $place->latitude;
			echo "</td><td>";
			echo $place->longitude;
			echo "</td><td>";
				echo $place->name;
			echo "</td><td>";
				$url = "/index.php?function=findPlacesWithPhotosPublic&woeID=".$place->woeID;
				echo "<a href='".$url."'>";
				//echo $place->woeID;
				echo "Find public photos";
				echo "</a>";
			echo "</td><td>";
			$url = "/index.php?function=findPlacesForUser&woeID=".$place->woeID;
			echo "<a href='".$url."'>";

			echo "Find places for user";
			echo "</a>";

			echo "</td><td>";

			$url = "/index.php?function=findPlacesForContacts&woeID=".$place->woeID;
			echo "<a href='".$url."'>";
			echo "Find places for contacts";
			echo "</a>";

			echo "</td></tr>";
		}

		echo "</tbody>";
		echo "</table>";

		$this->renderFooter();
	}
}




?>