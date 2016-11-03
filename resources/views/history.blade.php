<!DOCTYPE html>
<html>
  <head>
    <title>Sosial Media Integration</title>
    
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
                <li class="dropdown notification">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon"><i class="fa fa-instagram" aria-hidden="true"></i></div>
                    <div class="title">New Orders</div>
                    <div class="count">0</div>
                  </a>
                  <div class="dropdown-menu">
                    <ul>
                      <li class="dropdown-header">Ordering</li>
                      <li class="dropdown-empty">No New Ordered</li>
                      <li class="dropdown-footer">
                        <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="dropdown notification primary">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon"><i class="fa fa-facebook" aria-hidden="true"></i></div>
                    <div class="title">Unread Messages</div>
                    <div class="count">99</div>
                  </a>
                  <div class="dropdown-menu">
                    <ul>
                      <li class="dropdown-header">Message</li>
                      <li>
                        <a href="#">
                          <span class="badge badge-warning pull-right">10</span>
                          <div class="message">
                            <img class="profile" src="https://placehold.it/100x100">
                            <div class="content">
                              <div class="title">"Payment Confirmation.."</div>
                              <div class="description">Alan Anderson</div>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge badge-warning pull-right">5</span>
                          <div class="message">
                            <img class="profile" src="https://placehold.it/100x100">
                            <div class="content">
                              <div class="title">"Hello World"</div>
                              <div class="description">Marco  Harmon</div>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge badge-warning pull-right">2</span>
                          <div class="message">
                            <img class="profile" src="https://placehold.it/100x100">
                            <div class="content">
                              <div class="title">"Order Confirmation.."</div>
                              <div class="description">Brenda Lawson</div>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li class="dropdown-footer">
                        <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="dropdown notification info">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon"><i class="fa fa-twitter" aria-hidden="true"></i></div>
                    <div class="title">System Notifications</div>
                    <div class="count">10</div>
                  </a>
                  <div class="dropdown-menu">
                    <ul>
                      <li class="dropdown-header">Notification</li>
                      <li>
                        <a href="#">
                          <span class="badge badge-danger pull-right">8</span>
                          <div class="message">
                            <div class="content">
                              <div class="title">New Order</div>
                              <div class="description">$400 total</div>
                            </div>
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge badge-danger pull-right">14</span>
                          Inbox
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge badge-danger pull-right">5</span>
                          Issues Report
                        </a>
                      </li>
                      <li class="dropdown-footer">
                        <a href="#">View All <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                      </li>
                    </ul>
                  </div>
                </li>
                <li class="dropdown profile">
                  <a href="/html/pages/profile.html" class="dropdown-toggle"  data-toggle="dropdown">
                    <img class="profile-img" src="./assets/images/profile.png">
                    <div class="title">Profile</div>
                  </a>
                  <div class="dropdown-menu">
                    <div class="profile-info">
                      <h4 class="username">Scott White</h4>
                    </div>
                    <ul class="action">
                      <li>
                        <a href="#">
                          Profile
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <span class="badge badge-danger pull-right">5</span>
                          My Inbox
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          Setting
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          Logout
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>
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
                    @foreach ($data['instagram'] as $element)
                        <tr role="row" class="odd">
                          <td class=""><small>{{ $element->konten }}</small></td>
                          <td class="" style="width:10px !important"><small><img style="width:100px;height:100px" src="{{ $element->media }}"></small></td>
                          <td class="sorting_1">{{ date('Y-M-d h:i:s',$element->waktu) }}</td>
                          <td>Instagram</td>
                          <td>{{ $element->link }}</td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
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