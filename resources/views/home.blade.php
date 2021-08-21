@extends('app')

@section('content')

<section class="big-bg" style="background-image: url(/assets/images/homepage-hero.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-7 col-md-push-1" style="text-shadow:2px 1px 2px black;">
        <h4>I am <strong>passionate</strong>. I am an <strong>entrepreneur</strong>.</h4>
        <h2>Every entrepreneur had to start somewhere.</h2>
        <!--<p style="font-size:23px;">SpotzCity is an online directory of diverse companies. Companies can be part of the directory for as low as $2.99 a month. The service is free for users who want to search and connect with these companies.</p>-->
		<p style="font-size:23px;">SpotzCity is an online index that entrepreneurs can join to sell their products & services. The site is free for shoppers who want to search and buy from these businesses. </p>
        <a href="#join-form">
          <button class="btn btn-warning jumbo btn-lg shadow">Join SpotzCity</button>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="diversity-types">
  <div class="container">
    <div class="row">
      <h2 class="header text-center">We're focused on inclusiveness and diversity in entrepreneurship.</h2>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=16&page=1" class="thumbnail">
          <img src="/assets/images/women-owned.jpg" alt="Women-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Woman-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=3&page=1" class="thumbnail">
          <img src="/assets/images/black-owned.jpg" alt="Black-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Black-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=10&page=1" class="thumbnail">
          <img src="/assets/images/latinx-owned.jpg" alt="Latina-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>LatinX-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=6&page=1" class="thumbnail">
          <img src="/assets/images/disabled.jpg" alt="Disabled-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Disabled-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=2&page=1" class="thumbnail">
          <img src="/assets/images/asian-owned.jpg" alt="Asian-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Asian-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=14&page=1" class="thumbnail">
          <img src="/assets/images/native.jpg" alt="Native American-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Native American-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=11&page=1" class="thumbnail">
          <img src="/assets/images/lgbtqa.jpg" alt="LGBTQ-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>LGBTQ-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=17&page=1" class="thumbnail">
          <img src="/assets/images/veteran.jpg" alt="Veteran-Owned Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Veteran-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>
	  
	   <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=20&page=1" class="thumbnail">
          <img src="/assets/images/Arabic_33303725_m.jpg" alt="Arabic-Owned" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Arabic-Owned</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

       <div class="col-xs-12 col-md-6">
        <a href="/search?sort=most_reviews&categories=18&page=1" class="thumbnail">
          <img src="/assets/images/other.jpg" alt="Other Businesses" />
          <div class="thumbnail-overlay text-center">
            <div class="vert-align">
              <h3>Other Small Businesses</h3>
              <p class="text-white text-size-lg">Click to view</p>
            </div>
          </div>
        </a>
      </div>

    </div>
  </div>
</section>

<section class="alone">
  <div class="container">
    <h1 class="header text-center">You're not alone with SpotzCity</h1>
    <div class="row text-center">
      <div class="col-xs-12 col-md-6 icon-feature">
        <i class="icon-energy"></i>
        <br/>
        <br/>
        <br/>
        <p>Find new customers across the US as well as training and development from industry leaders to help you market, grow & run your business more efficiently.</p>
      </div>
      <div class="col-xs-12 col-md-6 icon-feature">
        <i class="icon-clock"></i>
        <br/>
        <br/>
        <br/>
        <p>Save time and stress by quickly accessing essential business resources for whatever kind of business you run, from food trucks to licensing.</p>
      </div>
      <div class="col-xs-12 col-md-6 icon-feature">
        <i class="icon-heart"></i>
        <br/>
        <br/>
        <br/>
        <p>List your business or invest in a small business. You can also increase your buying & support of small businesses across the United States.</p>
      </div>
      <div class="col-xs-12 col-md-6 icon-feature">
        <i class="icon-user"></i>
        <br/>
        <br/>
        <br/>
        <p>With a subscription your business gets a dedicated web page for digital presence, and you gain access to a list of events to attend throughout the United States.</p>
      </div>
    </div>
    <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
      <h2>Learn more by watching</h2>
      <br/>
      <iframe width="700" height="394" src="https://www.youtube.com/embed/J9oajnwjNuM" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="max-width: 100%;"></iframe>
      {{-- <img class="img-responsive" src="/assets/images/screen.png"/> --}}
    </div>
  </div>
</section>

