@extends('app')
@section('content')
<style>
section#content {
    background: #65a1c3;
}
.box-3{
margin-top: 20px;
}
.box-img{
	width: 100%
}
.main-lorem{
padding: 0px 0px 50px 20px;
background-color: #65A1C3;
}
.lorem-h2{
font-size: 42px;
color: #fff;
margin: 0px 0px 0px 0px;
padding: 0px 0px;
font-weight: 200;
text-align: center;
}
.lorem-p{
font-size: 20px;
color: #fff;
margin: 0px 3px 0px 3px;
padding: 5px 20px 5px 20px;
font-weight: 200;
text-align: center;
}
.box-padding{
padding: 0px 0px 0px 0px;
margin: 20px 0px 0px 0px;
}
.main-box{
display: flex;
background: white;
padding: 20px 0px 0px 0px;
margin: 20px 20px 20px 0px;
}
.text-padding{
padding: 6px 25px 16px 25px;
}
.main-visit{
text-align: center;
margin: 10px 0px 0px 0px;
}
.visit-icon{
font-size: 60px;
padding: 55px 10px 40px 30px;
}
.visit-button{
display: inline-block;
background: #f7891f;
font-size: 14px;
color: #fff;
border-color: #f7891f;
border: 1px solid #f7891f;
padding: 8px 25px 8px 25px;
-webkit-box-shadow: -1px -1px 8px 0px rgb(50 50 50 / 75%);
-moz-box-shadow: -1px -1px 8px 0px rgba(50, 50, 50, 0.75);
box-shadow: -1px -1px 8px 0px rgb(50 50 50 / 75%);
transition: .5s;
width: 100%;
height: 100%;
max-width: 200px;
}
.visit-h2{
padding: 0px 0px 0px 0px;
font-size: 28px;
font-weight: 500;
margin: 0;
padding: 0;
color: black;
font-family: source sans pro,sans-serif;
}
.visit-h5{
padding: 0px 0px 0px 0px;
font-size: 14px;
font-weight: 500;
margin: 6px 6px 6px 6px;
padding: 0;
color: #636b6f;
font-family: source sans pro,sans-serif;
}
.visit-p{
padding: 0px 0px 0px 0px;
font-size: 12px;
font-weight: 500;
margin: 15px 33px 18px 0px;
padding: 0;
color: #636b6fad;
font-family: source sans pro,sans-serif;
}

h2.lorem-h2 {
    margin: 0 0 25px 0;
}

p.lorem-p {
    margin: 0 0 15px 0;
}

@media only screen and (min-width :991px) and (max-width :1024px){
/*sir*/
.main-box {
margin: 15px 0px 0px 0px;
}
.visit-icon {
font-size: 60px;
padding: 65px 10px 40px 18px;
}
.visit-p {
margin: 8px 20px 8px 0px;
}
.main-lorem {
padding: 30px 30px 30px 30px;
background-color: #65A1C3;
}
.lorem-h2 {
font-size: 38px;
}
.text-padding {
padding: 0px 10px 15px 10px;
}
.main-visit {
text-align: center;
margin: 15px 0px 0px 0px;
}
}
@media only screen and (min-width :768px) and (max-width :991px){

.main-box {
padding: 5px 0px 0px 0px;
margin: 5px 0px 5px 0px;
}
.main-lorem {
padding: 15px 0px 15px 0px;
background-color: #65A1C3;
}
.lorem-h2 {
font-size: 30px;
color: #fff;
margin: 0px 0px 6px 0px;
}
.lorem-p {
    margin: 0px 3px 12px 3px; 
}
.visit-p {
margin: 0px 0px 0px 0px;
}
.text-padding {
padding: 9px 16px 15px 7px;
}
.visit-icon {
font-size: 60px;
padding: 78px 10px 78px 15px;
}
.main-visit {
text-align: center;
margin: 25px 0px 0px 0px;
}
}
@media only screen and (min-width :320px) and (max-width :767px){
	.box-img {
    width: 100%;
    max-width: 60px;
}
.main-lorem {
padding: 0px 0px 0px 0px;
}
.lorem-h2 {
font-size: 22px;
}
.lorem-p {
font-size: 14px;
margin: 0px 3px 0px 3px;
padding: 5px 10px 5px 10px;
}
.main-box {
display: inline-grid;
padding: 0px 0px 0px 0px;
margin: 20px 0px 0px 0px;
}
.text-padding {
padding: 3px 10px 6px 10px;
}
.visit-h2 {
font-size: 22px;
text-align: center;

}
.visit-h5 {
text-align: center;
}
.visit-p {
padding: 0px 0px 0px 0px;
font-size: 10px;
margin: 6px 0px 10px 0px;
text-align: center;

}
.main-visit {
text-align: center;
margin: 15px 0px 15px 0px;
}
.visit-icon {
font-size: 60px;
padding: 0px 0px 0px 0px;
margin: auto;
}
}

