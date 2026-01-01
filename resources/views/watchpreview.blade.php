<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{{ $courses->title }}</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1 user-scalable=no" />
		<script src="{{asset('js/jquery.min.js')}}"></script>
		<link rel="stylesheet" type="text/css"  href="{{url('content/global.css')}}"/>
		<link rel="stylesheet" href="{{url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}"><!-- fontawesome css -->
<link rel="stylesheet" href="{{ url('vendor/fontawesome/css/all.css') }}" /> <!--  fontawesome css -->
<link rel="stylesheet" href="{{ url('vendor/font/flaticon.css') }}" /> <!-- fontawesome css -->

		<?php
	    	$psetting = App\PlayerSetting::first();
		?>
			<link rel="stylesheet" href="{{ url('css/colorbox.css') }}">
<script src="{{ url('js/colorbox.js') }}"></script> <!-- colorbox js -->
		<script src="{{url('js/FWDUVPlayer.js')}}"></script>
		
		
		 
		<!-- Setup video player-->
		<script type="text/javascript">
			FWDUVPUtils.onReady(function(){
			   
				new FWDUVPlayer({		
					//main settings
					instanceName:"player1",
					parentId:"myDiv",
					playlistsId:"courseplaylist",
					mainFolderPath:"{{url('content')}}",
					skinPath:"metal_skin_dark",
					displayType:"responsive",
					initializeOnlyWhenVisible:"no",
					useVectorIcons:"no",
					fillEntireVideoScreen:"no",
					fillEntireposterScreen:"yes",
					goFullScreenOnButtonPlay:"no",
					playsinline:"yes",
					privateVideoPassword:"428c841430ea18a70f7b06525d4b748a",
					youtubeAPIKey:"",
					useHEXColorsForSkin:"no",
					normalHEXButtonsColor:"#666666",
					googleAnalyticsTrackingCode:"",
					useResumeOnPlay:"yes",
					useDeepLinking:"no",
					showPreloader:"yes",
					preloaderBackgroundColor:"#000000",
					preloaderFillColor:"#FFFFFF",
					addKeyboardSupport:"yes",
					autoScale:"yes",
					showButtonsToolTip:"yes", 
					stopVideoWhenPlayComplete:"yes",
					playAfterVideoStop:"no",
					@if($psetting['autoplay'] ==1)
					autoPlay:"yes",
					@else
					autoPlay:"no",
					@endif
					loop:"yes",
					shuffle:"no",
					showErrorInfo:"yes",
					maxWidth:1410,
					maxHeight:700,
					buttonsToolTipHideDelay:1.5,
					volume:.8,
					backgroundColor:"#000000",
					videoBackgroundColor:"#000000",
					posterBackgroundColor:"#000000",
					buttonsToolTipFontColor:"#F44A4A",
					//logo settings
					@if($psetting['logo_enable'] ==1)
					showLogo:"yes",
					@else
					showLogo:"no",
					@endif
					hideLogoWithController:"yes",
					logoPosition:"topRight",
					logoLink:"{{ config('app.url') }}",
					logoMargins:10,
					//playlists/categories settings
					showPlaylistsSearchInput:"yes",
					usePlaylistsSelectBox:"yes",
					showPlaylistsButtonAndPlaylists:"yes",
					showPlaylistsByDefault:"no",
					thumbnailSelectedType:"opacity",
					startAtPlaylist:0,
					buttonsMargins:15,
					thumbnailMaxWidth:350, 
					thumbnailMaxHeight:350,
					horizontalSpaceBetweenThumbnails:40,
					verticalSpaceBetweenThumbnails:40,
					inputBackgroundColor:"#333333",
					inputColor:"#999999",
					//playlist settings
					showPlaylistButtonAndPlaylist:"yes",
					playlistPosition:"right",
					showPlaylistByDefault:"yes",
					showPlaylistName:"yes",
					showSearchInput:"yes",
					showLoopButton:"yes",
					showShuffleButton:"yes",
					showPlaylistOnFullScreen:"no",
					showNextAndPrevButtons:"yes",
					showThumbnail:"yes",
					forceDisableDownloadButtonForFolder:"yes",
					addMouseWheelSupport:"yes", 
					startAtRandomVideo:"no",
					stopAfterLastVideoHasPlayed:"no",
					addScrollOnMouseMove:"no",
					randomizePlaylist:'no',
					folderVideoLabel:"VIDEO ",
					playlistRightWidth:310,
					playlistBottomHeight:380,
					startAtVideo:0,
					maxPlaylistItems:50,
					thumbnailWidth:71,
					thumbnailHeight:71,
					spaceBetweenControllerAndPlaylist:1,
					spaceBetweenThumbnails:1,
					scrollbarOffestWidth:8,
					scollbarSpeedSensitivity:.5,
					playlistBackgroundColor:"#000000",
					playlistNameColor:"#FFFFFF",
					thumbnailNormalBackgroundColor:"#1b1b1b",
					thumbnailHoverBackgroundColor:"#313131",
					thumbnailDisabledBackgroundColor:"#272727",
					searchInputBackgroundColor:"#000000",
					searchInputColor:"#999999",
					youtubeAndFolderVideoTitleColor:"#FFFFFF",
					folderAudioSecondTitleColor:"#999999",
					youtubeOwnerColor:"#888888",
					youtubeDescriptionColor:"#888888",
					mainSelectorBackgroundSelectedColor:"#FFFFFF",
					mainSelectorTextNormalColor:"#FFFFFF",
					mainSelectorTextSelectedColor:"#000000",
					mainButtonBackgroundNormalColor:"#212021",
					mainButtonBackgroundSelectedColor:"#FFFFFF",
					mainButtonTextNormalColor:"#FFFFFF",
					mainButtonTextSelectedColor:"#000000",
					//controller settings
					showController:"yes",
					showControllerWhenVideoIsStopped:"yes",
					showNextAndPrevButtonsInController:"no",
					showRewindButton:"yes",
					showPlaybackRateButton:"yes",
					showVolumeButton:"yes",
					showTime:"yes",
					showQualityButton:"yes",
					showInfoButton:"yes",
					@if($psetting['download'] ==1)
					showDownloadButton:"yes",
					@else
					showDownloadButton:"no",
					@endif
					@if($psetting['share_enable'] ==1)
					showShareButton:"yes",
					@else
					showShareButton:"no",
					@endif
					showEmbedButton:"yes",
					showChromecastButton:"no",
					showFullScreenButton:"yes",
					disableVideoScrubber:"no",
					showScrubberWhenControllerIsHidden:"yes",
					showMainScrubberToolTipLabel:"yes",
					showDefaultControllerForVimeo:"no",
					repeatBackground:"yes",
					controllerHeight:42,
					controllerHideDelay:3,
					startSpaceBetweenButtons:7,
					spaceBetweenButtons:8,
					scrubbersOffsetWidth:2,
					mainScrubberOffestTop:14,
					timeOffsetLeftWidth:5,
					timeOffsetRightWidth:3,
					timeOffsetTop:0,
					volumeScrubberHeight:80,
					volumeScrubberOfsetHeight:12,
					timeColor:"#888888",
					youtubeQualityButtonNormalColor:"#888888",
					youtubeQualityButtonSelectedColor:"#FFFFFF",
					scrubbersToolTipLabelBackgroundColor:"#FFFFFF",
					scrubbersToolTipLabelFontColor:"#5a5a5a",
					//advertisement on pause window
					aopwTitle:"Thank you for watching",
					aopwWidth:400,
					aopwHeight:240,
					aopwBorderSize:6,
					aopwTitleColor:"#FFFFFF",
					//subtitle
					subtitlesOffLabel:"Subtitle off",
					//popup add windows
					showPopupAdsCloseButton:"yes",
					//embed window and info window
					embedAndInfoWindowCloseButtonMargins:15,
					borderColor:"#333333",
					mainLabelsColor:"#FFFFFF",
					secondaryLabelsColor:"#a1a1a1",
					shareAndEmbedTextColor:"#5a5a5a",
					inputBackgroundColor:"#000000",
					inputColor:"#FFFFFF",
					//loggin
					isLoggedIn:"yes",
					playVideoOnlyWhenLoggedIn:"yes",
					loggedInMessage:"Please login to view this video.",
					//audio visualizer
					audioVisualizerLinesColor:"#0099FF",
					audioVisualizerCircleColor:"#FFFFFF",
					//lightbox settings
					closeLightBoxWhenPlayComplete:"yes",
					lightBoxBackgroundOpacity:.6,
					lightBoxBackgroundColor:"#000000",
					//sticky on scroll
					stickyOnScroll:"no",
					stickyOnScrollShowOpener:"yes",
					stickyOnScrollWidth:"700",
					stickyOnScrollHeight:"394",
					//sticky display settings
					showOpener:"yes",
					showOpenerPlayPauseButton:"yes",
					verticalPosition:"bottom",
					horizontalPosition:"center",
					showPlayerByDefault:"yes",
					animatePlayer:"yes",
					openerAlignment:"right",
					mainBackgroundImagePath:"content/metal_skin_dark/main-background.png",
					openerEqulizerOffsetTop:-1,
					openerEqulizerOffsetLeft:3,
					offsetX:0,
					offsetY:0,
					//playback rate / speed
					defaultPlaybackRate:1, //0.25, 0.5, 1, 1.25, 1.2, 2
					//cuepoints
					executeCuepointsOnlyOnce:"no",
					//annotations
					showAnnotationsPositionTool:"no",
					//ads
					openNewPageAtTheEndOfTheAds:"no",
					playAdsOnlyOnce:"no",
					adsButtonsPosition:"left",
					skipToVideoText:"You can skip to video in: ",
					skipToVideoButtonText:"Skip Ad",
					adsTextNormalColor:"#888888",
					adsTextSelectedColor:"#FFFFFF",
					adsBorderNormalColor:"#666666",
					adsBorderSelectedColor:"#FFFFFF",
					//a to b loop
					useAToB:"yes",
					atbTimeBackgroundColor:"transparent",
					atbTimeTextColorNormal:"#888888",
					atbTimeTextColorSelected:"#FFFFFF",
					atbButtonTextNormalColor:"#888888",
					atbButtonTextSelectedColor:"#FFFFFF",
					atbButtonBackgroundNormalColor:"#FFFFFF",
					atbButtonBackgroundSelectedColor:"#000000",
					//thumbnails preview
					thumbnailsPreviewWidth:196,
					thumbnailsPreviewHeight:110,
					thumbnailsPreviewBackgroundColor:"#000000",
					thumbnailsPreviewBorderColor:"#666",
					thumbnailsPreviewLabelBackgroundColor:"#666",
					thumbnailsPreviewLabelFontColor:"#FFF",
					// context menu
					showContextmenu:'yes',
					showScriptDeveloper:"no",
					contextMenuBackgroundColor:"#1f1f1f",
					contextMenuBorderColor:"#1f1f1f",
					contextMenuSpacerColor:"#333",
					contextMenuItemNormalColor:"#888888",
					contextMenuItemSelectedColor:"#FFFFFF",
					contextMenuItemDisabledColor:"#444"
				});
				registerAPI();
			});
			
			
			var registerAPIInterval;