<!--<section class="join-form">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-5 col-lg-6 side-image">
      </div>
      <div id="join-form" class="col-xs-12 col-md-7 col-lg-6 form">
        <h3 class="text-center">Start Your Business Journey and join SpotzCity today!</h3>
        <div class="row">
          <form role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}
            <div class="col-xs-12 col-md-6 form-group form-group-lg">
              <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name" required />
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg">
              <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Last Name" required />
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg">
              <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" required />
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg">
              <input id="phone" type="tel" class="form-control" name="phone" placeholder="Phone"/>
            </div>
            <br/>
            <div class="col-xs-12 col-md-6 form-group form-group-lg" style="margin-top: 15px;">
              <input id="password" type="password" class="form-control" name="password" placeholder="Password" required />
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg" style="margin-top: 15px;">
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required />
              <input name="extra" type="text" style="visibility:hidden;" />
            </div>
            <div type="submit" class="col-xs-12 text-center" style="margin-top: 30px;">
              <button class="btn btn-lg btn-warning jumbo shadow">Join SpotzCity</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>-->
<style>
.col-xs-12.col-md-6:nth-child(6) {
  clear: left !important;
}
</style>

<section class="join-form">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-5 col-lg-6 side-image">
      </div>
      <div id="join-form" class="col-xs-12 col-md-7 col-lg-6 form">
        <h3 class="text-center">Start Your Business Journey and join SpotzCity today!</h3>
        <form role="form" method="POST" action="{{ url('/register') }}" id="homePageSignUp">
            {{ csrf_field() }}
        <div class="row">
          
            <div class="col-xs-12 col-md-6 form-group form-group-lg {{ $errors->has('first_name') ? ' has-error' : '' }}">
              <input id="first_name" type="text" class="form-control" name="first_name" placeholder="First Name" required />
                    <span class="help-block-fname" style="display:none;color:#a94442">
                        <strong>The first name field is required.</strong>
                    </span>
              @if ($errors->has('first_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('first_name') }}</strong>
                                  </span>
                              @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg {{ $errors->has('last_name') ? ' has-error' : '' }}">
              <input id="last_name" type="text" class="form-control" name="last_name" placeholder="Last Name" required />
              <span class="help-block-lname" style="display:none;color:#a94442">
                        <strong>The last name field is required.</strong>
                    </span>
              @if ($errors->has('last_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('last_name') }}</strong>
                                  </span>
                              @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg {{ $errors->has('email') ? ' has-error' : '' }}">
              <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" required />
              <span class="help-block-email" style="display:none;color:#a94442">
                        <strong>Email already exist</strong>
                    </span>
                    <span class="help-block-email-empty" style="display:none;color:#a94442">
                        <strong>The email field is required.</strong>
                    </span>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg">
              <input id="phone" type="tel" class="form-control" name="phone" placeholder="Phone"/>
              <span class="help-block-mobile_number" style="display:none;color:#a94442">
                        <strong>The phone field is required.</strong>
                    </span>
					<span class="help-block-mobile_number-valid" style="display:none;color:#a94442">
                        <strong>The phone field is invalid.</strong>
                    </span>
            </div>
            
            <br/>
            <div class="col-xs-12 col-md-6 form-group form-group-lg {{ $errors->has('password') ? ' has-error' : '' }}" style="margin-top: 15px;">
              <input id="password" type="password" class="form-control" name="password" placeholder="Password" required />
              <span class="help-block-password" style="display:none;color:#a94442">
                        <strong>Password not match</strong>
                    </span>
                    <span class="help-block-password-empty" style="display:none;color:#a94442">
                        <strong>The password field is required.</strong>
                    </span>
              @if ($errors->has('password'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
            </div>
            <div class="col-xs-12 col-md-6 form-group form-group-lg {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" style="margin-top: 15px;">
              <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required />
              <span class="help-block-password_confirmation" style="display:none;color:#a94442">
                        <strong>The password confirmation field is required.</strong>
                    </span>
              @if ($errors->has('password_confirmation'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                                  </span>
                              @endif
              <input name="extra" type="text" style="visibility:hidden;" />
            </div>
            
            <div class="col-xs-12 text-center" style="margin-top: 30px;">
              <button type="button" onclick="toSubmit()" class="btn btn-lg btn-warning jumbo shadow" >Join SpotzCity</button>
            </div>
          
        </div>
      </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  // Quick Hack to equalize image column height
  document.querySelector('div.side-image').style.height = `${document.querySelector('div.form').clientHeight}px`
</script>

<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Join SpotzCity</h4>
        </div>
        <div class="modal-body">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="first_name" class="col-md-4 control-label">First Name</label>

                <div class="col-md-6">
                    <input id="first_name-modal" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                    @if ($errors->has('first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="last_name" class="col-md-4 control-label">Last Name</label>

                <div class="col-md-6">
                    <input id="last_name-modal" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                    @if ($errors->has('last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                <div class="col-md-6">
                    <input id="email-modal" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                    <input id="password-modal" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                <div class="col-md-6">
                    <input id="password-confirm-modal" type="password" class="form-control" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">
            Register
          </button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- <div style="position:fixed;bottom:0px;left:0px;width:100vw;height:auto;padding:10px;background:#67b0cf;z-index:999;box-shadow: 0px 0px 20px -5px rgba(0,0,0,0.25);">
 --><!--   <div class="container">
 --><!--     <div class="row">
 --><!--       <div class="col-sm-8 col-xs-12">
 -->        <!-- <h4 style="color:white;margin:0;margin-top:14px;"><strong id="countdown"></strong> until the SpotzCity Launch Party!</h4> -->
<!--       </div>
 -->      <!-- <div class="col-sm-4 col-xs-12">
        <a class="btn btn-warning btn-lg pull-right" href="https://spotzcitylaunch.eventbrite.com/" target="_blank">Sign up here</a>
      </div> -->
<!--     </div>
 -->  
<!-- </div>
 -->
<!-- </div> -->
<script>
  function countdownTimer() {
    const difference = +new Date("2021-03-26 19:00:00") - +new Date();
    let remaining = "Time's up!";

    if (difference > 0) {
      const parts = {
        days: Math.floor(difference / (1000 * 60 * 60 * 24)),
        hours: Math.floor((difference / (1000 * 60 * 60)) % 24),
        minutes: Math.floor((difference / 1000 / 60) % 60),
        seconds: Math.floor((difference / 1000) % 60),
      };
      remaining = Object.keys(parts).map(part => {
        return `${parts[part]} ${part}`;
      }).join(" ");
    }

    document.getElementById("countdown").innerHTML = remaining;
  }
  countdownTimer();
  setInterval(countdownTimer, 1000);
</script>
<script>
 
   function toSubmit(){
        // console.log('to Submit');
        // let first_name = $('#first_name').val();
        // if(first_name) {
        //   return true;
        // } else {
        //   return false;
        // }
        let first_name = $('#first_name').val();
        let last_name = $('#last_name').val();
        let email = $('#email').val();
        let mobile_number = $('#phone').val();
        let password = $('#password').val();
        let password_confirmation = $('#password_confirmation').val();

        if(first_name == ''){
          $(".help-block-fname").show()
          
        }else{
          $(".help-block-fname").hide()
          
        }
        
        if(last_name == ''){
          $(".help-block-lname").show()
          
        }else{
          $(".help-block-lname").hide()
         
        }

        if(email == ''){
          $(".help-block-email-empty").show()
          
        }else{
          $(".help-block-email-empty").hide()
         
        }

        /* if(mobile_number == ''){
          $(".help-block-mobile_number").show()
          
        }else{
          $(".help-block-mobile_number").hide()
         
        } */
		
		intRegex = /[0-9 -()+]+$/;
        if((mobile_number.length < 6) || (!intRegex.test(mobile_number))){
          $(".help-block-mobile_number-valid").show()
        }else{
          $(".help-block-mobile_number-valid").hide()
        }

        if(password == ''){
          $(".help-block-password-empty").show()
          
        }else{
          $(".help-block-password-empty").hide()
         
        }

        if(password_confirmation == ''){
          $(".help-block-password_confirmation").show()
          
        }else{
          $(".help-block-password_confirmation").hide()
          
        }
        


    $.ajax({
        type: "POST",
        url: '/homePageSignUp',
        data:{
            "_token": "{{ csrf_token() }}",
            first_name:first_name,
            last_name:last_name,
            email:email,
            mobile_number:mobile_number,
            password:password,
            password_confirmation:password_confirmation,
          },
    }).done(function( msg ) {
        console.log(msg);

        if(msg == "email exist"){
          $(".help-block-email").show()
          $(".help-block-password").hide()
          //return false;
        }else if(msg == "password not match"){
          $(".help-block-email").hide()
          $(".help-block-password").show()
          //return false;
        }else if(msg == "match"){
          $(".help-block-email").hide()
          $(".help-block-password").hide()
          $("#homePageSignUp").submit();
          //return true;
         
        }
        
    });
    //return false;*/
     
   }

</script>
<!-- Begin Constant Contact Active Forms -->
<script> var _ctct_m = "c05c441a0e76e6077bf6684f28e32c76"; </script>
<script id="signupScript" src="//static.ctctcdn.com/js/signup-form-widget/current/signup-form-widget.min.js" async defer></script>
<!-- End Constant Contact Active Forms -->

@stop
