<?php include_once 'header.php'; 
require '../helpers/init_conn_db.php'; ?>

<link rel="stylesheet" href="../assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300&family=Poiret+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<style>
  body {
    background-color: #efefef;
  }
  td {
    font-size: 18px !important;
  }
  p {
    font-size: 35px;
    font-weight: 100;
    font-family: 'product sans';  
  }  

  .main-section {
    width: 100%;
    margin: 0 auto;
    text-align: center;
    padding: 0px 5px;
  }
  .dashbord {
    width: 23%;
    display: inline-block;
    background-color: #34495E;
    color: #fff;
    margin-top: 50px; 
  }
  .icon-section i {
    font-size: 30px;
    padding: 10px;
    border: 1px solid #fff;
    border-radius: 50%;
    margin-top: -25px;
    margin-bottom: 10px;
    background-color: #34495E;
  }
  .icon-section p {
    margin: 0px;
    font-size: 20px;
    padding-bottom: 10px;
  }
  .detail-section {
    background-color: #2F4254;
    padding: 5px 0px;
  }
  .dashbord .detail-section:hover {
    background-color: #5a5a5a;
    cursor: pointer;
  }
  .detail-section a {
    color: #fff;
    text-decoration: none;
  }
  .dashbord-2 .icon-section, .dashbord-2 .icon-section i {
    background-color: #9CB4CC;
  }
  .dashbord-2 .detail-section {
    background-color: #149077;
  }
  .dashbord-1 .icon-section, .dashbord-1 .icon-section i {
    background-color: #2980B9;
  }
  .dashbord-1 .detail-section {
    background-color: #2573A6;
  }
  .dashbord-3 .icon-section, .dashbord-3 .icon-section i {
    background-color: #316B83;
  }
  .dashbord-3 .detail-section {
    background-color: #CF4436;
  }
</style>

