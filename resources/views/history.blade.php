<!DOCTYPE html>
<html>
  <head>
    <title>Sosial Media Integration</title>
    <style>
      td{
        word-wrap: break-word;
      }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./assets/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/flat-admin.css">
    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="./assets/css/theme/blue-sky.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/theme/blue.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/theme/red.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/theme/yellow.css">
  </head>
  <body>
    <div >
      <div >
        <nav class="navbar navbar-default" id="navbar">
          <div class="container-fluid">
            <div class="navbar-collapse collapse in">
              <ul class="nav navbar-nav navbar-mobile">
                <li>
                  <button type="button" class="sidebar-toggle">
                  <i class="fa fa-bars"></i>
                  </button>
                </li>
                <li class="logo">
                </li>
                <li>
                  <button type="button" class="navbar-toggle">
                  <img class="profile-img" src="./assets/images/profile.png">
                  </button>
                </li>
              </ul>
              <ul class="nav navbar-nav navbar-left">
                <li class="navbar-title">Social Media Integration</li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                @if (Session::has('instagram'))
                <li class="dropdown notification">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <div class="title"></div>
                    <div class="count">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                  </a>
                  <div class="dropdown-menu">
                    <ul>
                      <li class="dropdown-header">Instagram</li>
                      <li class="dropdown-footer">
                        <a href="{{ url('/logout/instagram') }}">Logout <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div>
                </li>
                @endif
                @if (Session::has('facebook'))
                <li class="dropdown notification primary">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                    <div class="title"></div>
                    <div class="count">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                  </a>
                  <div class="dropdown-menu">
                    <ul>
                      <li class="dropdown-header">Facebook</li>
                      <li class="dropdown-footer">
                        <a href="{{ url('/logout/facebook') }}">Logout <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div>
                </li>
                @endif
                @if (Session::has('twitter'))
                <li class="dropdown notification info">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                    <div class="title"></div>
                    <div class="count">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </div>
                  </a>
                  <div class="dropdown-menu">
                    <ul>
                      <li class="dropdown-header">Twitter</li>
                      <li class="dropdown-footer">
                        <a href="{{ url('/logout/twitter') }}">Logout <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div>
                </li>
                @endif
              </ul>
            </div>
          </div>
        </nav>
        
        <div class="row">
          <div class="container-fluid">
          <div class="col-xs-12">
            <div class="card">
              <div class="card-header">
                Your Post
              </div>
              <div class="card-body no-padding">
                {{-- <table class=" datatable table table-striped primary dataTable no-footer" cellspacing="0" width="100%" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info" style="width: 100%;">
                  <thead>
                    <tr role="row">
                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 99px;">Konten</th>
                      <th style="widht:50px" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 144px;">Media</th>
                      <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Office: activate to sort column descending" style="width: 75px;" aria-sort="ascending">Waktu</th>
                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 26px;">Sosmed</th>
                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 75px;">Link</th>
                  </thead>
                  <tbody>                  
                    @foreach ($data['instagram'] as $element)
                      <tr role="row" class="odd">
                        <td class=""><small>{{ $element->konten }}</small></td>
                        <td class="" style="widht:50px"><small>{{ $element->media }}</small></td>
                        <td class="sorting_1">{{ $element->waktu }}</td>
                        <td>{{ $element->sosmed }}</td>
                        <td>{{ $element->link }}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table> --}}

                <table class="table">
                  <thead>
                    <tr>
                      <th>Konten</th>
                      <th style="width:50px">Media</th>
                      <th>Waktu</th>
                      <th>Sosmed</th>
                      <th>Link</th>
                    </tr>
                  </thead>
                  <tbody class="width:100%">
                    {{-- @for ($i = 0; $i < count($data['sosmed'])-1 ; $i++) --}}
                      @foreach ($data['sosmed'] as $element)
                          <tr role="row" class="odd">
                            <td class=""><small>{{ $element->konten }}</small></td>
                            <td class="" style="width:10px !important">
                            @if ($element->media != '')
                              <a target="_blank" href="{{ $element->media }}"><img style="width:100px;height:100px" src="{{ $element->media }}"></a>
                            @else
                              <img src="https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw_400x400.jpg" style="width:100px;height:100px">
                            @endif
                            </td>
                            <td class="sorting_1">{{ date("D d-M-Y h:i:s",$element->waktu) }}</td>
                            <td>{{ $element->source }}</td>
                            <td><a href="{{ $element->link }}" target="_blank">Link</a></td>
                          </tr>
                      @endforeach
                    {{-- @endfor --}}
                  </tbody>
                </table>
                <div class="row">
                  <div class="col-md-12 text-center">
                    {{-- {{ $data['sosmed']->render() }} --}}
                  </div>
                </div>
            </div>
          </div>
        </div>
        </div>
      </div>

<script type="text/javascript" src="./assets/js/vendor.js"></script>
<script type="text/javascript" src="./assets/js/app.js"></script>
<script>
$(function(){
  // $('table').DataTable({
  // "columnDefs": [
  //   { "width": "20%", "targets": 0 }
  // ]
  // });
})
</script>
</body>
</html>