.visit-icon img {
    max-width: 350px;
}
section#content div.container-fluid {
    padding-top: 20px;
     min-height: 0vh; 
    width: 100%;
    max-width: 1000px;
}


@media(max-width: 767px){
	.main-box {
	    width: 100%;
	    display: block;
	    text-align: center;
	}
	.visit-icon img {
	    max-width: 100px;
	    margin-top: 15px;
	}
}

img.box-img.add-u {
    max-width: 75px;
}


</style>
<section class="main-lorem">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<p class="lorem-p">Finding the right vendors to work with your business can be a very time consuming task.  Because SpotzCity understands the importance of working with cost effective partners who work with and understand diverse and small businesses, we have vetted partners for you to consider working with.  Please check back often as we will continue to update the page with resources.</p>
			</div>
				
		</div>
	</div>
	<section class="box-padding">
		<div class="row">
			<div class="col-lg-6 col-sm-6">
				<div class="main-box">
					<div class="visit-icon">
						<img src="https://spotzcity.com/assets/storage/logos/klavafundlogo_1280x1280darkthk.png" class="box-img">
					</div>
					<div class="text-padding">
						<h2 class="visit-h2">Klava Fund</h2>
						<h5 class="visit-h5">Other Small Businesses </h5>
						<P class="visit-p">Klava Fund is a true crowdsourced fundraising platform.  We allow you to easily get money for good causes.  One cause we love to support now is raising funds for small businesses.  We love people who support small businesses.  You can help spread the news of Klava Fund to business owners as an ambassador.
						For additional information contact - sklava@klavalabs.com</P>
					</div>
				</div>
				<div class="main-visit">
					<a href="https://klavalabs.com/ambassadors?campaign=spotzcity" target="_blank"><button class="visit-button">VISIT WEBSITE</button></a>
				</div>
			</div>

		
			<div class="col-lg-6 col-sm-6">
				<div class="main-box">
					<div class="visit-icon">
						<img src="https://spotzcity.com/assets/storage/logos/no_logo11.png" class="box-img">
					</div>
					<div class="text-padding">
						<h2 class="visit-h2">Trek World USA</h2>
<!-- 						<h5 class="visit-h5">Black-Owned, Woman-Owned</h5>
 -->						<P class="visit-p">Coming Soon</P>
					</div>
				</div>
				<div class="main-visit">
					<a href="#"><button class="visit-button">Coming Soon</button></a>
				</div>
			</div>
			
			<!-- <div class="col-lg-6 col-sm-6">
				<div class="main-box">
					<div class="visit-icon">
						<img src="https://spotzcity.com/assets/storage/logos/35GlCEbM481Ns7Yqb8v7DhWOdBIMKCiY8P67OPfh.png" class="box-img">
					</div>
					<div class="text-padding">
						<h2 class="visit-h2">Lorem ipsum</h2>
						<h5 class="visit-h5">Black-Owned, Woman-Owned</h5>
						<P class="visit-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur.</P>
					</div>
				</div>
				<div class="main-visit">
					<a href="#"><button class="visit-button">VISIT WEBSITE</button></a>
				</div>
			</div> -->


			<!-- <div class="col-lg-6 col-sm-6">
				<div class="main-box">
					<div class="visit-icon">
						<img src="https://spotzcity.com/assets/storage/logos/35GlCEbM481Ns7Yqb8v7DhWOdBIMKCiY8P67OPfh.png" class="box-img">
					</div>
					<div class="text-padding">
						<h2 class="visit-h2">Lorem ipsum</h2>
						<h5 class="visit-h5">Black-Owned, Woman-Owned</h5>
						<P class="visit-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</P>
					</div>
				</div>
				<div class="main-visit">
					<a href="#"><button class="visit-button">VISIT WEBSITE</button></a>
				</div>
			</div>
		</div> -->

	<!-- 	<div class="col-lg-6 col-sm-6">
				<div class="main-box">
					<div class="visit-icon">
						<img src="https://spotzcity.com/assets/storage/logos/35GlCEbM481Ns7Yqb8v7DhWOdBIMKCiY8P67OPfh.png" class="box-img">
					</div>
					<div class="text-padding">
						<h2 class="visit-h2"> Klava Fund </h2>
						<h5 class="visit-h5">Black-Owned, Woman-Owned</h5>
						<P class="visit-p">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur.</P>
					</div>
				</div>
				<div class="main-visit">
					<a href="https://klavalabs.com/ambassadors?campaign=spotzcity" target="_blank"><button class="visit-button">VISIT WEBSITE</button></a>
				</div>
			</div> -->
	</section>
</section>
@endsection