function registerAPI(){
clearInterval(registerAPIInterval);
if(window.player1){
// player1.addListener(FWDUVPlayer.READY, readyHandler);
// player1.addListener(FWDUVPlayer.ERROR, errorHandler);
// player1.addListener(FWDUVPlayer.PLAY, playHandler);
// player1.addListener(FWDUVPlayer.PAUSE, pauseHandler);
// player1.addListener(FWDUVPlayer.STOP, stopHandler);
// player1.addListener(FWDUVPlayer.UPDATE, updateHandler);
// player1.addListener(FWDUVPlayer.UPDATE_TIME, updateTimeHandler);
// player1.addListener(FWDUVPlayer.UPDATE_VIDEO_SOURCE, updateVideoSourceHandler);
// player1.addListener(FWDUVPlayer.UPDATE_POSTER_SOURCE, updatePosterSourceHandler);
// player1.addListener(FWDUVPlayer.START_TO_LOAD_PLAYLIST, startToLoadPlaylistHandler);
// player1.addListener(FWDUVPlayer.LOAD_PLAYLIST_COMPLETE, loadPlaylistCompleteHandler);


player1.addListener(FWDUVPlayer.PLAY_COMPLETE, playCompleteHandler);
}else{
registerAPIInterval = setInterval(registerAPI, 100);
}
};



