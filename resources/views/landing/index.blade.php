<!doctype html>

<html lang="en">





<head>

	<title>Nihaws</title>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="author" content="Webestica.com">

	<meta name="description" content="Creative Multipurpose Bootstrap Template">

	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<!-- Favicon -->

	<link rel="shortcut icon" href="assets/images">



	<!-- Google Font -->

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900%7CPlayfair+Display:400,400i,700,700i%7CRoboto:400,400i,500,700" rel="stylesheet">



	<!-- Plugins CSS -->

	<link rel="stylesheet" type="text/css" href="{{asset('landing/assets/vendor/font-awesome/css/all.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('landing/assets/vendor/themify-icons/css/themify-icons.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('landing/assets/vendor/animate/animate.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('landing/assets/vendor/glightbox/css/glightbox.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('landing/assets/vendor/tiny-slider/tiny-slider.css')}}">
	
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>



	<!-- Theme CSS -->

	<link rel="stylesheet" type="text/css" href="{{asset('landing/assets/css/style.css')}}" />

	<style>

		.icon-bar {

  position: fixed;

  top: 62%;

  -webkit-transform: translateY(-50%);

  -ms-transform: translateY(-50%);

  transform: translateY(-50%);

  z-index:111;

}



.icon-bar a {

  display: block;

  text-align: center;

  padding: 12px;

  transition: all 0.3s ease;

  color: white;

  font-size: 13px;

}



.icon-bar a:hover {

  background-color: #000;

}



.facebook {

  background: #3B5998;

  color: white;

}



.twitter {

  background: #55ACEE;

  color: white;

}



.google {

  background: #272262;

  color: white;

}



