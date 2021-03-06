<!DOCTYPE html>
<html>
<head>
  <title>Social Media Integration</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="../assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="../assets/css/theme/yellow.css">

</head>
<body>
  <div class="app app-default">

<div class="app-container app-login">
  <div class="flex-center">
    <div class="app-header"></div>
    <div class="app-body">
      <div class="loader-container text-center">
          <div class="icon">
            <div class="sk-folding-cube">
                <div class="sk-cube1 sk-cube"></div>
                <div class="sk-cube2 sk-cube"></div>
                <div class="sk-cube4 sk-cube"></div>
                <div class="sk-cube3 sk-cube"></div>
              </div>
            </div>
          <div class="title">Logging in...</div>
      </div>
      <div class="app-block">
        <div class="app-right-section">
          <div class="app-brand"><span class="highlight">Social Media</span> Integration</div>
          <div class="app-info">


            <div class="row">
           
            @if(Session::has('instagram'))
              <div class="col-md-4">
                <div class="card card-mini">
                  <div class="card-header text-center">
                    Instagram
                  </div>
                  <div class="card-body text-center">
                    <img class="profile-img" style="width:100px;height:100px;border-radius:100px" src="{{ Session::get('instagram')['user']['profile_picture'] }}">
                    <div class="app-title">
                      {{-- <div class="title"><span class="highlight">Ayat Maulana</span></div> --}}
                      <br>
                      <h4 class="media-heading"><a href="{{ url('/history') }}">{{ Session::get('instagram')['user']['username'] }}</a></h4>
                      <br>
                      <span class="badge badge-success badge-icon"><i class="fa fa-circle" aria-hidden="true"></i><span>Connected</span></span>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="col-md-4">
                <a href="https://www.instagram.com/oauth/authorize/?client_id=42d6172648ba4550b254c2aed5a2ba55&redirect_uri=http://localhost:8000/auth_instagram&scope=likes+comments+public_content+follower_list&response_type=code" type="button" class="btn btn-default btn-sm btn-social __instagram">
                  <div class="info">
                    <i class="icon fa fa-instagram" aria-hidden="true"></i>
                    <span class="title">Connect Instagram</span>
                  </div>
                </a>
              </div>
            @endif

            @if(Session::has('facebook'))
              <div class="col-md-4">
                <div class="card card-mini">
                  <div class="card-header text-center">
                    Facebook
                  </div>
                  <div class="card-body text-center">
                    <img class="profile-img" style="width:100px;height:100px;border-radius:100px" src="{{ Session::get('facebook')['profile']['picture']['data']['url'] }}">
                    <div class="app-title">
                      {{-- <div class="title"><span class="highlight">Ayat Maulana</span></div> --}}
                      <br>
                      <h4 class="media-heading"><a href="{{ url('history') }}">{{ Session::get('facebook')['profile']['name'] }}</a></h4>
                      <br>
                      <span class="badge badge-success badge-icon"><i class="fa fa-circle" aria-hidden="true"></i><span>Connected</span></span>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <div class="col-md-4">
                <a href="{{ url('auth_facebook') }}" type="button" class="btn btn-default btn-sm btn-social __facebook">
                    <div class="info">
                      <i class="icon fa fa-facebook-official" aria-hidden="true"></i>
                      <span class="title">Connect Facebook</span>
                    </div>
                </a>
              </div>
            @endif

                        @if(Session::has('twitter'))
                          @if (Session::has('twitter')['token'])
                            <?php  
                              $avatar = Session::get('twitter')['avatar'];
                              $nickname = Session::get('twitter')['nickname'];
                            ;?>
                          @else
                            <?php  
                              $avatar = Session::get('twitter')->avatar;
                              $nickname = Session::get('twitter')->nickname;
                            ;?>
                          @endif
              <div class="col-md-4">
                <div class="card card-mini">
                  <div class="card-header text-center">
                    Twitter
                  </div>
                  <div class="card-body text-center">
                    <img class="profile-img" style="width:100px;height:100px;border-radius:100px" src="{{ $avatar }} ">
                    <div class="app-title">
                      {{-- <div class="title"><span class="highlight">Ayat Maulana</span></div> --}}
                      <br>
                      <h4 class="media-heading"><a href="{{ url('/history') }}">{{ $nickname }}</a></h4>
                      <br>
                      <span class="badge badge-success badge-icon"><i class="fa fa-circle" aria-hidden="true"></i><span>Connected</span></span>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="col-md-4">
                <a href="{{ url('auth_twitter') }}" class="btn btn-default btn-sm btn-social __twitter">
                  <div class="info">
                    <i class="icon fa fa-twitter" aria-hidden="true"></i>
                    <span class="title">Connect Twitter</span>
                  </div>
                </a>
              </div>
            @endif

            </div>
            

            {{-- <ul class="list">
              <li>
                <div class="icon">
                  <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                </div>
                <div class="title">Increase <b>Productivity</b></div>
              </li>
              <li>
                <div class="icon">
                  <i class="fa fa-cubes" aria-hidden="true"></i>
                </div>
                <div class="title">Lot of <b>Components</b></div>
              </li>
              <li>
                <div class="icon">
                  <i class="fa fa-usd" aria-hidden="true"></i>
                </div>
                <div class="title">Forever <b>Free</b></div>
              </li>
            </ul> --}}
          </div>
        </div>
      </div>
    </div>
    <div class="app-footer">
    </div>
  </div>
</div>

  </div>
  
  <script type="text/javascript" src="../assets/js/vendor.js"></script>
  <script type="text/javascript" src="../assets/js/app.js"></script>

</body>
</html>