<main>
    <?php if (isset($_SESSION['adminId'])) { ?>
        <div class="container">
            <div class="main-section">
                <div class="dashbord dashbord-1">
                    <div class="icon-section">
                        <i class="fa fa-users" aria-hidden="true"></i><br>
                        Total Passengers
                        <p><?php include 'psngrcnt.php'; ?></p>
                    </div>
                </div>
                <div class="dashbord dashbord-2">
                    <div class="icon-section">
                        <i class="fa fa-money" aria-hidden="true"></i><br>
                        Amount
                        <p>$ <?php include 'amtcnt.php'; ?></p>
                    </div>
                </div>
                <div class="dashbord dashbord-3">
                    <div class="icon-section">
                        <i class="fa fa-plane" aria-hidden="true"></i><br>
                        Flights
                        <p><?php include 'flightscnt.php'; ?></p>
                    </div>
                </div>
                <div class="dashbord">
                    <div class="icon-section">
                        <i class="fa fa-plane fa-rotate-180" aria-hidden="true"></i><br>
                        Available Airlines
                        <p><?php include 'airlcnt.php'; ?></p>
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="flight">
                <div class="card-body">
                    <div class="dropdown" style="float: right;">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#flight">Today's Flights</a>
                            <a class="dropdown-item" href="#issue">Today's Flight Issues</a>
                            <a class="dropdown-item" href="#dep">Flights Departed Today</a>
                            <a class="dropdown-item" href="#arr">Flights Arrived Today</a>
                        </div>
                    </div>
                    <p class="text-secondary">Today's Flights</p>
                    <table class="table-sm table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">AIRLINE</th>
                                <th scope="col">SOURCE</th>
                                <th scope="col">DESTINATION</th>
                                <th scope="col">DEPARTURE DATE</th>
                                <th scope="col">ARRIVAL DATE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $curr_date = '20' . date('y-m-d');
                            $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                            $stmt = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $curr_date);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['status'] == '') {
                                    echo "
                                    <tr>
                                        <td scope='row'>
                                            <a href='pass_list.php?flight_id={$row['flight_id']}' style='text-decoration:underline;'>
                                                {$row['flight_id']}
                                            </a>
                                        </td>
                                        <td>{$row['airline']}</td>
                                        <td>{$row['source']}</td>
                                        <td>{$row['Destination']}</td>
                                        <td>{$row['departure']}</td>
                                        <td>{$row['arrivale']}</td>
                                        <td class='options'>
                                            <div class='dropdown'>
                                                <a class='text-reset text-decoration-none' href='#' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fa fa-ellipsis-v'></i>
                                                </a>
                                                <div class='dropdown-menu'>
                                                    <form class='px-4 py-3' action='../includes/admin/admin.inc.php' method='post'>
                                                        <input type='hidden' name='flight_id' value='{$row['flight_id']}'>
                                                        <div class='form-group'>
                                                            <label for='issue'>Enter time in min.</label>
                                                            <input type='number' class='form-control' name='issue' placeholder='Eg. 120'>
                                                        </div>
                                                        <button type='submit' name='issue_but' class='btn btn-danger btn-sm'>Submit Issue</button>
                                                        <div class='dropdown-divider'></div>
                                                        <button type='submit' name='dep_but' class='btn btn-primary btn-sm'>Departed</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" id="issue">
                <div class="card-body">
                    <div class="dropdown" style="float: right;">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#flight">Today's Flights</a>
                            <a class="dropdown-item" href="#issue">Today's Flight Issues</a>
                            <a class="dropdown-item" href="#dep">Flights Departed Today</a>
                            <a class="dropdown-item" href="#arr">Flights Arrived Today</a>
                        </div>
                    </div>
                    <p class="text-secondary">Today's Flight Issues</p>
                    <table class="table-sm table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">AIRLINE</th>
                                <th scope="col">SOURCE</th>
                                <th scope="col">DESTINATION</th>
                                <th scope="col">DEPARTURE DATE</th>
                                <th scope="col">ARRIVAL DATE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $curr_date = '20' . date('y-m-d');
                            $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                            $stmt = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $curr_date);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['status'] == 'issue') {
                                    echo "
                                    <tr>
                                        <td scope='row'>
                                            <a href='pass_list.php?flight_id={$row['flight_id']}'>
                                                {$row['flight_id']}
                                            </a>
                                        </td>
                                        <td>{$row['airline']}</td>
                                        <td>{$row['source']}</td>
                                        <td>{$row['Destination']}</td>
                                        <td>{$row['departure']}</td>
                                        <td>{$row['arrivale']}</td>
                                        <td class='options'>
                                            <div class='dropdown'>
                                                <a class='text-reset text-decoration-none' href='#' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fa fa-ellipsis-v'></i>
                                                </a>
                                                <div class='dropdown-menu'>
                                                    <form class='px-4 py-3' action='../includes/admin/admin.inc.php' method='post'>
                                                        <input type='hidden' name='flight_id' value='{$row['flight_id']}'>
                                                        <button type='submit' name='issue_solved_but' class='btn btn-danger btn-sm'>Issue Solved!</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" id="dep">
                <div class="card-body">
                    <div class="dropdown" style="float: right;">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#flight">Today's Flights</a>
                            <a class="dropdown-item" href="#issue">Today's Flight Issues</a>
                            <a class="dropdown-item" href="#dep">Flights Departed Today</a>
                            <a class="dropdown-item" href="#arr">Flights Arrived Today</a>
                        </div>
                    </div>
                    <p class="text-secondary">Flights Departed Today</p>
                    <table class="table-sm table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">AIRLINE</th>
                                <th scope="col">SOURCE</th>
                                <th scope="col">DESTINATION</th>
                                <th scope="col">DEPARTURE DATE</th>
                                <th scope="col">ARRIVAL DATE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $curr_date = '20' . date('y-m-d');
                            $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                            $stmt = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $curr_date);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['status'] == 'dep') {
                                    echo "
                                    <tr>
                                        <td scope='row'>
                                            <a href='pass_list.php?flight_id={$row['flight_id']}'>
                                                {$row['flight_id']}
                                            </a>
                                        </td>
                                        <td>{$row['airline']}</td>
                                        <td>{$row['source']}</td>
                                        <td>{$row['Destination']}</td>
                                        <td>{$row['departure']}</td>
                                        <td>{$row['arrivale']}</td>
                                        <td class='options'>
                                            <div class='dropdown'>
                                                <a class='text-reset text-decoration-none' href='#' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                    <i class='fa fa-ellipsis-v'></i>
                                                </a>
                                                <div class='dropdown-menu'>
                                                    <form action='../includes/admin/admin.inc.php' method='post'>
                                                        <input type='hidden' name='flight_id' value='{$row['flight_id']}'>
                                                        <button type='submit' name='arr_but' class='btn btn-danger'>Arrived</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-4" id="arr">
                <div class="card-body">
                    <div class="dropdown" style="float: right;">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-filter"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#flight">Today's Flights</a>
                            <a class="dropdown-item" href="#issue">Today's Flight Issues</a>
                            <a class="dropdown-item" href="#dep">Flights Departed Today</a>
                            <a class="dropdown-item" href="#arr">Flights Arrived Today</a>
                        </div>
                    </div>
                    <p class="text-secondary">Flights Arrived Today</p>
                    <table class="table-sm table table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">AIRLINE</th>
                                <th scope="col">SOURCE</th>
                                <th scope="col">DESTINATION</th>
                                <th scope="col">DEPARTURE DATE</th>
                                <th scope="col">ARRIVAL DATE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $curr_date = '20' . date('y-m-d');
                            $sql = "SELECT * FROM Flight WHERE DATE(departure)=?";
                            $stmt = mysqli_stmt_init($conn);
                            mysqli_stmt_prepare($stmt, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $curr_date);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['status'] == 'arr') {
                                    echo "
                                    <tr>
                                        <td scope='row'>
                                            <a href='pass_list.php?flight_id={$row['flight_id']}'>
                                                {$row['flight_id']}
                                            </a>
                                        </td>
                                        <td>{$row['airline']}</td>
                                        <td>{$row['source']}</td>
                                        <td>{$row['Destination']}</td>
                                        <td>{$row['departure']}</td>
                                        <td>{$row['arrivale']}</td>
                                    </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</main>
<?php include_once 'footer.php'; ?>