.error{background-color: #FF6600;
	color: #FFFFFF;
}
.success{color: #12CC1A;}
.demoInputBox{padding:10px; border-radius:4px;}
.info{font-size:13px;color: #FF6600;letter-spacing:2px;padding-left:5px;display:block;}

			

	</style>



</head>



<body>



	<div class="icon-bar">

  <a href="https://www.facebook.com/learningnihaws/" class="facebook"><i class="fab fa-facebook"></i></a> 

  <a href="https://www.instagram.com/nihaws/" class="twitter"><i class="fab fa-instagram"></i></a> 

  <a href="https://nihaws.com/" class="google"><i class="fa fa-globe"></i></a> 

  

</div>

	<div class="sticky-container">

  <div class="button-container">

    <a href="#" class="d-block d-lg-none" data-bs-toggle="modal" data-bs-target="#exampleModal" ><img src="{{asset('landing/assets/images/button.png')}}" /></a>

  </div>

</div>



	<!-- =======================

	header Start-->

	<header class="header-static navbar-sticky navbar-light">

		<!-- Search -->

		

		<!-- End Search -->



		<!-- Navbar top start-->

		<!-- Navbar top End-->



		<!-- Logo Nav Start -->

		<nav class="navbar navbar-expand-lg">

			<div class="container">

				<!-- Logo -->

				<a class="navbar-brand" href="index.html">

					<!-- Logo -->

					<img class="navbar-brand-item" src="{{asset('landing/assets/images/logo_1625129576nihaws.png')}}" alt="Logo">

				</a>

				<!-- Menu opener button -->

				<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">

					<span class="navbar-toggler-icon"></span>

				</button>

				<!-- Main Menu Start -->

				<div class="collapse navbar-collapse" id="navbarCollapse">

				

				</div>

				<!-- Main Menu End -->

				<!-- Header Extras Start-->

				<div class="navbar-nav">

					<!-- extra item Search-->

					<div class="nav-item search border-0 ps-3 pe-0 px-lg-2" id="search">

						

					</div>

					<!-- extra item Btn-->

					<div class="nav-item border-0 d-none d-lg-inline-block align-self-center">
						<a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class=" btn btn-bg btn-grad text-white mb-0" style="font-size: 20px;"> 
							Enquire Now 
						
						</a>

						<a href="tel:9500186186" class=" btn btn-bg btn-grad text-white mb-0" style="font-size: 20px;"><i class="fab fa-whatsapp"> </i> <i class="fa fa-phone-square" aria-hidden="true"></i> 9500186186</a>

					</div>

				</div>

				<!-- Header Extras End-->

			</div>

		</nav>

		<!-- Logo Nav End -->

	</header>

	<!-- =======================

	header End-->



	<!-- =======================

	Main Banner -->

	<section class="p-0">

		<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">

  <div class="carousel-indicators">

    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>

    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>

    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>

  </div>

  <div class="carousel-inner">

    <div class="carousel-item active">

		<img src="{{asset('landing/assets/images/slider/Nihaws-banner-1.webp')}}" class="d-block w-100" alt="...">
  
	  </div>
  
	  <div class="carousel-item">
  
		 <img src="{{asset('landing/assets/images/slider/lealanding-image-06.webp')}}" class="d-block w-100" alt="...">
  
	  </div>

	  <div class="carousel-item">
  
		<img src="{{asset('landing/assets/images/slider/lealanding-image-07.webp')}}" class="d-block w-100" alt="...">
 
	 </div>


	 <div class="carousel-item">
  
		<img src="{{asset('landing/assets/images/slider/lealanding-image-08.webp')}}" class="d-block w-100" alt="...">
 
	 </div>


  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">

    <span class="carousel-control-prev-icon" aria-hidden="true"></span>

    <span class="visually-hidden">Previous</span>

  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">

    <span class="carousel-control-next-icon" aria-hidden="true"></span>

    <span class="visually-hidden">Next</span>

  </button>

</div>

	</section>

	<!-- =======================

	Main banner -->



	<!-- =======================

	about us  -->

	<section>

		<div class="container">

			<div class="row justify-content-between align-items-center">

				<div class="title text-center">

					

						<!-- <h2> Join the best aesthetic medicine and cosmetology <br> training institute -->
                       <h2>
							JOIN THE NO.1  AESTHETIC MEDICINE TRAINING INSTITUTE


                         </h2>

						

					</div>

					<!-- left -->

					<!--<div class="col-md-6">

						<div class="row mt-4 mt-md-0">

							<div class="col-5 offset-1 px-2 mb-3 align-self-end">

								<img class="rounded aos" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" data-aos-easing="ease-in-out" src="{{asset('landing/assets/images/1635147237beautiful-girl-face-perfect-skin.jpg')}}" alt="">

							</div>

							<div class="col-6 px-2 mb-3">

								<img class="rounded aos" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000" src="{{asset('landing/assets/images/1626761147trichology.jpg')}}" alt="">

							</div>

							<div class="col-7 px-2 mb-3">

								<img class="rounded aos" data-aos="fade-right" data-aos-delay="200" data-aos-duration="1000" src="{{asset('landing/assets/images/1645698106shutterstock_611403038.jpg')}}" alt="">

								

							</div>

							<div class="col-5 align-self-start ps-2 mb-3">

								<img class="rounded aos" data-aos="fade-down" data-aos-delay="300" data-aos-duration="1500" src="{{asset('landing/assets/images/1645761951weight-loss-scale-with-centimeter-stethoscope-dumbbell-clipboard-pen-diet-concept.jpg')}}" alt="">

							</div>

						</div>

					</div>-->

				<!-- right -->

				<div class="col-md-12 ps-lg-5 text-center">

					

					<p class="lead text-center">
						
						<!-- NIHAWS provides a wide range of courses for health and wellness professionals, paramedical and medical graduates, and others who wish to improve their skills and progress in their careers -->
						We pride ourselves of being industry leaders in bringing medical delegates and Medical experts together. Our years of experience in providing training, seminars, events and medical conferences have enriched the lives and medical practice of hundreds of medical practitioners in their field.

                       
					</p>

					<div>

						

						<button type="button" class="btn btn-grad" data-bs-toggle="modal" data-bs-target="#exampleModal">

						Contact Us

					</button>

					

					</div>

				</div>

			</div>

		</div>

	</section>



	<section class="bg-light bg-grad1 pattern-overlay-1">



		<div class="container">

			<div class="row">

				<div class="col-12 col-lg-8 mx-auto">

					<div class="title text-center text-white">

						<h2 >Testimonials</h2>

						

					</div>

				</div>

			</div>



			<div class="row">

				<div class="col-md-12">

					<div class="tiny-slider arrow-dark arrow-hover">

						<div class="tiny-slider-inner" data-arrow="true" data-dots="false"  data-items-xl="3" data-items-lg="3" data-items-md="2" data-items-sm="2" data-items-xs="1" data-autoplay="4500">

							<!-- post -->

							<div class="item">

								<div class="post">

							<i class="fa fa-quote-left" aria-hidden="true"></i>

									<div class="post-info">



										

										<p class="mb-3">Hands-on experience was provided. Live demonstration was great.  Friendly staff. Overall a great experience. 

</p>

										<div class="post-author text-black">Dr. Divya (MD Dermatology)</div>,

										<div class="">Bangalore</div>

									</div>



								</div>

							</div>

							<div class="item">

								<div class="post">

									<i class="fa fa-quote-left" aria-hidden="true"></i>

									<div class="post-info">



										<p class="mb-3">The topics covered ranged from fundamental to advanced. Diploma in  medical aesthetics course is  the one for professionals interested in modern aesthetics. All of the tutors who taken part in this training deserve a thumbs up.



</p>

										<div class="post-author text-black">Dr. Rahul Krishna (MBBS, DNB) </div>,

										<div class="">Chennai</div>

									</div>

								</div>

							</div>

							<!-- post -->

							<div class="item">

								<div class="post">

<i class="fa fa-quote-left" aria-hidden="true"></i>

									<div class="post-info">

										

										<p class="mb-3">Trainers have worked incredibly hard to create this spectacular course. Great experience. I will undoubtedly register upcoming courses in the future.



</p>

										<div class="post-author text-black">Preethi (MDS) </div>,

										<div class="">Hyderabad</div>

									</div>

								</div>

							</div>

							<!-- post -->

							<div class="item">

								<div class="post">

								<i class="fa fa-quote-left" aria-hidden="true"></i>

									<div class="post-info">

																			<p class="mb-3">Hands-on experience was provided for the majority of laser procedures, which is not provided in many academies. This course will benefit greatly in my career. Thank you to the doctors and trainers who addressed my concerns and provided me this opportunity. Overall, I was really pleased with the course.



</p>

										<div class="post-author text-black">Dr. Ahmed Meeran (BDS) </div>,

										<div class="">Andaman</div>

									</div>

								</div>

							</div>



							<div class="item">

								<div class="post">

								<i class="fa fa-quote-left" aria-hidden="true"></i>

									<div class="post-info">

																			<p class="mb-3">I highly recommend NIHAWS academy for modern aesthetics learning. The trainers were fantastic. I've attended training sessions where they exhibit PowerPoint slides, images, and videos but never teach in person. Trust me, they have all of the latest equipment to teach each of the aesthetic courses.





</p>

										<div class="post-author text-black">Dr. Kavitha (MBBS) </div>,

										<div class="">Madurai</div>

									</div>

								</div>

							</div>

						</div>

					</div>



					

			

				</div>

			</div>

		</div>

	

    <!-- END OF TESTIMONIALS -->

	</section>

	<!-- =======================

	about us  -->



	<!-- =======================

	why-us -->

<section class="py-5 mb-5">

		<div class="container">

			<div class="row ">

				<div class="title text-center">

					

						<h2>Accreditation

</h2>

						

					</div>

				<div class="col-md-4  text-center zoom">

					<a href="https://www.the-cma.org.uk/Colleges/National-Institute-of-Health-and-Wellness-2137/"><img src="{{asset('landing/assets/images/icons/cma.jpg')}}"></a>

					

				</div>

				<div class="col-md-4  text-center zoom">

					<a href="https://cpduk.co.uk/providers/national-institute-of-health-and-wellness"><img src="{{asset('landing/assets/images/icons/CPDmember.jpg')}}"></a>

					

				</div>

				<div class="col-md-4   zoom">

					<img src="{{asset('landing/assets/images/icons/IAHAW.jpg')}}">

					

					



					

				</div>

			</div>

		</div>

	</section>



	<!-- why-us

	=======================  -->

<section class="portfolio portfolio-style-2 bg-light">

		<div class="container">

			<div class="title text-center">

					

						<h2>Gallery



</h2>

						

					</div>

			<div class="row">

				<div class="col-md-12 p-0">

					<div class="portfolio-wrap grid items-5 items-padding filter-container" data-isotope="{ &quot;layoutMode&quot;: &quot;masonry&quot; }" style="position: relative; height: 489.564px;">

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital" style="position: absolute; left: 0px; top: 0px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/1.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/1.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item photo" style="position: absolute; left: 234.797px; top: 0px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/2.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/2.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital marketing" style="position: absolute; left: 469.594px; top: 0px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/3.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/3.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

																	</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital" style="position: absolute; left: 704.391px; top: 0px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/4.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/4.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item photo" style="position: absolute; left: 939.188px; top: 0px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/5.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/5.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital marketing photo" style="position: absolute; left: 0px; top: 163.188px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/6.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/6.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item photo marketing" style="position: absolute; left: 234.797px; top: 163.188px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/7.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/7.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

								

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital marketing" style="position: absolute; left: 469.594px; top: 163.188px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/8.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/8.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

																	</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital marketing" style="position: absolute; left: 704.391px; top: 163.188px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/9.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/9.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

																	</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item marketing" style="position: absolute; left: 939.188px; top: 163.188px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/10.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/10.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

								

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital" style="position: absolute; left: 0px; top: 326.376px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/11.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/11.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item photo" style="position: absolute; left: 234.797px; top: 326.376px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/12.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/12.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

								

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item digital marketing" style="position: absolute; left: 469.594px; top: 326.376px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/13.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/13.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

						<div class="portfolio-card grid-item photo" style="position: absolute; left: 704.391px; top: 326.376px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/14.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/14.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

						<!-- portfolio-card -->

							<!-- portfolio-card -->

						<div class="portfolio-card grid-item photo" style="position: absolute; left: 234.797px; top: 0px;">

							<div class="portfolio-card-body">

								<div class="portfolio-card-header">

									<img src="{{asset('landing/assets/images/portfolio/2.jpg')}}" alt="">

								</div>

								<div class="portfolio-card-footer">

									<a class="full-screen" href="{{asset('landing/assets/images/portfolio/2.jpg')}}" data-glightbox="" data-gallery="portfolio"><i class="ti-fullscreen"></i></a>

									

								</div>

							</div>

						</div>

							<!-- portfolio-card -->

						

						<!-- portfolio-card -->

							<!-- portfolio-card -->

						

						<!-- portfolio-card -->

							<!-- portfolio-card -->

						

						<!-- portfolio-card -->

					

					</div>

					<!-- portfolio wrap -->

				</div>

			</div>

		</div>

	</section>

	<!-- =======================

	service -->



	<!-- =======================

	service -->



	<!-- =======================

	action box -->

	





<section class="py-5">

		<div class="container">

			<div class="row ">

	<div class="col-md-10 col-lg-6 mx-md-auto align-self-center mt-4 mt-lg-0 position-relative">

								<img class="rounded" src="{{asset('landing/assets/images/youtube1.jpg')}}" alt="">

								<div class="position-absolute start-0 bottom-0 ms-4 ms-md-0 ms-md-n2 mb-3">

									<a class="btn btn-grad" data-glightbox="" href="https://youtu.be/zOFkU-DVmGw"> <i class="fa fa-play text-white"></i>Play Video </a>

								</div>

							</div>





							<div class="col-md-10 col-lg-6 mx-md-auto align-self-center mt-4 mt-lg-0 position-relative">

								<img class="rounded" src="{{asset('landing/assets/images/youtube2.jpg')}}" alt="">

								<div class="position-absolute start-0 bottom-0 ms-4 ms-md-0 ms-md-n2 mb-3">

									<a class="btn btn-grad" data-glightbox="" href="https://youtu.be/88kJRgYluH4

"> <i class="fa fa-play text-white"></i>Play Video </a>

								</div>

							</div></div></div></section>

	<!-- =======================

	action box -->



	<!-- =======================

	portfolio -->



	<!-- =======================

	portfolio -->



	<!-- =======================

	package -->



	<!-- =======================

	package -->



	<!-- =======================

	client -->



	<!-- =======================

	client -->



	<!-- =======================

	Testimonials -->

	<!-- =======================

	Testimonials -->



	<!-- =======================

	blog -->

	

	<!-- =======================

	blog -->



	<!-- =======================

	call to action-->

	<!--<section class="p5-4">

		<div class="container">

			<div class="d-block d-md-flex bg-grad p-4 p-sm-5 all-text-white rounded pattern-overlay-3">

				<div class="align-self-center text-center text-md-start">

					<h3>Learn from one of the best aesthetic medicine international <br>training academy in the world</h3>

					

				</div>

				<div class="mt-3 mt-md-0 text-center text-md-end ms-md-auto align-self-center">

											<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">

						Contact Us

					</button>

				</div>

			</div>

		</div>

	</section>-->

	<!-- =======================

	call to action-->



	<!-- =======================

	footer  -->

	<footer class="footer bg-light">



		<div class="footer-content pb-3 py-5">

			<div class="container">



				<div class="row g-4">

				<div class="col-md-4">

					<div class="contact-box d-flex flex-column h-100  px-3 py-4">

						<!-- Phone -->

						<div class=" mb-2">

							<div class="fs-4"><i class="ti-map-alt"></i></div>

							<h5 class="mb-2">Address</h5>

							<!-- <p>
								
								Prince Info Park, B Block,<br> 1st floor, # 81B, 2nd Main Road,<br> Ambattur, Chennai - 600 058.

</p> -->

<p>
	Block, 1st floor, Prince Info Park, B, 81B,<br> 2nd Main Rd, Sai Nagar, Ambattur,<br> Chennai, Tamil Nadu 600058
</p>

						</div>

						<!-- Email -->

						<div class=" mb-2">

							<div class="fs-4"><i class="ti-email"></i></div>

							<h5 class="mb-2">E-mail</h5>

							<p><a href="mailto:info@nihaws.com">info@nihaws.com</a>

</p>

						</div>

						<!-- Phone -->

						<div class="">

							<div class="fs-4"><i class="ti-panel"></i></div>

							<h5 class="mb-2">Phone</h5>

							<p class="mb-0">  <a href="tel:9500186186">9500186186</a></p>

						</div>

						<div class="mt-4">



						<ul class="social-icons si-colored-bg-on-hover light">

							<li class="social-icons-item social-facebook">

								<a class="social-icons-link" href="https://www.facebook.com/learningnihaws/)"><i class="fab fa-facebook-f"></i></a>

							</li>

							<li class="social-icons-item social-instagram">

								<a class="social-icons-link" href="https://www.instagram.com/nihaws/"><i class="fab fa-instagram"></i></a>

							</li>

							

							<li class="social-icons-item social-youtube">

								<a class="social-icons-link" href="https://nihaws.com/"><i class="fas fa-globe"></i></a>

							</li>



						</ul>

					</div>

					</div>

				</div>

				<!-- google map -->

				<div class="col-md-8">

					<div class="h-100">

						<!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7773.638860224552!2d80.24227!3d13.047163!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a52665aa6c9d50b%3A0x5a0aa0f0bb17547a!2s15%2C%20New%20Giri%20Rd%2C%20Satyamurthy%20Nagar%2C%20T.%20Nagar%2C%20Chennai%2C%20Tamil%20Nadu%20600017!5e0!3m2!1sen!2sin!4v1661584578706!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
						
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.057637493847!2d80.1697672!3d13.0955337!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267d4463a2ccd%3A0xde415ed07c1663da!2sNIHAWS%20-%20National%20Institute%20Of%20Health%20And%20Wellness!5e0!3m2!1sen!2sin!4v1669787651502!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
					</div>

				</div>

				<!-- contact form -->

				

			</div>

			</div></div>

					<div class="divider mt-3"></div>

	

	

		<!--footer copyright -->

		<div class="footer-copyright py-3">

			<div class="container">

				<div class="d-md-flex justify-content-between align-items-center py-3 text-center text-md-start">

					<!-- copyright text -->

					<div class="copyright-text">©2022 All Rights Reserved by NIHAWS</div>

					<!-- copyright links-->

					<div class="copyright-links primary-hover mt-3 mt-md-0">

						<ul class="list-inline">

							

							<li class="list-inline-item ps-2"><a class="list-group-item-action" href="#">Privacy Policy</a></li>

							<li class="list-inline-item ps-2"><a class="list-group-item-action pe-0" href="#">Use of terms</a></li>

						</ul>

					</div>

				</div>

			</div>

		</div>

	</footer>

	<!-- =======================

	footer  -->



	<!-- Back to top -->

	<!--<div> <a href="#" class="back-top btn btn-grad"><i class="ti-angle-up"></i></a> </div>-->



	<!-- Bootstrap JS -->

	<script src="{{asset('landing/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>



	<!--Vendors-->

	<script src="{{asset('landing/assets/vendor/aos/aos.js')}}"></script>

	<script src="{{asset('landing/assets/vendor/glightbox/js/glightbox.js')}}"></script>

	<script src="{{asset('landing/assets/vendor/tiny-slider/tiny-slider.js')}}"></script>



	<!--Template Functions-->

	<script src="{{asset('landing/assets/js/functions.js')}}"></script>

		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

						<div class="modal-dialog">

							<div class="modal-content">

								<div class="modal-header">

									<h5 class="modal-title" id="exampleModalLabel">QUICK ENQUIRY</h5>

									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

								</div>

								<div class="modal-body">
									<form id="myform">

										<span id="error" class="info"></span>
										<span id="mail-status" class="success"></span>

									<div class="form-group">
										<span id="Name-info" class="info"></span>
										<input class="form-control demoInputBox" type="text" id="name" name="name" placeholder="Enter the Name" value="">
										<div class="alert alert-danger alert-name">
                                                </div>
									</div>

									<div class="form-group">
										<span id="Email-info" class="info"></span>	
										<input class="form-control demoInputBox" type="text" id="email" name="email" placeholder="Enter your Email Id" value="">
										<div class="alert alert-danger alert-email">
                                                </div>
									</div>
		                            
									<div class="form-group">
										<span id="Phone-info" class="info"></span>
										<input class="form-control demoInputBox" type="text" name="phone" id="phone" placeholder="Enter your Phone Number" value="">
										<div class="alert alert-danger alert-phone">
                                                </div>
									</div>


                     
					<div class="form-group">

						<label>Select Qualification</label>
						<span id="Qualification-info" class="info"> </span>

						<select class="form-select" name="qualification" id="qualification"  aria-label="Default select example">

							<option value="0" selected="selected">----</option>
							<option value="MBBS">MBBS </option>
							<option value="MD/MS">MD/MS </option>
							<option value="BDS">BDS </option>
							<option value="BAMS">BAMS</option> 
							<option value="BUMS">BUMS </option>
							<option value="BHMS">BHMS</option> 
							<option value="BPT">BPT </option>
							<option value="BSC">BSC Nursing </option>
							<option value="Others">Others </option>
							
						</select>
						<div class="alert alert-danger alert-qualification">
                                                </div>
					</div>



					<!-- Location -->

					<div class="form-group">
					    <span id="Location-info" class="info"></span>
						<input class="form-control demoInputBox" type="text" placeholder="Enter your location" id="location" name="location" value="">
						<div class="alert alert-danger alert-location">
                                                </div>
					</div>


					<!-- size -->

					

                    <div class="form-group">

						<label>Select Course</label>

						<select class="form-select" name="course" id="course" aria-label="Default select example">
							<option selected value="">----</option>
							<option value="Diploma in MedicalAesthetics">Diploma in Medical Aesthetics	</option>
							<option value="Diploma in Aesthetics">Diploma in Aesthetics</option>
							<!-- <option value="Certification in Platelet Rich Plasma">Certification in Platelet Rich Plasma </option> -->
							<option value="Certification in Platelet Rich Plasma">Certification in Mesotherapy</option>
							<option value="Certification in Chemical Skin Peel">Certification in Chemical Skin Peel</option>
							<option value="Certification in Skin Whitening">Certification in Skin Whitening</option>
							<!-- <option value="Certification in Botox & Fillers">Certification in Botox & Fillers</option> -->
							<option value="Certification in Microneedling">Certification in Microneedling</option>
							<option value="Certification in Microblading">Certification in Microblading</option>
							<option value="Certification in Scalp Micropigmentation (SMP)">Certification in Scalp Micropigmentation (SMP)</option>
							<option value="Certification in Lip Micropigmentation">Certification in Lip Micropigmentation</option>
							<option value="Certification in Trichology">Certification in Trichology</option>
							<option value="Certification in Aromatherapy">Certification in Aromatherapy</option>
							<option value="Certification in Hair Mineral Analysis">Certification in Hair Mineral Analysis</option>
							<option value="Certification in Naturopathy">Certification in Naturopathy</option>
							<option value="Certification in Medi Facials">Certification in Medi Facials</option>
							<option value="Certification in Laser">Certification in Laser</option>
							<!-- <option value="Certification in NOn Surgical Treaments(RF, HIFU etc.,)">Certification in Non Surgical Treatments (RF, HIFU etc.,)</option> -->
							<option value="other Courses">Other Courses</option>
						</select>
<div class="alert alert-danger alert-course">
                                                </div>
					</div>

					<!-- Textarea -->

					<div class="form-group">
						
						<textarea class="form-control" rows="2" id="comment" name="comment" placeholder="Query"></textarea>
						<div class="alert alert-danger alert-comment">
                                                </div>
					</div>
					<center><button type="submit" id="submitBtn" name="submitBtn"   class="btn btn-dark submitBtn"><i class="fa fa-spinner fa-spin button-loader"></i>Submit </button> </center>


					



								</div>

						
							</div>

						</div>

					</div>



					<!-- GetButton.io widget -->

<script type="text/javascript">

    (function () {
        var options = {
            whatsapp: "+919500186186", // WhatsApp number
            call_to_action: "Message us", // Call to action
            button_color: "#FF6550", // Color of button
           position: "left", // Position may be 'right' or 'left'
        };

       var proto = 'https:',host = "getbutton.io", url = proto + '//static.' + host;
       var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
       s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
       var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();

</script>

<!-- /GetButton.io widget -->
<!--<script src="{{asset('landing/assets/vendor/imagesLoaded/imagesloaded.js')}}"></script> -->
	<script src="{{asset('landing/assets/vendor/glightbox/js/glightbox.js')}}"></script>
 <script type="text/javascript">
  //  	"use strict";
	  $(document).ready(function (e) {
		  
	  $(".button-loader").css("display","none");
	  $("#myform").on('submit',function () 
	  {
		  event.preventDefault();
	   $('#mail-status').removeClass();
	   $('#mail-status').html('');
		
			var formdata = {
				 name:$("#name").val(),
				 email:$("#email").val(),
				 phone : $("#phone").val(),
				 location:$("#location").val(),
						 qualification:$("#qualification").val(),
						 course:$("#course").val(),
						 comment:$("#comment").val(),
				
			};
		   $.ajax({
		   url: "{{route('enquire')}}",
		   data:formdata,
		   headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
		   dataType:'json',
			type: "POST",
			
			success:function(data){
				if(data.status == true){
					$("#mail-status").html(data.message);
				} else {
					$("#error").html(data.message);
				}
				//console.log(data);
				//$("#mail-status").html("Email Sent Successfully!!!!");
				$('#myform').trigger("reset");
				window.location.href="{{route('tq')}}";
			},
			 error:function (data){
				 var errors =  data.responseJSON.errors;
            //console.log(errors);
            $.each(errors,function(k,v){
                $(".alert-"+k).css("display","block");
                $(".alert-"+k).html(v);
                $("#"+k).css("border","1px solid red");
            });
			 },
			beforeSend:function(){
				$(".button-loader").css("display","inline-block");
				 $("#error").html("");
				$("#Qualification-info").html("");
				$("#Name-info").html("");
				$("#Email-info").html("");
				$("#Phone-info").html("");
				$("#Location-info").html("");
				 $(".alert").css("display","none");
            $("#myform").each(function(){
                $(this).find(':input').css("border","");
            });
            $(".btnSubmit").val("Please wait...");
            $(".btnSubmit").prop("type", "disabled");
			},
			complete:function(){
				$(".button-loader").css("display","none");
			}
			});
		
		//event.preventDefault();
		return false;
	   });
	 }); 
	 
	 </script>
	 <script src="https://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
	



<script src="{{asset('landing/assets/vendor/isotope/isotope.pkgd.min.js')}}"></script>

	<script src="{{asset('landing/assets/vendor/imagesLoaded/imagesloaded.js')}}"></script>

	<script src="{{asset('landing/assets/vendor/glightbox/js/glightbox.js')}}"></script>
 <style>
        .alert {
            display: none;
            margin-top: -20px;
            font-size: 11px;
            color: #FF0000;
            padding: 2px 3px;
        }

        .alert-danger {
            background: none;
            border-color: #fff;
        }
    </style>




		



	<!--Template Functions-->

	

	

		

		

	

</body>





</html>