function playCompleteHandler(e){
console.log("API -- play complete");

}



function play(){
   
player1.play();

}

function showCategories(){
player1.showCategories();
}
function pause(){
player1.pause();
}

function stop(){
player1.stop();
}

// function gohome(){
    // var course_id="{{$courses->id}}";
    //  $(".iframe").css({"display": 'none'});
    //  $(".iframe").colorbox({

    //             href: 'https://nihaws.com',

    //             close: "Close",

    //             overlayClose: true,

    //             onComplete: function () {

    //                 alert("Completed");

    //             },
    //             onClosed: function () {

    //                 alert("Closed");

    //             }

    //         });
   
   
// }
 $(document).ready(function(){
$("#gohome").click(function() {

//   alert('kjd');
  gohome();
});
});

function gohome() {

 parent.$.colorbox.close();
}
		</script>
		
	</head>


	<body class="player-course-chapter">
	  
	   
	    
	     	<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalplayer" data-add-popup="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
	    
		<div id="myDiv" class="player-course-chapter-list"></div>
		
		

<!--<ul id="playlists" style="display:none;">-->
<!--<li data-source="playlist1" data-playlist-name="MY HTML PLAYLIST 1" data-javascript-call="play()" data-thumbnail-path="content/thumbnails/p-html.jpg">-->
   
