<html>
<head>
<meta charset="UTF-8">
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
<title>SpotzCity Business Verification</title>
<style>

  *, *:before, *:after {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  body {
    width: 6.25in;
    height: 4.25in;
    margin: 0;
    padding: 0;
    background-color: white;
  }

  #banner {
    height: 1in;
    background-color: #65a1c3;
    font-family: 'Source Sans Pro';
    font-weight: 700;
    font-size: .16in;
    text-transform: uppercase;
    letter-spacing: .03in;
    color: white;
    text-align: center;
    padding-top: .5in;
  }

  /* do not put text outside of the safe area */
  #safe-area {
    position: absolute;
    width: 5.875in;
    height: 3.875in;
    left: 0.1875in;
    top: 0.1875in;
  }

  #message {
    position: absolute;
    width: 2.2in;
    height: 2in;
    top: 1.1in;
    left: .25in;
    font-family: 'Source Sans Pro';
    font-weight: 400;
    font-size: .122in;
  }

  #code-banner {
    text-align: center;
    font-size: .14in;
  }

  #code {
    font-family: 'Georgia';
    font-weight: 700;
    font-size: .15in;
    letter-spacing: .02in;
    color: #65a1c3;
    border: 2px solid #65a1c3;
    width: 2in;
    padding: .1in;
    margin: .1in auto;
  }

  #logo {
    width: 1.5in;
    position: relative;
    left: .5in;
    top: .1in;
  }

  .accent {
    color: #65a1c3;
  }

</style>
</head>

<body>
  <div id="banner">
    Claim {{$business_name}} today!
  </div>

  <!-- do not put text outside of the safe area -->
  <div id="safe-area">
    <div id="message">
      Hello {{$first_name}},
      <br>
      <br>
      <div id="code-banner">
        Visit <span class="accent">{{$app_url}}/verify</span> and enter this code:
        <div id="code">
          {{$verification_code}}
        </div>
      </div>
      Once you've entered the code, you will have verified your ownership of {{$business_name}}.
      <br><br>
      Thank you,<br>
      <img id="logo" src="https://spotzcity.com/assets/images/logo-color-small.png">
    </div>
  </div>
</body>

</html>