<!--<p class="fwduvp-categories-title"><span class="fwduvp-header">Title courses:</span><span class="fwduvp-title">My HTML playlist 1 hvj</span></p>-->
<!--<p class="fwduvp-categories-type"><span class="fwduvp-header">Type: </span>HTML</p>-->
<!--<p class="fwduvp-categories-description"><span class="fwduvp-header">Description: </span>Created using <strong>HTML markup</strong>, all format are supported and it can have mixed video formats.</p>-->
<!--</li>-->


<!--</ul>-->
	        
		<!--  Playlists -->
		<ul id="courseplaylist" class="display-none" style="display:none;">
		    
		    	
	       
		
				<li data-source="courseplaycontent" data-playlist-name="{{$courses->title}}" data-thumbnail-path="{{ url('images/course/'.$courses->preview_image) }}">
					<p class="minimalDarkCategoriesTitle"><span class="">Title: </span>{{$courses->title}}</p>
									<p class="minimalDarkCategoriesType"><span class="">Category: </span>{{$courses->category->title}}</p>
					<p class="minimalDarkCategoriesDescription"><span class="">Description: </span>{{$courses->short_detail}}</p>
				</li>
				
	       
		</ul>
			<ul id="courseplaycontent" class="display-none" style="display:none;">
			
					
					@php
					
							$url = url('video/preview/'.$courses['video']);
						

					@endphp
					
  					@php

  						$pauseads = App\Ads::where('ad_location','=','onpause')->get();
						$pausead =  App\Ads::inRandomOrder()->where('ad_location','=','onpause')->first();
			        
						$endtime='0';
						$user_id=Auth::user()->id;
						
						$movie_id = $courses->id;

					$checkmovie=Session::get('time_'.$movie_id) ;
						if (!is_null($checkmovie)) {
							$mid=$checkmovie['movie'];
				      	if ($mid==$movie_id) {
				      	$endtime=$checkmovie['endtime'];
				      	}
				      	else{
				      		$endtime='00:00:00';
				      	}
						}
						else{
							$endtime='00:00:00';
						}
					
					@endphp


				
						<li
						@if($pauseads->count()>0)
							data-advertisement-on-pause-source="{{ asset('adv_upload/image/'.$pausead->ad_image)}}" 
						@endif 
						@if($courses['preview_image'] !== NULL && $courses['preview_image'] !== '') 
							data-thumb-source="{{ url('images/course/'.$courses->preview_image) }}"
						@else
							data-thumb-source="{{ Avatar::create($courses->title)->toBase64() }}"
						@endif 

							data-video-source="{{ $url }}"

							data-start-at-time="{{date('H:i:s',strtotime($endtime))}}"
						
						@if($courses['preview_image'] !== NULL && $courses['preview_image'] !== '') 
						    data-poster-source="{{ url('images/course/'.$courses->preview_image) }}" 
						@else
							data-poster-source="{{ Avatar::create($courses->title)->toBase64() }}"  
						@endif

						     data-start-at-subtitle="1" data-downloadable="yes" data-click-source="player1.play();" data-redirect-url=""> 
					  		@php
								$skipads = App\Ads::where('ad_location','=', 'skip')->get();
								$skipad = App\Ads::inRandomOrder()->where('ad_location','=','skip')->first();

							@endphp
								@if($skipads->count()>0)
								<ul data-ads="">
									<li @if($skipad->ad_video !="no")

									data-source="{{ asset('adv_upload/video/'.$skipad->ad_video) }}" 
									@else
									data-source="{{ $skipad->ad_url }}" @endif data-time-start="{{ $skipad->time }}" data-time-to-hold-ads="{{ $skipad->ad_hold }}" data-thumbnail-source="{{asset('images/course/'.$chapter->courses->preview_image)}}" data-link="{{ $skipad->ad_target }}" data-target="_blank"></li>
									
								</ul>
								@endif
 
							    <div data-video-short-description="" >
							    	 <p class="minimalDarkCategoriesTitle"><span class="minimialDarkBold">Title:{{$courses->title}}</span></p>
				        			 <p class="minimalDarkCategoriesDescription"><span class="minimialDarkBold">Description: {{$courses->short_detail}}</span></p>
							    </div>
			
  
							    @php
								$popupads = App\Ads::where('ad_location','=', 'popup')->get();
								$popupad = App\Ads::inRandomOrder()->where('ad_location','=','popup')->first();	
								@endphp

								@if($popupads->count()>0)
								<div data-add-popup="">
									<p data-image-path="{{ asset('adv_upload/image/'.$popupad->ad_image) }}" data-time-start="{{ $popupad->time }}" data-time-end="{{ $popupad->endtime }}" data-link="{{ $popupad->ad_target }}" data-target="_blank"></p>
								</div>
								@endif
						</li>
					
			</ul>
			
			
		    <div style="max-width:960px; text-align:center; margin:auto;padding:15px;">
<button type="button" onclick="play()" class="btn-success btn-lg"><i class="fa fa-play"></i> Play</button>
<!--<button type="button" onclick="playNext()">play next</button>-->
<!--<button type="button" onclick="playPrev()">play prev</button>-->
<!--<button type="button" onclick="playShuffle()">play shuffle</button>-->
<!--<button type="button" onclick="playVideo(1)">play video 1</button>-->
<button type="button" onclick="pause()" class="btn-warning btn-lg"><i class="fa fa-pause"></i> Pause</button>
<button type="button" onclick="stop()" class="btn-danger btn-lg"><i class="fa fa-stop"></i> Stop</button>
<button class="btn-info btn-lg" type="button" id="gohome"><i class="fa fa-home"></i> Go To Course</button>
<!--<button type="button" onclick="scrub(.5)">scrub to half</button>-->
<!--<button type="button" onclick="setVolume(.5)">set volume to half</button>-->
<!--<button type="button" onclick="share()">open share window</button>-->
<!--<button type="button" onclick="download()">download video</button>-->
<!--<button type="button" onclick="showCategories()">show categories</button>-->
<!--<button type="button" onclick="goFullScreen()">go full screen</button>-->
<!--<button type="button" onclick="loadPlaylist(0)">load HTML playlist</button>-->
<!--<button type="button" onclick="loadPlaylist(1)">load Youtube playlist</button>-->
<!--<button type="button" onclick="loadPlaylist(2)">load mixed (youtube and mp4) playlist</button>-->
<!--<button type="button" onclick="loadPlaylist(3)">load XML playlist</button>-->
<!--<button type="button" onclick="loadPlaylist(4)">load Vimeo playlist</button>-->
<!--<button type="button" onclick="loadPlaylist(5)">load from folder playlist</button>-->
<!--<button type="button" onclick="window[&#39;player1&#39;].showLightbox()">open lightbox</button>-->
</div>   
                   
	
	</body>
</html>




